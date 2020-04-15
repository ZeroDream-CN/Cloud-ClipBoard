<?php
error_reporting(0);

if(php_sapi_name() !== "cli") {
	exit("This program only can running on cli mode");
}

$ws = new Swoole\WebSocket\Server("0.0.0.0", 884);

// 维护一个 Table 用于储存对应用户的 Key
$table = new Swoole\Table(65536);
$table->column('storage', swoole_table::TYPE_STRING, 8192);
$table->create();

$ws->table = $table;

// 客户端连接建立事件
$ws->on('open', function ($ws, $request) {
	echo "Client-{$request->fd} connect to server\n";
	$uri = $request->server['request_uri'] ?? "/";
	$uri = substr($uri, 1, strlen($uri) - 1);
	$clients = json_decode($ws->table->get('clients', 'storage'), true);
	if(!$clients) {
		$clients = [];
	}
	if(stristr($uri, "/")) {
		$exp = explode("/", $uri);
		if(isset($exp[1]) && !empty($exp[1])) {
			$clients[$request->fd] = sha1($exp[1]);
			$ws->table->set('clients', ["storage" => json_encode($clients)]);
		} else {
			$ws->push($request->fd, json_encode(Array(
				"type" => "msg",
				"data" => "密钥不能为空！"
			)));
			$ws->disconnect($request->fd);
		}
	} else {
		$ws->push($request->fd, json_encode(Array(
			"type" => "msg",
			"data" => "密钥不能为空！"
		)));
		$ws->disconnect($request->fd);
	}
});

// 客户端发送消息事件
$ws->on('message', function ($ws, $frame) {
	$clients = json_decode($ws->table->get('clients', 'storage'), true);
	$clientKey = $clients[$frame->fd] ?? false;
	$json = json_decode($frame->data, true);
	if($json) {
		if(isset($json['action'])) {
			switch($json['action']) {
				case "hearbeat":
					$ws->push($frame->fd, json_encode(Array(
						"type" => "hearbeat",
						"timestamp" => time(),
					)));
					break;
				case "send":
					if(isset($json['data'])) {
						if(strlen($json['data']) > 32768) {
							$ws->push($frame->fd, json_encode(Array(
								"type" => "msg",
								"data" => "超过了最大可接受的字符串长度 32768"
							)));
						} else {
							$data = json_encode([
								"type" => "paste",
								"time" => date("Y-m-d H:i:s"),
								"data" => htmlspecialchars($json['data'])
							]);
							foreach($clients as $client => $ck) {
								if($ws->isEstablished($client)) {
									echo "{$frame->fd} => {$ck}/{$clientKey}\n";
									if($ck === $clientKey) {
										$ws->push($client, $data);
									}
								}
							}
						}
					}
					break;
			}
		} else {
			$ws->push($frame->fd, json_encode(Array(
				"type" => "msg",
				"data" => "错误：Bad Request，未定义请求类型。"
			)));
		}
	} else {
		$ws->push($frame->fd, json_encode(Array(
			"type" => "msg",
			"data" => "错误：Bad Request，不被服务器接受的请求。"
		)));
	}
});

// 客户端断开连接事件
$ws->on('close', function ($ws, $fd) {
	$clients = json_decode($ws->table->get('clients', 'storage'), true);
	unset($clients[$fd]);
	$ws->table->set('clients', ["storage" => json_encode($clients)]);
	$ws->table->del('client-' . $fd);
    echo "client-{$fd} is closed\n";
});

$ws->start();

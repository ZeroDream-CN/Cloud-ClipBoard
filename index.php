<?php
$basehost = "https://clipboard.top";

function Error($text) {
	Header("HTTP/1.1 403 Forbidden");
	exit($text);
}

if(isset($_FILES['file'])) {
	if($_FILES["file"]["type"] !== "image/gif" && 
		$_FILES["file"]["type"] !== "image/jpeg" && 
		$_FILES["file"]["type"] !== "image/pjpeg" && 
		$_FILES["file"]["type"] !== "image/png" && 
		$_FILES["file"]["type"] !== "image/bmp") {
		@unlink($_FILES["file"]["tmp_name"]);
		Error("文件上传失败，上传的文件格式错误，仅允许 jpg、png、bmp 以及 gif。");
		exit;
	}
	if($_FILES["file"]["size"] > 16384000) {
		@unlink($_FILES["file"]["tmp_name"]);
		Error("图片过大，最大允许 16 MB");
		exit;
	}
	if($_FILES["file"]["error"] > 0) {
		switch($_FILES["file"]["error"]) {
			case 3:
				@unlink($_FILES["file"]["tmp_name"]);
				Error("文件上传失败，上传的内容不完整。");
				break;
			case 4:
				@unlink($_FILES["file"]["tmp_name"]);
				Error("文件上传失败，没有选择需要上传的文件。");
				break;
			case 7:
				@unlink($_FILES["file"]["tmp_name"]);
				Error("文件上传失败，无法写入临时文件。");
				break;
		}
		exit;
	} else {
		// Get uploaded files info
		$filesha  = sha1_file($_FILES["file"]["tmp_name"]);
		$fileext  = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
		$filename = "{$filesha}.{$fileext}";
		$filesize = filesize($_FILES["file"]["tmp_name"]);
		// Save uploaded files
		move_uploaded_file($_FILES["file"]["tmp_name"], "upload/{$filename}");
		exit("{$basehost}/upload/{$filename}");
	}
}
?>
<!DOCTYPE HTML>
<html lang="zh-CN">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta name="theme-color" content="#26a69a" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=11">
		<title>ClipBoard 云剪贴板</title>
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<link rel="stylesheet" href="https://cdn.zerodream.net/css/materialize.min.css">
		<style>body{background:#F5F5F5;font-size:15px;font-family:'微软雅黑';font-weight:400;}hr{border:2px solid rgba(0,0,0,0.1);}.background-black{background:rgba(0,0,0,0.3);width:100%;height:100%;position:absolute;}.topbar-fixed{z-index:1;position:fixed;top:0px;left:0px;}.container{margin-top:80px;}.logo-text{font-size:24px ! important;font-weight:300;}.description{font-size:18px;}.table tr td,.table tr th{padding-left:16px;padding-right:16px;font-weight:400;font-size:15px;}h1,h2,h3,h4,h5{font-weight:400;}.normal-text{font-size:15px;}.server-info-input{padding:8px;padding-top:16px;background:#fff;min-height:96px;border:1px solid #eee;border-radius:8px;box-shadow:2px 2px 6px rgba(0,0,0,0.1);margin-bottom:64px}.send-data{padding:8px;padding-top:16px;background:#fff;min-height:178px;border:1px solid #eee;border-radius:8px;box-shadow:2px 2px 6px rgba(0,0,0,0.1);margin-bottom:64px}.sendtextarea{max-height:120px;min-height:120px;min-width:100%;max-width:100%;border:0;width:100%;height:120px;outline:0;margin-top:12px;resize:none;-webkit-box-sizing:content-box;box-sizing:content-box;-webkit-transition:border .3s,-webkit-box-shadow .3s;transition:border .3s,-webkit-box-shadow .3s;transition:box-shadow .3s,border .3s;transition:box-shadow .3s,border .3s,-webkit-box-shadow .3s}.recive-data .paste-data{padding:20px;padding-top:8px;padding-bottom:8px;background:#fff;max-height:512px;overflow-y:auto;border:1px solid #eee;border-radius:8px;box-shadow:2px 2px 6px rgba(0,0,0,0.1);margin-bottom:16px}.connect-button{margin-top:4px;width:100%}.paste-data small{margin-top:8px;display:block;margin-bottom:8px}.paste-data .box{font-family:Consolas,'微软雅黑';white-space:pre}.paste-data .box img{max-width:100%;max-height:450px}.copyright{width:100%;margin-top:64px;padding-top:75px;padding-bottom:64px;text-align:center;background:#333;color:#fff}@media screen and (max-width:600px){.server-info-input{min-height:252px}}</style>
	</head>
	<body>
		<nav class="topbar-fixed">
			<div class="nav-wrapper teal lighten-1">
				<ul id="nav-mobile" class="left">
					<li><a href="#" data-target="slide-out" class="sidenav-trigger waves-effect" style="display: inline-block;"><i class="material-icons">menu</i></a></li>
					<li><a href="#" class="logo-text waves-effect">ClipBoard</a></li>
				</ul>
			</div>
		</nav>
		<ul id="slide-out" class="sidenav">
			<li>
				<div class="user-view">
					<div class="background">
						<div class="background-black"></div>
						<img src="https://i.zerodream.net/34aaf4ab37b33e7f2384bb629ef92fb0.jpg">
					</div>
					<a href="#"><img class="circle" src="https://i.zerodream.net/7173aeb5619ace96e7880c15e8f4c88f.png"></a>
					<a href="#"><span class="white-text name">Akkariin Meiko</span></a>
					<a href="#"><span class="white-text email">个人开发者，鸽子王</span></a>
				</div>
			</li>
			<li><a class="waves-effect" href="https://tql.ink/" target="_blank">个人博客</a></li>
			<li><a class="waves-effect" href="https://t.me/Akkariins" target="_blank">Telegram</a></li>
			<li><div class="divider"></div></li>
			<li><a class="subheader">社交媒体</a></li>
			<li><a class="waves-effect" href="https://twitter.com/KasuganoSoras">Twitter</a></li>
			<li><a class="waves-effect" href="https://facebook.com/KasuganoSoras">Facebook</a></li>
			<li><a class="waves-effect" href="https://github.com/KasuganoSoras">GitHub</a></li>
		</ul>
		<div class="container">
			<div class="row">
				<div class="col s12">
					<p>这是一个......奇怪的云剪贴板工具，最初是为了解决我个人在多设备之间复制内容而写的。</p>
					<p>功能不多，凑合着用吧，GitHub 开源：<a href="https://github.com/ZeroDream-CN/Cloud-ClipBoard/" target="_blank" class="teal-text lighten-2">ZeroDream-CN/Cloud-ClipBoard</a></p>
					<div class="server-info-input">
						<div class="input-field col s12 m5">
							<input id="server_ip" type="text" class="validate" placeholder="wss://clipboard.top/socket/">
							<label for="server_ip">服务器地址</label>
						</div>
						<div class="input-field col s12 m5 blue-text text-darken-1">
							<input id="server_pass" type="password" class="validate" placeholder="1234567890">
							<label for="server_pass">加密密钥</label>
						</div>
						<div class="col s12 m2 center-align">
							<a class="waves-effect waves-light btn-large connect-button" id="connect">连接服务器</a>
						</div>
					</div>
					<h5>发送数据</h5>
					<p>连接服务器之后，在下方输入框内粘贴内容并提交（Enter）即可上传内容，只有相同密钥的客户端能够传输数据。</p>
					<p>文本是端到端加密传输的，图片会上传到服务器并生成一个独一无二的链接，然后再加密传输到其他同密钥客户端，10 分钟后过期。</p>
					<p>服务器地址和密钥会通过 LocalStorage 储存在本地，方便下次连接，可以 <a href="#" id="clearstorage" class="teal-text lighten-2">点这里清除</a>。</p>
					<div class="send-data">
						<div class="input-field col s12">
							<textarea id="send_data" disabled class="sendtextarea" placeholder="支持上传文本和图片"></textarea>
							<label for="send_data">发送内容 <span id="uploadstatus"></span></label>
						</div>
					</div>
					<h5>接收到的内容</h5>
					<p>当客户端接收到新的内容时会显示在这里</p>
					<div class="recive-data"></div>
				</div>
			</div>
		</div>
		<div class="copyright">CloudClipBoard by Akkariin &copy; 2020 ZeroDream.NET</div>
	</body>
	<script type="text/javascript" src="https://cdn.zerodream.net/js/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdn.zerodream.net/js/materialize.min.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
	<script src="https://cdn.zerodream.net/js/crypto/core.js"></script>
	<script src="https://cdn.zerodream.net/js/crypto/mode-cfb.js"></script>
	<script src="https://cdn.zerodream.net/js/crypto/pad-nopadding.js"></script>
	<script src="https://cdn.zerodream.net/js/crypto/sha256.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.sidenav').sidenav();
	});
	
	var serverAddr;
	var serverPass;
	
	var bytepers = 0;
	var storage = 0;
	var loaded = 0;
	var total = 0;
	var ws;
	var connected = false;
	
	setInterval(function() {
		if(loaded != 0) {
			bytepers = loaded - storage;
			storage = loaded;
		}
		if(connected) {
			$("#send_data").removeAttr("disabled");
			$("#connect").attr("disabled", "disabled");
			$("#server_ip").attr("disabled", "disabled");
			$("#server_pass").attr("disabled", "disabled");
		} else {
			$("#send_data").attr("disabled", "disabled");
			$("#connect").removeAttr("disabled");
			$("#server_ip").removeAttr("disabled");
			$("#server_pass").removeAttr("disabled");
		}
	}, 1000);
	
	setInterval(function() {
		if(connected) {
			ws.send(JSON.stringify({
				action: "hearbeat",
				timestamp: Math.floor(Date.now() / 1000)
			}));
		}
	}, 5000);
	
	window.onload = function() {
		
		document.getElementById('send_data').onpaste = function(e) {
			
			if(!connected) return;
			
			var cbd = e.clipboardData;
			var ua = window.navigator.userAgent;
			if (!(e.clipboardData && e.clipboardData.items)) {
				return;
			}
			if(cbd.items && cbd.items.length === 2 && cbd.items[0].kind === "string" && cbd.items[1].kind === "file" &&
				cbd.types && cbd.types.length === 2 && cbd.types[0] === "text/plain" && cbd.types[1] === "Files" &&
				ua.match(/Macintosh/i) && Number(ua.match(/Chrome\/(\d{2})/i)[1]) < 49){
				return;
			}
			for(var i = 0; i < cbd.items.length; i++) {
				var item = cbd.items[i];
				if(item.kind == "file"){
					var blob = item.getAsFile();
					if (blob.size === 0) {
						return;
					}
					CopyUploadFile(blob);
				}
			}
		}
		
		$("#clearstorage").on('click', function(e) {
			localStorage.removeItem('server_ip');
			localStorage.removeItem('server_pass');
			Swal.fire({
				title: '清理成功',
				text: "成功清除已储存的地址和密钥",
				icon: 'success',
				showCancelButton: false,
				confirmButtonColor: '#26a69a',
				confirmButtonText: '确定',
			});
			return;
		});
		
		$("#send_data").on('keydown', function(e) {
			if(e.keyCode == 13) {
				var dataToSend = $("#send_data").val();
				if(dataToSend !== "") {
					if(connected) {
						var encKey = init(serverPass);
						ws.send(JSON.stringify({
							action: "send",
							data: encrypt($("#send_data").val(), encKey.key, encKey.iv)
						}));
						$("#send_data").val("");
						return false;
					} else {
						Swal.fire({
							title: '发送失败',
							text: "你还没有连接到服务器",
							icon: 'error',
							showCancelButton: false,
							confirmButtonColor: '#26a69a',
							confirmButtonText: '确定',
						});
						return;
					}
				} else {
					Swal.fire({
						title: '发送失败',
						text: "内容不能为空",
						icon: 'error',
						showCancelButton: false,
						confirmButtonColor: '#26a69a',
						confirmButtonText: '确定',
					});
					return;
				}
			}
		});
		
		$("#connect").on('click', function(e) {
			
			if(connected) {
				Swal.fire({
					title: '重复连接',
					text: "你已经连接到服务器了，如需切换服务器请刷新网页",
					icon: 'error',
					showCancelButton: false,
					confirmButtonColor: '#26a69a',
					confirmButtonText: '确定',
				});
				return;
			}
			
			// 填充 IP
			if($("#server_ip").val() == "") {
				$("#server_ip").val("wss://clipboard.top/socket/");
			}
			
			serverAddr = $("#server_ip").val();
			serverPass = $("#server_pass").val();
			
			if(serverPass == "") {
				Swal.fire({
					title: '无法连接至服务器',
					text: "服务器密钥不能为空",
					icon: 'error',
					showCancelButton: false,
					confirmButtonColor: '#26a69a',
					confirmButtonText: '确定',
				});
				return;
			}
			
			if((!serverAddr.startsWith("ws://") && !serverAddr.startsWith("wss://")) || !serverAddr.endsWith("/")) {
				Swal.fire({
					title: '无法连接至服务器',
					text: "服务器地址必须为 ws:// 或者 wss:// 开头，/ 结尾",
					icon: 'error',
					showCancelButton: false,
					confirmButtonColor: '#26a69a',
					confirmButtonText: '确定',
				});
				return;
			}
			
			console.log("Connecting server...");
			
			localStorage.setItem("server_ip", serverAddr);
			localStorage.setItem("server_pass", serverPass);
			
			ws = new WebSocket(serverAddr + sha256(serverPass));
			
			ws.onopen = function() {
				PrintLog("<b>[WebSocket]</b> 已连接到服务器");
				connected = true;
			}
			
			ws.onmessage = function(e) {
				try {
					var jsonData = JSON.parse(e.data);
					switch(jsonData.type) {
						case "msg":
							PrintLog("<b>[Server]</b> " + jsonData.data);
							break;
						case "paste":
							NewPaste(jsonData);
							break;
					}
				} catch(e) {
					PrintLog("<b>[Error]</b> 无法解析服务器返回的数据");
				}
			}
			
			ws.onclose = function() {
				PrintLog("<b>[WebSocket]</b> 与服务器的连接已断开！");
				connected = false;
			}
			
			ws.onerror = function() {
				connected = false;
				Swal.fire({
					title: '无法连接至服务器',
					text: "连接出现错误，请检查浏览器控制台",
					icon: 'error',
					showCancelButton: false,
					confirmButtonColor: '#26a69a',
					confirmButtonText: '确定',
				});
				return;
			}
		});
		
		var sip   = localStorage.getItem("server_ip");
		var spass = localStorage.getItem("server_pass");
		
		if(sip != null && spass != null) {
			$("#server_ip").val(sip);
			$("#server_pass").val(spass);
		}
	}
	
	function CopyUploadFile(fileObj) {
		
		var FileController = "/";
		var form = new FormData();
		
		form.append("file", fileObj);
		
		$.ajax({
			type: "post",
			async: true,
			Accept: 'text/html;charset=UTF-8',
			data: form,
			contentType: "multipart/form-data",
			url: '/',
			processData: false,
			contentType: false,
			xhr: function() {						
				uploadXhr = $.ajaxSettings.xhr();
				if(uploadXhr.upload) {
					uploadXhr.upload.addEventListener('progress', function(e) {
						loaded = e.loaded;
						total = e.total;
						var percent = Math.floor(100 * loaded / total) + "%";
						var speed = bytepers / 1024;
						console.log("Uploaded: " + percent);
						if(speed > 1024) {
							speed = speed / 1024;
							$("#uploadstatus").html("（图片上传中：" + percent + " | " + speed.toFixed(2) + "MB/s）");
						} else {
							$("#uploadstatus").html("（图片上传中：" + percent + " | " + speed.toFixed(2) + "KB/s）");
						}
					}, false);
				}
				return uploadXhr;
			},		 
			xhrFields: {
				withCredentials: true
			},
			crossDomain: true,
			success: function(data) {
				console.log("Upload Successful: " + data);
				$("#uploadstatus").html("（图片上传成功）");
				bytepers = 0;
				storage = 0;
				loaded = 0;
				total = 0;
				var encKey = init(serverPass);
				ws.send(JSON.stringify({
					action: "send",
					data: encrypt("<img src='" + data + "' />", encKey.key, encKey.iv)
				}));
			},
			error: function(data) {
				bytepers = 0;
				storage = 0;
				loaded = 0;
				total = 0;
				$("#uploadstatus").html("（" + data.responseText + "）");
			}
		});
	}
	
	function PrintLog(text) {
		var currentData = $(".recive-data").html();
		$(".recive-data").html("<p>" + text + "</p>\n" + currentData);
	}
	
	function NewPaste(data) {
		var currentData = $(".recive-data").html();
		var decKey = init(serverPass);
		$(".recive-data").html("<div class='paste-data'><small>粘贴于 " + data.time + "</small><div class='box'>" + decrypt(data.data, decKey.key, decKey.iv) + "</div></div>\n" + currentData);
	}
	
	function init(data) {
		key = CryptoJS.enc.Utf8.parse(CryptoJS.MD5(data).toString());
		iv 	= CryptoJS.enc.Utf8.parse(CryptoJS.MD5(data).toString().substr(0, 16));
		return {
			key: key,
			iv: iv
		};
	}
	
	function encrypt(data, key, iv) {
		var encrypted 	= '';
		if(typeof(data) == 'string') {
			encrypted = CryptoJS.AES.encrypt(data, key, {
				iv 		: iv,
				mode 	: CryptoJS.mode.CFB,
				padding : CryptoJS.pad.NoPadding
			});
		} else if(typeof(data) == 'object') {
			data 		= JSON.stringify(data);
			encrypted 	= CryptoJS.AES.encrypt(data, key, {
				iv : iv,
				mode : CryptoJS.mode.CFB,
				padding : CryptoJS.pad.NoPadding
			})
		}
		return encrypted.toString();
	}
	
	function decrypt(data, key, iv) {
		decrypted 	= '';
		decrypted 	= CryptoJS.AES.decrypt(data, key, {
			iv 		: iv,
			mode 	: CryptoJS.mode.CFB,
			padding : CryptoJS.pad.NoPadding
		});
		try {
			var dedata = decrypted.toString(CryptoJS.enc.Utf8);
		} catch (e) {
			var dedata = "解密失败，请检查 Key 和密文是否正确！";
		}
		return dedata;
	}
	
	function sha256(text) {
		return CryptoJS.SHA256(text).toString();
	}
	</script>
</html>

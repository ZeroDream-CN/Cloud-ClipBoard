<?php
if(php_sapi_name() !== "cli") {
	exit("This program only can running on cli mode");
}

while(true) {
	sleep(5);
	$list = scandir("upload/");
	foreach($list as $file) {
		if($file !== "." && $file !== ".." && is_file("upload/{$file}")) {
			$time = filemtime("upload/{$file}");
			if(time() - $time > 600) {
				echo "删除了过期文件 {$file}\n";
				@unlink("upload/{$file}");
			}
		}
	}
}

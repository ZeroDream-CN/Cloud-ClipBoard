# Cloud-ClipBoard
开源的云剪贴板程序，无聊做的作品，欢迎体验

Demo：[clipboard.top](https://clipboard.top/)

## 如何使用
1. 在设备 A 上打开 [clipboard.top](https://clipboard.top/) 这个网页，随便输入一个密钥，点击连接按钮
2. 在设备 B 上也打开这个网页，输入同样的密钥，点击连接按钮
3. 设备 A 现在可以向设备 B 发送数据，设备 B 也可以向设备 A 发送数据
4. 还可以在更多设备上打开这个网页，实现多设备同步数据

## 功能和特性
- 跨平台，仅需一个浏览器，无需下载专用客户端
- 支持传输文字和图片
- 端到端加密支持（AES-256-CFB）
- 服务器地址和密钥自动保存到 localStorage
- 可自建服务器，不依赖任何第三方服务
- WebSocket 长连接，Swoole 高性能服务端
- 其他暂时想不出

## 安装和部署
1. 把 `index.php` 放到网站目录下
2. 创建 `upload` 文件夹并给予 php 进程写权限（例如 `chown -R www:www upload/`）
3. 命令行运行 `websocket.php`（确保你已经安装 Swoole 环境）
4. 命令行运行 `cleanup.php`（用于定时清理过期图片文件）

> 建议使用 screen 来维护 php 进程，避免 SSH 连接断开后进程终止

## 关于资源文件
网页调用了一些来自 cdn.zerodream.net 的文件，这个是我本人自用的 CDN 服务器，宽带流量有限，而且不太稳定，日常爆炸，部署的话建议自行更换为大厂 CDN。

## 开源协议
本项目使用 GPL-v3 协议开源

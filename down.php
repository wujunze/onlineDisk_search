<?php
/**
 * @Author: 钧泽
 * @Date: 2015-07-23 14:38:40
 * @Email:1017109588@qq.com
 * @Domain:www.14jz.com
 * @网盘搜索引擎   程序由彩虹原创,钧泽网络二次开发,优化网站功能,修复程序BUG
 * @网站为开源程序,禁止倒卖   正版程序下载地址:www.14jz.com
 * @QQ:1017109588
 */
if(is_dir("cache")==0)
{@mkdir("cache");}
if(file_exists("cache/.htaccess")==0)
{
@file_put_contents("cache/.htaccess",'Error:Keep Out');
}

$url=$_GET['u'];

if($_GET['submit']=='直接下载' || $_GET['submit']=='中转下载')
{
if(preg_match('/return_to=/',$url))
{$url=preg_replace('!http://s.wodemo.com.*?return_to=!i','',$url);
$url=urldecode($url);
}
$url=urldecode($url);
if($_GET['submit']=='直接下载')
{header("Location:{$url}");exit;}
}

$name=basename($url);
$file=iconv('UTF-8', 'GB2312//IGNORE', $name);
if(defined("SAE_ACCESSKEY"))$local=SAE_TMP_PATH.$file;
else $local='./cache/'.$file;


$ch = curl_init($url);
$fp = fopen($local, "w");
curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser/Mini3.1 (Nokia3050/07.42) Via: MQQBrowser');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_exec($ch);
curl_close($ch);
fclose($fp);


if(file_exists($local))
{
$file_size=filesize($local);
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$name}");
readfile($local);
}
else{
echo '中转下载失败！';
}

?>
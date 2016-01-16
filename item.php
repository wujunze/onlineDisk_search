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
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require 'func.inc.php';

$ml=$_GET['url'];
$url="http://bleed.daimajia.com/baidu/?url=".$ml;
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$body=curl_exec($ch);
curl_close($ch);
$nr=json_decode($body, true);
if($nr['error'] =="1") {
header("Location:{$ml}");
}
else
{
$size=getsize($nr['size']);

$title = $nr['name'];
require 'head.inc.php';

echo '<div class="title">文件名:</div><div class="line1">'. $nr['name'].'</div><div class="title">文件大小:</div><div class="line1">'. $size.'</div><div class="title">MD5:</div><div class="line1">'.$nr['md5'].'</div><div class="title">分享地址:</div><div class="line1"><a href="'. $nr['url'].'">'.$nr['url'].'</a></div> ';
echo ' <div class="title">';
echo '下载直链:</div><div class="line1">';
echo '<textarea rows="3" style="width:95%" onmouseover="this.select()">'.$nr['download'].'</textarea>';
echo '</div>';
}
?>

<div class="title">
<a href="javascript:history.back();">返回上级</a>-<a href='./'>返回首页</a>
</div>
<?php require 'foot.inc.php';?>
</body>
</html>

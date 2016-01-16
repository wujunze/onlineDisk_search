<?php
/**
 * @Author: 钧泽
 * @Date: 2015-07-23 14:38:40
 * @Email:1017109588@qq.com
 * @Domain:www.wujunze.com
 * @网盘搜索引擎   程序由彩虹原创,钧泽网络二次开发,优化网站功能,修复程序BUG
 * @网站为开源程序,禁止倒卖   正版程序下载地址:www.14jz.com
 * @QQ:1017109588
 */
error_reporting(E_ERROR | E_WARNING | E_PARSE);
require 'func.inc.php';

$mo=isset($_GET['mo'])?$_GET['mo']:null;
if($mo==null)
{
$title = '我的磨代理访问';
require 'head.inc.php';
echo '<div class="title">我的磨代理访问</div>
<div class="n">输入要访问的磨盘域名：<br/><form action="mo.php" method="get">
<input type="text" name="mo" size="30" value="http://www.14jz.com" />
<input type="submit" value="访问" />
</form></div>';
require 'foot.inc.php';
exit;
}
$url=isset($_GET['url'])?$_GET['url']:'/filelist';

$url=$mo.$url;
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_REFERER, 'http://wodemo.com/');
curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser/Mini3.1 (Nokia3050/07.42) Via: MQQBrowser');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:zh-cn,zh;"));
$html=curl_exec($ch);
curl_close($ch);

$title = "|<title>(.*?)</title>|ims";

$nav = "|<span id=\"ln-h\">(.*?)&nbsp;<hr />|ims";

$list = "|<ul class=\"file_list\">(.*?)</ul><p>|ims";

$page = "|<span class=\"pagination\">(.*?)</span></p>|ims";

preg_match($title,$html,$out);
$title = $out[1];
preg_match($nav,$html,$out);
$nav = str_replace('<a href="/file/','<a href="./view.php?url='.$mo.'/file/',$out[1]);
$nav = str_replace('<a href="/entry/','<a href="./view.php?url='.$mo.'/entry/',$nav);
$nav = str_replace('<a href="/','<a href="./mo.php?mo='.$mo.'&url=/',$nav);
$nav = str_replace('<a href="http://','<a href="./view.php?url=http://',$nav);
preg_match($list,$html,$out);
$list = str_replace('<a href="http://','<a href="./view.php?url=http://',$out[1]);
$list = str_replace('<a href="/file/','<a href="./view.php?url='.$mo.'/file/',$list);
$list = str_replace('<a href="/entry/','<a href="./view.php?url='.$mo.'/entry/',$list);
$list = str_replace('<a href="/','<a href="./mo.php?mo='.$mo.'&url=/',$list);
preg_match($page,$html,$out);
$page = str_replace('<a href=\'/','<a href=\'./mo.php?mo='.$mo.'&url=/',$out[1]);


require 'head.inc.php';

echo '<div class="title"><b>'.$title.'</b> [ <a href="'.$url.'">浏览原网页</a> ]</div><div class="line1">'.$nav.'<hr/>'.$list.'<br/>'.$page.'</div>';

?>

<div class="title">
<a href="javascript:history.back();">返回上级</a>-<a href='./'>返回首页</a>
</div>
<?php require 'foot.inc.php';?>
</body>
</html>

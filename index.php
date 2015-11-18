<?php
/**
 * @Author: 钧泽
 * @Date: 2015-07-23 14:52:40
 * @Email:1017109588@qq.com
 * @Domain:www.14jz.com
 * @网盘搜索引擎   程序由彩虹原创,钧泽二次开发,优化网站功能,修复程序BUG
 * @网站为开源免费程序,禁止倒卖   正版程序下载地址:www.14jz.com
 * @QQ:1017109588
 */
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
require 'func.inc.php';
$title=$sitename;
require 'head.inc.php';

$m=isset($_GET['m'])?$_GET['m']:'wodemo';
$type=isset($_GET['type'])?$_GET['type']:'all';
$pn=isset($_GET['p'])?$_GET['p']:1;
$k=isset($_GET['k'])?$_GET['k']:'';
$kw=urlencode($k);


$nav='<a href="?m=wodemo&k='.$k.'&type='.$type.'">我的磨</a>|<a href="?m=wodemo2&k='.$k.'&type='.$type.'">我的磨2</a>|<a href="?m=baidu2&k='.$k.'&type='.$type.'">百度网盘</a>|<a href="?m=baidu2&k='.$k.'&type='.$type.'">百度云</a>|<a href="?m=letv&k='.$k.'&type='.$type.'">乐视网盘</a>|<a href="?m=vdisk&k='.$k.'&type='.$type.'">新浪微盘</a>|<a href="?m=vmall&k='.$k.'&type='.$type.'">华为网盘</a>|<a href="?m=qiannao&k='.$k.'&type='.$type.'">千脑网盘</a>|<a href="?m=400gb&k='.$k.'&type='.$type.'">城通网盘</a>';
$nav=preg_replace('!<a href=\"\?m='.$m.'&k.*?\">(.*?)</a>!i','<b>$1</b>',$nav);
if(!$k)$nav=str_ireplace('&k='.$k.'&type='.$type,'',$nav);

if($type=='all')$select='';
else $select='<option value="'.$type.'" selected>'.$type.'</option>';

echo <<<HTML
<div class="c1"><p>{$nav}</p>
<p><form action="?" method="get">
<input type="hidden" name="m" value="{$m}" />
<input type="text" name="k" size="30" value="{$k}"/>
<select name="type" style="margin:0 0 0 -80px;border:1px solid white" >{$select}
<option value="all">不限</option>
<option value="zip">ZIP</option>
<option value="7z">7Z</option>
<option value="rar">RAR</option>
<option value="txt">TXT</option>
<option value="apk">APK</option>
<option value="sis">SIS</option>
<option value="sisx">SISX</option>
<option value="mrp">MRP</option>
<option value="iso">ISO</option>
<option value="doc">DOC</option>
<option value="ppt">PPT</option>
<option value="pdf">PDF</option>
<option value="xls">XLS</option>
<option value="rtf">RTF</option>
<option value="mp3">MP3</option>
<option value="mp4">MP4</option>
<option value="avi">AVI</option>				
<option value="mkv">MKV</option>
<option value="wmv">WMV</option>
<option value="rmvb">RMVB</option>
<option value="torrent">BT种子</option>
</select>

<input type="submit" value="搜索" />
</form></p></div><br />
HTML;
if(!$k){
if($m=='wodemo')
{
	$ch=curl_init('http://cccyun.sinaapp.com/api/mopan.php?limit='.$limit);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$mopan=curl_exec($ch);
	curl_close($ch);
	echo '<div class="title">我的磨随机推荐&nbsp;&nbsp;<a href="http://www.14jz.com" target="_blank">更多>></a></div><div class="n">'.$mopan.'</div>';
	if($transfer==true)$submit='&nbsp;<input type="submit" name="submit" value="中转下载" />';
	else $submit='';
	echo '<div class="title">我的磨代理访问</div>
<div class="n">输入要访问的磨盘域名：<br/><form action="mo.php" method="get">
<input type="text" name="mo" size="30" value="http://www.14jz.com" />
<input type="submit" value="访问" />
</form></div>
<div class="title">我的磨文件下载（免验证码）</div>
<div class="n">输入文件下载链接：<br/><form action="down.php" method="get">
<input type="text" name="u" size="30" value="" /><br/>
<input type="submit" name="submit" value="直接下载" />'.$submit.'
</form></div>';
}
require 'foot.inc.php';
exit;
}
if($type=='all'){}
else $k=$k.' .'.$type;

switch($m)
{
case 'baidu':
	$site="yun.baidu.com";
break;
case 'baidu2':
	$site="yun.baidu.com";
break;
case 'wodemo':
	$site="wodemo.com";
break;
case '115':
	$site="115.com%2Flb";
break;
case 'letv':
	$site="cloud.letv.com";
break;
case 'vdisk':
	$site="vdisk.weibo.com";
break;
case 'vmall':
	$site="dl.vmall.com";
break;
case 'qiannao':
	$site="qiannao.com";
break;
case '400gb':
	$site="400gb.com";
break;
}

if($m=='wodemo2')
$con = search_wodemo($k,$pn);
elseif($apimode==true)
$con = search_api($k,$num,$pn,$site);
else
$con = search_google($k,$num,$pn,$site);
$n=count($con);
//print_r($con);exit;
for($i=0;$i<$n;$i++)
{
$click=urldecode($con[$i]['url']);
if($m=='baidu')
echo <<<HTML
<a href="item.php?url={$con[$i]['url']}" target="_blank">{$con[$i]['title']}</a>
<div class="c3">{$con[$i]['description']}</div><hr />
HTML;
elseif($m=='wodemo' || $m=='wodemo2')
echo <<<HTML
<a href="view.php?url={$con[$i]['url']}" target="_blank">{$con[$i]['title']}</a>
<div class="c3">{$con[$i]['description']}<br/><span class="site">{$con[$i]['site']}</span></div><hr />
HTML;
else
echo <<<HTML
<a href="{$click}" target="_blank">{$con[$i]['title']}</a>
<div class="c3">{$con[$i]['description']}</div><hr />
HTML;
}

echo '<div class="c1"><p>';
if($pn==1)
{
echo '上一页';
}
else{
echo '<a href="?m='.$m.'&p='.($pn-1).'&k='.$kw.'&type='.$type.'">上一页</a>';
}
echo '．';
if($pn==100)
{
echo '下一页';
}
else{
echo '<a href="?m='.$m.'&p='.($pn+1).'&k='.$kw.'&type='.$type.'">下一页</a>';
}
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;第 {$pn} 页";
echo '</p>';
echo <<<HTML
<p>
<form action="?" method="get">
<input type="hidden" name="m" value="{$m}" />
<input type="text" name="p" size="6" value="" />
<input type="hidden" name="k" value="{$k}" />
<input type="hidden" name="type" value="{$type}" />
<input type="submit" value="跳页" />
</form>
</p>
</div>
HTML;
require 'foot.inc.php';

?>
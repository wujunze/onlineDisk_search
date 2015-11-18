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
require_once 'config.php';

/**
 * 抓取我的磨搜索结果
 * @param string $k 关键字
 * @param int $pn 页数
 * @return array
*/
function search_wodemo($k,$pn)
{
//编码搜索关键字,用于URL请求
$kw=urlencode($k);

$url="http://service.wodemo.com/search?q={$kw}&all=1&page={$pn}";
//初始化一个cURL会话  返回一个资源
$ch=curl_init($url);

//在HTTP请求头中"Referer: "的内容    value应该被设置一个string类型的值：   
curl_setopt($ch, CURLOPT_REFERER, 'http://wodemo.com/');

//在HTTP请求中包含一个"User-Agent: "头的字符串      value应该被设置一个string类型的值
curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser/Mini3.1 (Nokia3050/07.42) Via: MQQBrowser');

// 启用时会将头文件的信息作为数据流输出     value应该被设置一个bool类型的值： 
curl_setopt($ch, CURLOPT_HEADER, 0);

//将curl_exec()获取的信息以文件流的形式返回，而不是直接输出。  value应该被设置一个bool类型的值：
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//一个用来设置HTTP头字段的数组。使用如下的形式的数组进行设置： array('Content-type: text/plain', 'Content-length: 100')    value应该被设置一个数组
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:zh-cn,zh;"));

//执行一个cURL会话
$html=curl_exec($ch);

//关闭cURL会话
curl_close($ch);

//正则匹配
$p = "|<div class=\"wo-search-result-area\">(.*?)页:|ims";
if(preg_match($p,$html,$out)){
	$ol_contents = $out[1];
	$p = '|<div class=\"wo-search-result-item\">(.*?)</div>|ims';
	if(preg_match_all($p,$ol_contents,$ol_out)){
		$li_contents = $ol_out[1];
		//print_r($li_contents);exit;
		$i = 0;
		foreach($li_contents as $li){
	$p = '!<a href=\"(.*?)\">(.*?)</a><span class=\"wo-search-result-host\"> - (.*?)</span><p>(.*?)</p>!ims';
			if(preg_match($p,$li,$o_out)){
				//print_r($o_out);exit;
				$url = $o_out[1];
				$op['title'] = $o_out[2];
				$op['url'] = $url;
				$op['site'] = $o_out[3];
				$op['description'] = $o_out[4];
			}
			if($op['url']==null)continue;
			$all[] = $op;
		}
		return $all;
}

}else{
	return array();
}
}

/**
 * 抓取谷歌搜索结果
 * @param string $k 关键字
 * @param int $num 每页显示结果数
 * @param int $pn 页数
 * @param string $site 指定站点
 * @return array
*/
function search_google($k,$num,$pn,$site)
{
$start = $pn*$num;
global $googleip;
$kw=urlencode($k);
if($site)
$url = $googleip."/search?sa=N&newwindow=1&safe=off&q={$kw}&num={$num}&start={$start}&sitesearch={$site}";
else $url = $googleip."/search?sa=N&newwindow=1&safe=off&q={$kw}&num={$num}&start={$start}";

$surl = 'http://www.google.com.hk/';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_REFERER, $surl);
curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser/Mini3.1 (Nokia3050/MIDP2.0)');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:zh-cn,zh"));
curl_setopt($ch, CURLOPT_MAXREDIRS, 1);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
$contents = curl_exec($ch);
curl_close($ch);
$html = $contents;
$html = mb_convert_encoding( $html, 'utf-8','gbk' );
$p = "|<div id=\"universal\">(.*?)</div><div id=\"navbar\"|ims";
if(preg_match($p,$html,$out)){
	$ol_contents = $out[1];
	$p = '|<div style=\"clear:both\">(.*?)</div></div></div>|ims';
	if(preg_match_all($p,$ol_contents,$ol_out)){
		$li_contents = $ol_out[1];
		//print_r($li_contents);exit;
		$i = 0;
		foreach($li_contents as $li){
			
			$p = '!(u=|q=)(.*?)&amp;.*?>(.*?)</a></div><div>(.*?)<div/><div><span .*?>(.*?)</span>!ims';
			if(preg_match($p,$li,$o_out)){
				//print_r($o_out);exit;
				$url = $o_out[2];
				//$url = urldecode($url);
				$op['title'] = $o_out[3];
				$op['url'] = $url;
				$op['site'] = str_replace('&nbsp;<img src="//www.gstatic.com/m/images/phone.gif" width="7" height="14" alt=""/>','',$o_out[5]);
				$op['description'] = $o_out[4];
			}
			if($op['url']==null)continue;
			$all[] = $op;
		}
		return $all;
}

}else{
	return array();
}
}

//通过API获取谷歌搜索结果
function search_api($k,$num,$pn,$site)
{
$k=urlencode(base64_encode($k));
$url = "http://google.cccyun.cn/api.php?ver=2&kw={$k}&page={$pn}&num={$num}&site={$site}";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$contents = curl_exec($ch);
curl_close($ch);
$json = json_decode(base64_decode($contents),true);
return $json;
}

function wodemo($url)
{
preg_match("|http://(.*?)/|ims",$url,$out);
$domain=$out[1];

$ch=curl_init($url);
curl_setopt($ch, CURLOPT_REFERER, 'http://wodemo.com/');
curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser/Mini3.1 (Nokia3050/07.42) Via: MQQBrowser');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:zh-cn,zh;"));
$html=curl_exec($ch);
curl_close($ch);

$page = "|<div class=\"wo-file-main\">(.*?)</div><!--wo-file-main-->|ims";

$match = "|<h1 class=\"wo-file-title\">(.*?)</h1>(.*?)<div><!--actions begin-->(.*?)</div><!--actions end-->|ims";

$file = "|<a href=\"http://s.wodemo.com.*?return_to=(.*?)\">下载</a>|ims";

$description = "|<span class=\"wo-file-description-contents\">(.*?)</span></div>|ims";

preg_match($page,$html,$out);
$content = str_ireplace('<a href="/','<a href="http://'.$domain.'/',$out[1]);
$content = str_ireplace('<img src="/','<img src="http://'.$domain.'/',$content);

preg_match($match,$content,$out);
$name = $out[1];
$info = $out[2];
$actions = $out[3];

if(preg_match($file,$actions,$downurl))
{
	global $transfer;
	$download = urldecode($downurl[1]);
	if($transfer==true)
	$actions = preg_replace('!<a href=\"(.*?)\">下载</a>!i','<a href="'.$download.'">下载</a> | <a href="down.php?u='.$download.'">中转下载</a>',$actions);
	else
	$actions = preg_replace('!<a href=\"(.*?)\">下载</a>!i','<a href="'.$download.'">下载</a>',$actions);
}
//print_r($downurl);exit;

preg_match($description,$content,$description_contents);
$description_contents = $description_contents[1];
if(empty($description_contents))
	$description_contents = '无';

$mo=array();
$mo['name'] = $name;
$mo['info'] = $info;
$mo['actions'] = $actions;
$mo['description'] = $description_contents;
return $mo;
}

function wodemo_entry($url)
{
preg_match("|http://(.*?)/|ims",$url,$out);
$domain=$out[1];

$ch=curl_init($url);
curl_setopt($ch, CURLOPT_REFERER, 'http://wodemo.com/');
curl_setopt($ch, CURLOPT_USERAGENT, 'MQQBrowser/Mini3.1 (Nokia3050/07.42) Via: MQQBrowser');
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:zh-cn,zh;"));
$html=curl_exec($ch);
curl_close($ch);

$title = "|<title>(.*?)</title>|ims";
$page = "|<div id=\"whole_body\" class=\"wo-main-body wo-mode-visitor\">(.*?)<div class=\"wo-entry-prev-next\">|ims";

preg_match($title,$html,$out);
$title = $out[1];
preg_match($page,$html,$out);
$content = str_ireplace('<a href="/','<a href="http://'.$domain.'/',$out[1]);
$content = str_ireplace('<img src="/','<img src="http://'.$domain.'/',$content);

$mo=array();
$mo['content'] = $content;
$mo['title'] = $title;
return $mo;
}

function getsize($size)
{
if($size<1048576)
{
$dx=$size/1024;
$n=round($dx, 3);
$dw="<font color='red'>KB</font>";
$size=$n.$dw;
}
elseif($size>=1048576&&$size<1073741824)
{
$dx=$size/1048576;
$n=round($dx, 3);
$dw="<font color='red'>MB</font>";
$size=$n.$dw;
}
else
{
$dx=$size/1073741824;
$n=round($dx, 3);
$dw="<font color='red'>GB</font>";
$size=$n.$dw;
}
return $size;
}
?>
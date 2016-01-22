<?php
/**
 * @Author: 钧泽
 * @Date: 2015-07-23 14:38:40
 * @Email:1017109588@qq.com
 * @Domain:www.wujunze.com
 * @网盘搜索引擎   程序由彩虹原创,钧泽网络二次开发,优化网站功能,修复程序BUG
 * @网站为开源程序,禁止倒卖   正版程序下载地址:www.wujunze.com
 * @QQ:1017109588
 */
header("content-type:text/html;charset=UTF-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">';
echo '<html xmlns="http://www.w3.org/1999/xhtml">';
echo <<<HTML
<head>
<meta http-equiv="Cache-control" content="no-cache" />
<meta name="viewport" content="width=device-width; initial-scale=1.0;  minimum-scale=1.0; maximum-scale=2.0"/>
<title>{$title}</title>
<style type="text/css">
.title{
background-color : #d2ff8d;
padding:5px;
}
.n{
padding:5px;
border:1px solid #d2ff8d;
}
.cpy{
background-color:#fcffb3;
color:#aaa;
border:1px solid #ddd;
text-align:center;
}
a:link{
color:#0000ff;
text-decoration:none;
}
a:visited{
color:#e900d4;
text-decoration:none;
}
a:hover{
color:#ff0000;
text-decoration:underline;
}
hr{
height:1px;
border:1px solid #ececec;
}
body{
max-width:640px;
font-size:16px;
line-height:22px;
text-align:left;
background-color:#fcfcfc;
color:#000000;
border:2px solid #ececec;
margin:0 auto;
padding:3px;
overflow-x:hidden;
}
p{margin:3px;}
.c1{
background-color : #d2ff8d;
padding:5px;
text-align:center;
}
.c1 a:link, .c1 a:visited, .c1 a:hover, .c1 a:active{
text-decoration:none;color:#004299;	
}
.c3{
font-size:14px;
color:#999;
}
input[type="submit"],input[type="reset"]{
display:inline;background:#2F94CF;cursor: pointer;
background:-webkit-gradient(linear, left top, left bottom, from(#2F94CF), to(#2182BC));
border-radius:3px;
margin:10px auto;
text-align:center;
padding: 5px 0px;
text-shadow:0 0 3px #1A71A4;color:#FFF;
border:1px solid #1A71A4;
width:20%;
}
input[type="submit"]:hover,.n input[type="button"]:hover{
background:#333;
}
input[type="text"]{
padding: 5px 0px; border: 1px solid #C3C3C3; background: #FFF url(/images/input_bg.gif) repeat-x 0 0px;width:70%;
}
.site{color:green;}
</style>
<STYLE type=text/css>
A{cursor:url('http://qisou.aliapp.com/mouse/JZWL-2.cur'), url(http://qisou.aliapp.com/mouse/JZWL-2.cur), auto;}
BODY{cursor:url('http://qisou.aliapp.com/mouse/JZWL-1.cur'), url(http://qisou.aliapp.com/mouse/JZWL-1.cur), auto;}
</STYLE>
</head>
<body>
<div><p align="center"><a href="./"><img src="./logo.png" alt="网盘搜索引擎-钧泽网络旗下网站"></a></p></div>
HTML;
?>
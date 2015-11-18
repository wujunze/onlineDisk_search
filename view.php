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

$url=$_GET['url'];
if(!preg_match('/file\//',$url) && !preg_match('/entry\//',$url))
{header("Location:{$url}");exit;}

if(preg_match('/file\//',$url))
{
$res=wodemo($url);

$title = $res['name'];
require 'head.inc.php';

echo '<div class="title"><b>'.$res['name'].'</b> [ <a href="'.$url.'">浏览原网页</a> ]</div><div class="n">'.$res['info'].'</div><div class="title">文件操作:</div><div class="n">'.$res['actions'].'</div><div class="title">文件简介:</div><div class="n"><p>'.$res['description'].'</p></div>';
}

elseif(preg_match('/entry\//',$url))
{
$res=wodemo_entry($url);

$title = $res['title'];
require 'head.inc.php';

echo '<div class="title"><b>'.$res['title'].'</b> [ <a href="'.$url.'">浏览原网页</a> ]</div><div class="n">'.$res['content'].'</div>';
}
?>

<div class="title">
<a href="javascript:history.back();">返回上级</a>-<a href='./'>返回首页</a>
</div>
<?php require 'foot.inc.php';?>
</body>
</html>

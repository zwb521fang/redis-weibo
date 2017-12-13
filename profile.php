<?php
include('lib.php');
include('header.php');
if(($user=islogin())==false){
	header('location:index.php');
	exit;
	}
	$r=connredis();
$u= $_GET['u'];
$prouid = $r->get('user:username:'.$u.':userid');
if(!$prouid)
{
	error('非正常用户');
	exit;
	}

  $isf=	$r->sismember('following:'.$user['userid'],$prouid);
  $isfstatus =$isf?"0":"1";
  $isfword = $isf ? "取消关注":"关注他";
?>
<div id="navbar">
<a href="index.php">主页</a>
| <a href="timeline.php">热点</a>
| <a href="logout.php">退出</a>
</div>
</div>
<h2 class="username">test</h2>
<a href="follow.php?uid=<?php echo $prouid?>&f=<?php echo $isfstatus?>" class="button"><?php echo $isfword?></a>

<div class="post">
<a class="username" href="profile.php?u=test">test</a> 
world<br>
<i>11 分钟前 通过 web发布</i>
</div>

<div class="post">
<a class="username" href="profile.php?u=test">test</a>
hello<br>
<i>22 分钟前 通过 web发布</i>
</div>
<?php include('footer.php');

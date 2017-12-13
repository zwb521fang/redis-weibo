<?php
include('header.php');
include('lib.php');
if(($user = islogin()) == false){
	header('location:index.php');
	}

	//取出自己发的和粉猪自己发的信息
	$r =  connredis();
	$r->ltrim('recivepost:'.$user['userid'],0,49);
#	$newpost =$r->sort('recivepost:'.$user['userid'],array('sort'=>'desc','get'=>'post:postid:*:content'));
    //哈希取数据
	$newpost =$r->sort('recivepost:'.$user['userid'],array('sort'=>'desc'));

//计算几个粉丝几个关注
	$myfans = $r->scard('follower:'.$user['userid']);
	$mystar =$r->scard('following:'.$user['userid']);
?>
<div id="navbar">
<a href="index.php">主页</a>
| <a href="timeline.php">热点</a>
| <a href="logout.php">退出</a>
</div>
</div>
<div id="postform">
<form method="POST" action="post.php">
<?php echo $user['username']?>, 有啥感想?
<br>
<table>
<tr><td><textarea cols="70" rows="3" name="status"></textarea></td></tr>
<tr><td align="right"><input type="submit" name="doit" value="Update"></td></tr>
</table>
</form>
<div id="homeinfobox">
<?php echo $myfans?> 粉丝<br>
<?php echo $mystar ?>关注<br>
</div>
</div>
<?php
    foreach($newpost as $postid){
	$p =	$r->hmget('post:postid:'.$postid,array('userid','time','content','username'));
		
#		}
#foreach($newpost as $v){ ?>
<div class="post">
<a class="username" href="profile.php?u=test"><?php echo $p['username']?></a> <?php echo $p['content']?><br>
<i><?php echo formattime($p['time'])?></i>
</div>
<?php } ?>
<?php include('footer.php')?>

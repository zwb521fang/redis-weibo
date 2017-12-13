<?php
include('lib.php');
include('header.php');
if(($user=islogin())==false){
	header('location:index.php');
	exit;
	}
	$r=connredis();
$uid= $_GET['uid'];
$f = $_GET['f'];


if($f == 1){
$r->sadd('following:'.$user['userid'],$uid);
$r->sadd('follower:'.$uid,$user['userid']);
}else{
	
$r->srem('following:'.$user['userid'],$uid);
$r->srem('follower:'.$uid,$user['userid']);
	}
$uname =$r->get('user:userid:'.$uid.':username');
header('location:profile.php?u='.$uname);



  include('footer.php');

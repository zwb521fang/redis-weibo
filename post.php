<?php
include('lib.php');
include('header.php');
if(($user =islogin())== false)
{
   header('location:index.php');
   exit;
}
$content = $_POST['status'];
if(!$content){
	error('请填写内容');
	}

$r = connredis();
$postid =$r->incr('global:postid');
#$r->set('post:postid:'.$postid.':userid',$user['userid']);
#$r->set('post:postid:'.$postid.':time',time());
#$r->set('post:postid:'.$postid.':content',$content);
$r->hmset('post:postid:'.$postid,array('username'=>$user['username'],'userid'=>$user['userid'],'time'=>time(),'content'=>$content));
$fans =$r->smembers('follower:'.$user['userid']);
#var_dump($fans);exit;
$fans[]= $user['userid'];
foreach($fans as $fansid){
	$r->lpush('recivepost:'.$fansid,$postid);
	}
header('location:home.php');
include('footer.php');

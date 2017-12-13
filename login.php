<?php
include('lib.php');
include('header.php');
if(islogin() !=false){
	header('location:home.php');
	exit;
	}
$username = $_POST['username'];
$password = $_POST['password'];
if(!$username && !$password){
	error('请输入完成');
	}
$r = connredis();
$userid = $r->get('user:username:'.$username.':userid');
if(!$userid){
	error('用户名不存在');
	}
$realpass = $r->get('user:userid:'.$userid.':password');
if($password != $realpass){
	error('密码不存在');
	}
setcookie('username',$username);
setcookie('userid',$userid);
$rand =substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()'),0,16);
$r->set('user:userid:'.$userid.':authsecret',$rand);
setcookie('authsecret',$rand);
header('location:home.php');

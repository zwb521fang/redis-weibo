<?php
#echo "ddd";
include('lib.php');
# var_dump($_POST);

if(islogin() !=false){
  header('location:home.php');
  exit;
}

include('header.php');  
$username = $_POST['username'];
#var_dump($username);
#exit;
#var_dump($username);exit;
$password = $_POST['password'];
$password2 = $_POST['password2'];
#var_dump($username,$password,$password2);exit;
if(!$username || !$password || !$password2) {
     error('请输入完整注册信息');
 }
if($password != $password2) {
 error('密码不对');
}
$r = connredis();
if($r->get('user:username:'.$username.':userid')){
return error('该用户已注册');
}
 $userid = $r->incr('global:userid');
$r->set('user:userid:'.$userid.':username',$username);
$r->set('user:userid:'.$userid.':password',$password);
$r->set('user:username:'.$username.':userid',$userid);
$r-> lpush('newuserlink',$userid);
$r->ltrim('newuserlink',0,49);
include('./footer.php');

?>

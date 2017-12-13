<?php
include('lib.php');

setcookie('username','',-1);

setcookie('userid','',-1);
setcookie('authsecret','',-1);
$r = connredis();
$r->set('user:userid:'.$_COOKIE['userid'].'authsecret','');
header('location:index.php');

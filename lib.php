<?php
  function p($key){
    return $_POST[$key];
}
  function g($key){
    return $_GET[$key];	

}
 function error($msg){
  echo $msg;
  include('./footer.php');
exit;
}
function connredis(){
   static $r = null;
   if($r !== NUll){
	return $r;	
   }
    $r =new Redis();
    $r->connect('127.0.0.1','6379');
    return $r;
}
function islogin(){
#	var_dump($_COOKIE);
	if(!$_COOKIE || !$_COOKIE['userid'] || !$_COOKIE['username']){
		return false;
		}
		if(!$_COOKIE['authsecret']){
			return false;
			}
		  $r = connredis();
		 $authsecret = $r->get('user:userid:'.$_COOKIE['userid'].':authsecret');
#		 var_dump($authsecret,$_COOKIE);exit;
		 if($authsecret != $_COOKIE['authsecret']){
			 return false;
			 }
		return array('userid'=>$_COOKIE['userid'],'username'=>$_COOKIE['username']);
	}
	function formattime($time)
	{
		$sec = time()-$time;
		if($sec>=86400){
			return floor($sec/86400).'天';
			}elseif($sec>=3600){
				return floor($sec/3600).'小时';
				}elseif($sec>=60){
					return floor($sec/60).'分钟';
					}else{
						return $sec.'秒';
						
						}
		
		}
	
?>

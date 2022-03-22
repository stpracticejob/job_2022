<? //Вход под учётной записью пользователя (логины и пароли хранятся в БД)
require_once("$_SERVER[DOCUMENT_ROOT]/../dbinit.inc.php");

$msg="";
if(isset($_POST["Enter"]))
{
  $user_login=mysql_real_escape_string($_POST["user_login"]);
  $user_password=md5(mysql_real_escape_string($_POST["user_password"]));
  
  $res=mysql_query("SELECT * FROM Users WHERE Login='$user_login' AND Password='$user_password'",$cms_db_link);
  
  $parsed=parse_url($_SERVER["HTTP_REFERER"]);		
  $referer="$parsed[scheme]://$parsed[host]$parsed[path]";
 
  if($res && mysql_num_rows($res)>0)
	{		
		session_start();
		$_SESSION["authorized_ip"]=md5($_SERVER["REMOTE_ADDR"]);
		$_SESSION["user_info"]=mysql_fetch_array($res);
		header("Location: http://$_SERVER[HTTP_HOST]/");
	}
  else
	{
		$msg="Неправильный логин или пароль";
		header("Location: $referer?msg=$msg");
	}
}
?>
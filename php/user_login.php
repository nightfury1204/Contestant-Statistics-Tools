<?php
/**
* user login
*/
require_once('database_connection.php');
require_once('Bcrypt.php');
class login extends databaseConnect
{
	private $tableName = "user_account";
	function __construct(argument)
	{
		# code...
	}

	function login_attempt($username, $password)
	{
		dataConnect();
		$hashpassword = Bcrypt::hashPassword($password);
		$sql = "SELECT * FROM ".$tableName." WHERE username = '".$username."'' AND password = '".$hashpassword."' ";
		$result = $conection->query($sql);
		if($result->num_rows==1)
		{
			$row = $result->fetch_assoc();
			if(Bcrypt::checkPassword($password, $row["password"]))
			{
				dataClose();
				return "1";
			}
			else
			{
				dataClose();
			    return "-1";
			}
		}
		else
		{
			dataClose();
			return "-1";
		}
	}
}

$tryLogin = new login();
$userName = $_POST["username"];
$passWord = $_POST["password"];

if(tryLogin.login_attempt($userName, $passWord)=="1")
{
	/*redirect to user home*/
	header("Location:home");
}
else
{
	echo "WA";
}

?>
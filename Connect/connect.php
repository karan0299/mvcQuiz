<?php
	namespace Connect;
	class Connection{
		public static function getDB()
		{
			include __DIR__."/../configs/credentials.php";
			return new \PDO("mysql:dbname=".$db_connect['db_name'].";host=".$db_connect['server'].";charset=".$db_connect['charset'].";",$db_connect['username'],$db_connect['password'],$options);
		}
	}
?>
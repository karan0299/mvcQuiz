<?php
 
    namespace Models;


    class Admins
    {
        public static function authenticate($admname, $password) //used in AdminloginController
        {
            $db= self::getDB();
            $check_query=$db->prepare("SELECT password from Admins WHERE admname=:admname");
            $check_query->execute(array(
                                        "admname"=>$admname
                                            ));
            $result=$check_query->fetch(\PDO::FETCH_ASSOC);
            if($result["password"]===$password)
            {
                return true;
            }
            else
                return false;
        }

        public static function getDB()
        {   include __DIR__."/../../config/credentials.php";
            return new \PDO("mysql:dbname=".$db_connect['db_name'].";host=".$db_connect['server'].";",$db_connect['username'],$db_connect['password'],$options);
        }
    }


<?php
 
    namespace Models;
   

    class Users
    {   
        public static function authenticate($username, $password)
        {
            $db=self::getDB();//using static function
            $userlist= $db->prepare("SELECT * FROM Users WHERE username=:username and password=:password"); //make skeleton of query to prevent sql injection
            $userlist->execute(array(
                "username"=>$username,
                "password"=>$password
            ));
            $rows=$userlist->fetchAll();
          
            if(count($rows)==0)
                return false;

            else
                return true;


        }

        public static function UserList() //used in LeaderboardController
        {
            $db=self::getDB();
            $userlist= $db->prepare("SELECT username,score FROM Users ORDER BY score DESC"); 
            $userlist->execute();
            $rows = $userlist->fetchAll();
           
            $rank=0;
            $score=-1;
            $count=0;
            foreach ($rows as &$user) {
                if ($user["score"]==$score) {
                    $user["rank"]=$rank;
                    $count++;
                }
                else{
                    $rank=$rank+1+$count;
                    $score=$user["score"];
                    $user["rank"]=$rank;
                }
            }
            return $rows;
        }

        public static function getinfo($username) // used in LoginController
        {
            $db=self::getDB();
            $userlist= $db->prepare("SELECT * FROM Users WHERE username=:username"); 
            $userlist->execute(array(
                "username"=>$username
            ));
            $result=$userlist->fetch(\PDO::FETCH_ASSOC);
           
           return $result;

        }

        public static function updateUser($user,$quesinfo) //used in QuesController
        {
            $db=self::getDB();
            $userlist= $db->prepare("SELECT score FROM Users WHERE username=:username"); 
            $userlist->execute(array(
                "username"=>$user
            ));
            $result=$userlist->fetch(\PDO::FETCH_ASSOC);

            $score=$result["score"]+$quesinfo["points"];

            $userlist= $db->prepare("UPDATE `Users` SET `score`=:score WHERE username=:username"); 
            $userlist->execute(array(
                "username"=>$user,
                "score" => $score
            ));
     
            
        }

        public static function checkUser($username, $password)  //used in SignupController
        {
            $db=self::getDB();
            $userlist=$db->prepare("SELECT * FROM Users WHERE username=:username"); 
            $userlist->execute(array(
                "username"=>$username
            ));
            $result=$userlist->fetchAll();
           
          if(count($result)==0)
            return false;

            return true;
        }

        public static function addUser($username,$password) //used in SignupController
        {
            $db=self::getDB();
            $score=0;
            $password_hash=hash('sha256',$password);
            $user= $db->prepare("INSERT INTO Users (username,password,score) VALUES (:username,:password,:score)");
            $result=$user->execute(array(
                "username" => $username,
                "password" => $password_hash,
                "score" => $score
            ));
            return($result);
        }

        public static function getDB()
        {   include __DIR__."/../../config/credentials.php";
            return new \PDO("mysql:dbname=".$db_connect['db_name'].";host=".$db_connect['server'].";",$db_connect['username'],$db_connect['password'],$options);
        }
    }

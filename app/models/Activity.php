<?php
 
 namespace Models;
 

  class Activity
  { 
    public static function checkIfattemped($user,$num) //used in QuesController
    {
    $db= self::getDB();
    $check=$db->prepare("SELECT * from Activity WHERE username=:user and ques_solved=:num");
    $check->execute(array(
                        "user"=>$user,
                        "num"=>$num
                         ));
    $rows=$check->fetchAll();
    if(count($rows)!=0)
        return true;
    return false;
    }

    public static function update($user,$num) //used in QuesController
    {
        $db= self::getDB();
        $check=$db->prepare("INSERT INTO Activity (username, ques_solved) VALUES (:user , :num)");
        $check->execute(array(
                            "user"=>$user,
                            "num"=>$num
                            ));
    }

    public static function getDB()
    {include __DIR__."/../../config/credentials.php";
      return new \PDO("mysql:dbname=".$db_connect['db_name'].";host=".$db_connect['server'].";",$db_connect['username'],$db_connect['password'],$options);
    }
  }
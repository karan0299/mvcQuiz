<?php
    
    namespace Models;
    use Utils\Util;

    class Questions{

      
        
        public static function addNewQuestion($ques,$answer,$points,$comment,$adm)  //used in AddquesController
        {
            $db= self::getDB();
            $insert= $db->prepare("INSERT INTO Questions (statement,answer,points,no_of_users,creator,comment) VALUES (:ques,:answer,:points,:no_of_users,:adm,:comment)"); //make skeleton of query to prevent sql injection
            $result= $insert->execute(array(
                     "ques" => $ques,
                     "answer" => $answer,
                     "points" => $points,
                     "no_of_users" => 0,
                     "comment" => $comment,
                     "adm" => $adm,
                     ));
            return $result;

        }

        public static function getQueslist($flag) //ued in EditquesController
        {
            $db= self::getDB();
            if($flag)
            {
                $listquery=$db->prepare("SELECT * from Questions");
                $listquery->execute();
                $result=$listquery->fetchAll();
                return $result;
            }
            else
            {
                $listquery=$db->prepare("SELECT number,statement,points,comment from Questions");
                $listquery->execute();
                $result=$listquery->fetchAll();
                return $result;  
            }

        }

        public static function getQuesinfo($num,$flag) // used in QueseditController
        {
            $db= self::getDB();
            if($flag)
            {
                $listquery=$db->prepare("SELECT * from Questions WHERE number=:num");
                $listquery->execute(array(
                                        "num"=>$num
                                        ));
                
                $result=$listquery->fetch(\PDO::FETCH_ASSOC);
                
                return $result;
            }
            else
            {
                $listquery=$db->prepare("SELECT number,statement,points,comment,no_of_users,creator from Questions  WHERE number=:num ");
                $listquery->execute(array(
                                        "num"=>$num
                                        ));
                $result=$listquery->fetch(\PDO::FETCH_ASSOC);
                return $result;  
            }
        }
        
        public static function editQuestion($num,$ques,$answer,$points,$comment) // used in QueseditController
        {
            $db= self::getDB();
            $update=$db->prepare("UPDATE Questions SET statement=:ques , answer=:answer , points=:points , comment=:comment WHERE number=:num ");
            $result=$update->execute(array(
                                "ques"=>$ques,
                                "answer"=>$answer,
                                "num"=>$num,
                                "points"=>$points,
                                "comment"=>$comment
                                    ));
            return $result;                   
        }

        public static function checkanswerAndupdate($num,$answer,$res) //uesd in QuesController
        {
            $db= self::getDB();
            $answer_query=$db->prepare("SELECT answer,no_of_users,points from Questions WHERE number=:num");
            $answer_query->execute(array(
                                        "num"=>$num
                                        ));
            $result=$answer_query->fetch(\PDO::FETCH_ASSOC);
            $prev_no=$result["no_of_users"];
            if($answer===$result["answer"])
            {
                if(!$res)
                {
                    $new_no=$prev_no+1;
                    $update=$db->prepare("UPDATE Questions SET no_of_users=:new_no WHERE number=:num");
                    $result=$update->execute(array(
                                        "new_no"=>$new_no,
                                        "num"=>$num
                                            )); 
                              
                }
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function getDB()
        {   include __DIR__."/../../config/credentials.php";
            return new \PDO("mysql:dbname=".$db_connect['db_name'].";host=".$db_connect['server'].";",$db_connect['username'],$db_connect['password'],$options);
        }
    }

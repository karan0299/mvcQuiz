<?php

    namespace Controllers;
    use Models\Questions;
    use Models\Users;
    use Models\Activity;

    session_start();

    class QuesController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }
        
        public function get($num)
        {   
            if(isset($_SESSION["user"]))
            {
                $quesinfo=Questions::getQuesinfo($num,false);
            
                echo $this->twig->render("question.html",array(
                    "title"=>$num,
                    "ques"=>$quesinfo
                    ));
            }
            else
            {
                echo $this->twig->render("question.html",array(
                    "title"=>"Question",
                    "ques"=>$quesinfo,
                    "error1"=>"You are not logged in , you cannot attempt the question"
                    ));
            }

        }


        public function post($num)
        {
            $quesinfo=Questions::getQuesinfo($num,false);
            if($_SESSION["user"])
            {
                $error1="";
                $res=Activity::checkIfattemped($_SESSION["user"],$num);
                if($res)
                {
                    $error1="Already Attempted!! Score will no be increased if attempted again";

                }
            
                    $answer=$_POST["answer"];
                    $result=Questions::checkanswerAndupdate($num,$answer,$res);
                    if($result)
                    {   if(!$res){
                            Users::updateUser($_SESSION["user"],$quesinfo);
                            Activity::update($_SESSION["user"],$num);
                            $quesinfo=Questions::getQuesinfo($num,false);
                        }
                        echo $this->twig->render("question.html",array(
                                                "title"=>"Question",
                                                "ques"=>$quesinfo,
                                                "error1"=>$error1,
                                                "error"=>"correct Answer"
                                                ));
                    }
                    else
                        echo $this->twig->render("question.html",array(
                                                "title"=>"Question",
                                                "ques"=>$quesinfo,
                                                "error1"=>$error1,
                                                "error"=>"Incorrect Answer"
                                                ));
                
            }
            else
            {
                echo $this->twig->render("question.html",array(
                                        "title"=>"Question",
                                        "ques"=>$quesinfo,
                                        "error1"=>"You are not logged in , you cannot attempt the question"
                                        ));
            }
        }
    }
?>

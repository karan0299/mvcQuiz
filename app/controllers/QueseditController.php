<?php

    namespace Controllers;
    use Models\Questions;

    session_start();

    class QueseditController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }

        public function get($num)
        {   
            if(isset($_SESSION["admin"]))
            {
                $quesinfo=Questions::getQuesinfo($num,true);
            
                echo $this->twig->render("questionedit.html",array(
                    "title"=>$num,
                    "ques"=>$quesinfo
                    ));
            }
            else
            {
                header("location:\adminlogin");
            }

        }

        public function post($num)
        {

                if($_SESSION["admin"])
                {
                   $quesinfo=Questions::getQuesinfo($num,true);
                   if(isset($_POST["submit"]))
                   {
                        $ques=$_POST["ques"];
                        $answer=$_POST["answer"];
                        $points=$_POST["points"];
                        $comment=$_POST["comment"];
                        $result=Questions::editQuestion($num,$ques,$answer,$points,$comment);
                        if($result)
                        {
                            $quesinfo=Questions::getQuesinfo($num,true);
                            echo $this->twig->render("questionedit.html",array(
                                                    "title"=>$num,
                                                    "error"=>"Ediited successfuly",
                                                    "ques"=>$quesinfo
                                                    ));
                        }
                        else
                            echo $this->twig->render("questionedit.html",array(
                                                    "title"=>$num,
                                                    "error"=>"Unsuccessful!! try agin later",
                                                    "ques"=>$quesinfo
                                                    ));
                    }  
                }
                
                else
                {
                    header("loaction:\adminlogin");
                }
        }
    }
?>

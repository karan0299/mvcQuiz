<?php
   
    namespace Controllers;
    use Models\Questions;
    session_start();
    class AddquesController
    {

        protected $twig ;
        public $error;
        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }
        
        public static function checkSession()
        {
            if(isset($_SESSION["admin"]))
                $admin=true;
            else
                $admin=false;
            return $admin;
        } 

        public function get()
        {   
            $admin=self::checkSession();
            echo $this->twig->render("addques.html", array(
                    "title" => "Addques",
                    "admin" => $admin,
                    "error"=>"Unauthorized access")) ;
        }

        public function post()
        {
           
            $ques=$_POST["ques"];
            $answer=$_POST["answer"];
            $points=$_POST["points"];
            $comment=$_POST["comment"];
            if(self::checkSession())
            {
                if( isset($ques) && 
                    isset($answer) &&
                    isset($points) &&
                    isset($comment))
                {
                    $result=Questions::addNewQuestion($ques,$answer,$points,$comment,$_SESSION["admin"]);
                    
                    if($result)
                        $error1="New Question Added suceessfully";
                    else
                        $error1="Unsuccessful!! someproblem in input fields";
                   
                    $_POST=array();
                }
                else 
                    $error1="Somefields are empty";
            }
            else
                $error1="Your are not logged in as admin !! not Authorized Access";

            echo $this->twig->render("addques.html",array(
                                "admin"=>self::checksession(),
                                "ques"=>$ques,
                                "answer"=>$answer,
                                "points"=>$points,
                                "comment"=>$comment,
                                "error1"=>$error1));
        }
    }
?>

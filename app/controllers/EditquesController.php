<?php

    namespace Controllers;
    use Models\Questions;

    session_start();

    class EditQuesController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }

        public function get()
        {

                if($_SESSION["admin"])
                {
                    $queslist=Questions::getQueslist(true);
                    echo $this->twig->render("editques.html", array(
                                            "title" => "EditQuestion",
                                            "queslist"=>$queslist
                                            )) ;
                }
                else
                {
                    header("loaction:\adminlogin");
                }
        }
    }
?>

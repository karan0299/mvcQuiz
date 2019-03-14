<?php

    namespace Controllers;
    use Models\Questions;

    session_start();

    class ProblemsController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }

        public function get()
        {

              
                    $queslist=Questions::getQueslist(false);
                    echo $this->twig->render("problems.html", array(
                                            "title" => "Problems",
                                            "queslist"=>$queslist
                                            )) ;
              
        }
    }
?>

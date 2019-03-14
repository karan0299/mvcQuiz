<?php
    
    namespace Controllers;  
    
    session_start();
   
    class LogoutController{
        protected $twig;
        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ; 
            $this->twig = new \Twig_Environment($loader) ;
        }
        public function get() {
            session_unset();
            session_destroy();
            echo $this->twig->render("home.html",array(
                "title" => "home",
            ));
        }
    }
?>
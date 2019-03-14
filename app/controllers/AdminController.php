<?php

    namespace Controllers;
    
    session_start();

    class AdminController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }
       
        public function get()
        {   
            $admname=$_SESSION["admin"];
            if($admname)
            {
            echo $this->twig->render("admin.html",array(
                            "title"=>"AdminPortal",
                            "admin"=>$admname,
                             ));
            }
            else
			{
				echo $this->twig->render("adminlogin.html" , array(
                                "title"=>"Login",
                                "error"=>"Not Logged in as Admin first login"
				                ));
			}
        }   
    }
?>
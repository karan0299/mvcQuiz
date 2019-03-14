<?php
    namespace Controllers;
    use Models\Admins;
    session_start();
    class AdminloginController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }
        public function get() 
        {
			    echo $this->twig->render("adminlogin.html",array(
                                    "title"=>"LoginAdmin"
                                     ));
		}
		public function post()
		{
			$admname=$_POST['admname'] ;
            $password=$_POST['password'];
            if(isset($admname)&&isset($password)&&Admins::authenticate($admname, $password))
			{   
                $_POST=array(); 
                $_SESSION["admin"]=$admname;
                header("Location: /admin");
			}
			else
			{
				echo $this->twig->render("adminlogin.html" , array(
                                "title"=>"Login",
                                "error"=>"Invalid username or password"
				                ));
			}
		}
    }
?>

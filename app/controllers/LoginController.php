<?php
	namespace Controllers ;
    use Models\Users ;
    session_start();
	class LoginController
	{
		protected $twig ;
		public function __construct()
		{
			$loader = new \Twig_Loader_Filesystem(__DIR__ . "/../views") ;
			$this->twig = new \Twig_Environment($loader) ;
		}
		public function get() {
			echo $this->twig->render("login.html",array(
							"title"=>"LoginUser")) ;
		}
		public function post()
		{
			$username=$_POST['username'] ;
			$password=hash('sha256',$_POST['password'] );
			
            if(isset($username)&&isset($password)&&Users::authenticate($username, $password))
			{   
                $_SESSION["user"]=$username;
                $aboutuser=Users::getinfo($username);
				echo $this->twig->render("home.html",array(
                                "title"=>"Home",
                                "user"=>true,
                                "username"=>$username,
                                "attempted"=>$aboutuser["no_of_ques"],
                                 ));
			}
			else
			{
				echo $this->twig->render("login.html" , array(
					"title"=>"Login",
					"error"=>"Invalid username or password"
				));
			}
		}
	}
?>

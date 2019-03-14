<?php
	namespace Controllers ;
	use Models\Users;
	class SignupController
	{
		protected $twig ;
		public function __construct()
		{
			$loader = new \Twig_Loader_Filesystem(__DIR__ . "/../views") ;
			$this->twig = new \Twig_Environment($loader) ;
		}
		public function get() {
			echo $this->twig->render("signup.html",array(
							"title"=>"SignUp")) ;
		}
		public function post()
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			if(isset($username)&&isset($password))
			{  
				if(Users::checkUser($username, $password))
				{
					echo $this->twig->render("signup.html",array(
											"title"=>"SignUp",
											"error"=>"Username already taken",
											"username"=>$username
											)) ;
				}
				else
				{
				$result=Users::addUser($username,$password);
					if($result)
						echo $this->twig->render("signup.html",array(
												"title"=>"SignUp",
												"error"=>"Successfully Registered",
												"username"=>$username
												)) ;
					else 
						echo $this->twig->render("signup.html",array(
												"title"=>"SignUp",
												"error"=>"Some server problem try again later",
												"username"=>$username
												)) ;	
				}
			}
			else
			{
				echo $this->twig->render("signup.html",array(
										"title"=>"SignUp",
										"error"=>" fields are empty ",
										)) ;
			}		
		}
	}
?>
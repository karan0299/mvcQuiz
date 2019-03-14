<?php

    namespace Controllers;
    use Models\Users;
    session_start();

    class LeaderboardController
    {

        protected $twig ;

        public function __construct()
        {
            $loader = new \Twig_Loader_Filesystem(__DIR__ . '/../views') ;
            $this->twig = new \Twig_Environment($loader) ;
        }

        public function get()
        {
            if(isset($_SESSION["user"]))
                $user=true;
            else
                $user=false;
            $row=Users::UserList();
            echo $this->twig->render("leaderboard.html",array(
                                    "title" => "Leaderboard",
                                    "user"=>$user,
                                    "userlist"=> $row));
        }
    }
?>
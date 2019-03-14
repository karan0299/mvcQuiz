<?php
require_once __DIR__ . "/../vendor/autoload.php";
Toro::serve(array(
	"/" => "Controllers\\HomeController",
	"/login" => "Controllers\\LoginController",
	"/signup" =>"Controllers\\SignupController",
    "/leaderboard" => "Controllers\\LeaderboardController",
    "/logout" => "Controllers\\LogoutController",
    "/admin" => "Controllers\\AdminController",
    "/addques" => "Controllers\\AddquesController",
    "/editques" => "Controllers\\EditquesController",
    "/adminlogin" => "Controllers\\AdminloginController",
    "/deleteuser" => "Controllers\\DeleteuserController",
    "/problems" => "Controllers\\ProblemsController",
    "/problems/([0-9]+)" => "Controllers\\QuesController",
    "/editques/([0-9]+)" => "Controllers\\QueseditController"))
?>

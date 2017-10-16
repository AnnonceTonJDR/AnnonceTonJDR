<?php
include_once("../constant.php");
include_once("../services.php");

class User extends Services
{
    private $_table_name = "user";

    private $_id;
    private $_user_name;
    private $_user_password;
    private $_user_salt;


    public function create_password(string $password)
    {
        $this->hashPass($password);
    }
}


$test = new user();
$test->makeCookie('aaaaaa');
echo '<br>';
echo '-------------------';
echo '<br>';
echo $_COOKIE["last-connect"];
echo '<br>';
echo $_COOKIE["last-hash"];

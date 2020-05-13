<?php

class User
{

    public $login;
    private $password;
    private $registration_time;

    public function __construct($username, $password, $registrationTime)
    {

        $this->login = $username;
        $this->password = $password;
        $this->registration_time = $registrationTime;

    }

    /**
     * @return string
     */
    function getRegistrationDate()
    {
        return date("H:i d.m.Y", $this->registration_time);
    }

    /**
     * @param string $login
     * @param string $password
     *
     * @return bool
     */
    function authenticate($login, $password)
    {
        return ($this->login == $login) && ($this->password == $password);
    }

}

/**
 * @return User[]
 */
function getAllUsers()
{

    return [
        32 => new User("admin", "admin", 1589386389),
        64 => new User("user", "user", 1589386389),
    ];

}

/**
 * @param string $login
 * @param string $password
 * @return bool
 */
function login($login, $password)
{

    foreach (getAllUsers() as $id => $user) {

        if ($user->authenticate($login, $password)) {

            $_SESSION["user"] = $user;
            return true;

        }

    }

    return false;

}

/**
 * @return User|null
 */
function getCurrentUser()
{
    return isset($_SESSION["user"]) ? $_SESSION['user'] : null;
}

/**
 * @return bool|string
 */
function authorization()
{

    if (isset($_POST["login"]) && isset($_POST["password"])) {

        if (!login($_POST["login"], $_POST["password"])) {
            return "Неправильный логин или пароль";
        } else {
            return "Успешная авторизация!";
        }

    }

    return false;

}
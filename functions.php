<?php

/**
 * @return string[][]
 */
function getAllUsers()
{

    return [
        32 => [
            "login" => "admin",
            "password" => "admin",
        ],
        64 => [
            "login" => "user",
            "password" => "user"
        ],
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

        if (($user["login"] == $login) && ($user["password"] == $password)) {

            $_SESSION["userId"] = $id;
            return true;

        }

    }

    return false;

}

/**
 * @return string
 */
function getCurrentUserName()
{

    if (isset($_SESSION["userId"])) {

        $user = getAllUsers()[$_SESSION["userId"]];
        return $user["login"];

    }


    return "";
}

/**
 * @return bool|string
 */
function authorization() {

    if (isset($_POST["login"]) && isset($_POST["password"])) {

        if (!login($_POST["login"], $_POST["password"])) {
            return "Неправильный логин или пароль";
        } else {
            return "Успешная авторизация!";
        }

    }

    return false;
}
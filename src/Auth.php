<?php

namespace Job\Auth;

use Flight;

class Role
{
    public const ADMIN = 1;
    public const ASPIRANT = 2;
    public const EMPLOYER = 3;
    public const ADVERTISER = 4;
}

global $_SESSION;

class User
{
    private $user_authorized = false;
    private $admin_authorized = false;

    public function authUser($login, $password)
    {
        return Flight::db()->authUser($login, $password);
    }

    public function logout()
    {
        unset($_SESSION['user_info']);
    }

    public function getUserInfo()
    {
        return $_SESSION['user_info'] ?? null;
    }

    public function getUserName()
    {
        return $_SESSION['user_info']['UserName'] ?? '';
    }

    public function isUserAuthorized()
    {
        return (bool) ($_SESSION['user_info'] ?? false);
    }

    public function isUserAdmin()
    {
        return $_SESSION['user_info'] ?? ['RoleID'] == Role::ADMIN;
    }

    public function isUserAspirant()
    {
        return $_SESSION['user_info'] ?? ['RoleID'] == Role::ASPIRANT;
    }

    public function isUserEmployer()
    {
        return $_SESSION['user_info'] ?? ['RoleID'] == Role::EMPLOYER;
    }

    public function isUserAdvertiser()
    {
        return $_SESSION['user_info'] ?? ['RoleID'] == Role::ADVERTISER;
    }
}

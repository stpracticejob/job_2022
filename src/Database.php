<?php

namespace Job\Database;

use PDO;

class DB extends PDO
{
    public function getUser($email)
    {
        $stmt = $this->prepare('SELECT COUNT(*) AS NUM FROM users WHERE Login = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch()['NUM'];
    }

    public function authUser($login, $password)
    {
        $stmt = $this->prepare('SELECT * FROM Users WHERE Login = :login AND Password = :password LIMIT 1');
        $stmt->execute(['login' => $login, 'password' => md5($password)]);

        $user_info = $stmt->fetch();

        if ($user_info !== false) {
            $_SESSION['user_info'] = $user_info;
            return true;
        }

        $_SESSION['user_info'] = null;

        return false;
    }

    public function addUser($username, $email, $password, $roleid)
    {
        $stmt = $this->prepare('INSERT INTO users(UserName, Login, Password, RoleID) VALUES (:username, :email, :password, :roleid)');
        $stmt->execute(['username' => $username, 'email' => $email, 'password' => md5($password), 'roleid' => $roleid]);
    }

    public function fetchAdvertises()
    {
        $stmt = $this->prepare('
	    SELECT advertise.ID As ID,
		   users.login As Author,
		   users.ID As AuthorID,
		   advertise.Title As Title,			
		   advertise.DateTime As DateTime,
		   advertise.Content As Content
	    FROM advertise, users 
	    WHERE advertise.UserID=Users.ID
	    ORDER BY DateTime DESC');
        $stmt->execute();
        return $stmt;
    }

    public function fetchSections()
    {
        $stmt = $this->prepare('SELECT * FROM sections');
        $stmt->execute();
        return $stmt;
    }

    public function fetchEmployer($id)
    {
        $stmt = $this->prepare('SELECT * FROM employers WHERE UserID = :id');
        $stmt->execute(['id' => $id]);
        return $stmt;
    }

    public function fetchVacancies($user_id = -1, $section_id = -1)
    {
        $filter = '';
        $params = [];

        if ($user_id != -1) {
            $filter = 'AND UserID = :UserID ';
            $params['UserID'] = $user_id;
        }

        if ($section_id != -1) {
            $filter .= 'AND SectionID = :SectionID ';
            $params['SectionID'] = $section_id;
        }

        $stmt = $this->prepare("
	    SELECT vacancy.ID As ID,
		   users.login As Author,
		   users.ID As AuthorID,
		   vacancy.Title As Title,
		   vacancy.Salary As Salary,
		   vacancy.DateTime As DateTime
	    FROM vacancy, users 
	    WHERE vacancy.UserID=users.ID
            $filter
            ORDER BY DateTime DESC");
        $stmt->execute($params);
        return $stmt;
    }

    public function fetchVacancy($id)
    {
        $stmt = $this->prepare('SELECT * FROM vacancy WHERE ID = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

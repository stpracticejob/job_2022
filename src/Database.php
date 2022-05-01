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
    //<--Вакансии
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
		   vacancy.Content As Content,
		   vacancy.Salary As Salary,
		   vacancy.Experience As Experience,
		   vacancy.IsMain As IsMain,
		   vacancy.IsPartnership As IsPartnership,
		   vacancy.IsRemote As IsRemote,
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
    public function addVacancy($user_id, $section_id, $title, $content, $salary, $experience, $is_main, $is_partnership, $is_remote, $data_time)
    {
        return $this->prepare(
            'INSERT INTO vacancy(UserID, SectionID, Title, Content, Salary, Experience, IsMain, IsPartnership, IsRemote, DateTime)
            VALUES (:user_id, :section_id,:title, :content, :salary, :experience, :is_main, :is_partnership, :is_remote, :datetime)'
        )->execute([
            'user_id' => $user_id, 'section_id' => $section_id, 'title' => $title,
            'content' => $content, 'salary' => $salary, 'experience' => $experience,
            'is_main' => $is_main, 'is_partnership' => $is_partnership,
            'is_remote' => $is_remote, 'datetime' => $data_time
        ]);
    }

    public function updateVacancy($id, $user_id, $section_id, $title, $content, $salary, $experience, $is_main, $is_partnership, $is_remote, $data_time)
    {
        return $this->prepare(
            'UPDATE vacancy SET UserID = :user_id, SectionID = :section_id,
            Title = :title, Content = :content, Salary = :salary, Experience = :experience, IsMain = :is_main, IsPartnership = :is_partnership, IsRemote = :is_remote, DateTime = :datetime
            WHERE ID = :id'
        )->execute([
            'id' => $id,
            'user_id' => $user_id, 'section_id' => $section_id, 'title' => $title,
            'content' => $content, 'salary' => $salary, 'experience' => $experience,
            'is_main' => $is_main, 'is_partnership' => $is_partnership,
            'is_remote' => $is_remote, 'datetime' => $data_time
        ]);
    }

    public function deleteVacancy($id)
    {
        return $this->prepare('DELETE FROM vacancy WHERE ID = :id LIMIT 1')
            ->execute(['id' => $id]);
    }
    //Вакансии-->
    public function countCv()
    {
        $stmt = $this->prepare('SELECT COUNT(*) FROM cv');
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public function fetchCvs()
    {
        $stmt = $this->prepare(
            'SELECT cv.ID, cv.UserID, users.UserName,
            cv.SectionID, sections.Name as SectionName,
            cv.Title, cv.Content, cv.DateTime
            FROM cv, sections, users
            WHERE cv.SectionID = Sections.ID AND cv.UserID = Users.ID
            ORDER BY DateTime DESC'
        );
        $stmt->execute();
        return $stmt;
    }

    public function fetchCv($id)
    {
        $stmt = $this->prepare('SELECT * FROM cv WHERE ID = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCv($user_id, $section_id, $title, $content, $datetime)
    {
        return $this->prepare(
            'INSERT INTO cv(UserID, SectionID, Title, Content, DateTime)
            VALUES (:user_id, :section_id, :title, :content, :datetime)'
        )->execute([
            'user_id' => $user_id, 'section_id' => $section_id, 'title' => $title,
            'content' => $content, 'datetime' => $datetime
        ]);
    }

    public function updateCv($id, $user_id, $section_id, $title, $content, $datetime)
    {
        return $this->prepare(
            'UPDATE cv SET UserID = :user_id, SectionID = :section_id,
            Title = :title, Content = :content, DateTime = :datetime
            WHERE ID = :id'
        )->execute([
            'id' => $id,
            'user_id' => $user_id, 'section_id' => $section_id, 'title' => $title,
            'content' => $content, 'datetime' => $datetime
        ]);
    }

    public function deleteCv($id)
    {
        return $this->prepare('DELETE FROM cv WHERE ID = :id LIMIT 1')
            ->execute(['id' => $id]);
    }
}

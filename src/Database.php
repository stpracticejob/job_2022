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

    public function countUsers()
    {
        $stmt = $this->prepare('SELECT COUNT(*) FROM users');
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public function fetchUsers()
    {
        $stmt = $this->prepare('
	    SELECT users.ID,
		   users.UserName,
		   users.Login,
		   users.RoleID,
           user_roles.Name as RoleName,
           users.State
           FROM users, user_roles
           WHERE user_roles.ID = users.RoleID
           ORDER BY users.ID DESC');
        $stmt->execute();
        return $stmt;
    }

    public function fetchUser($id)
    {
        $stmt = $this->prepare('SELECT ID, UserName, Login, RoleID, State FROM users WHERE ID = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($username, $login, $password, $roleid, $state)
    {
        return $this->prepare(
            'INSERT INTO users(UserName, Login, Password, RoleID, State) VALUES (:username, :login, :password, :roleid, :state)'
        )->execute([
            'username' => $username, 'login' => $login, 'password' => md5($password),
            'roleid' => $roleid, 'state' => $state
        ]);
    }

    public function updateUser($id, $username, $login, $password, $roleid, $state)
    {
        return $this->prepare(
            'UPDATE users SET UserName = :username,
            Login = :login, Password = :password, RoleID = :roleid, State = :state
            WHERE ID = :id'
        )->execute([
            'id' => $id,
            'username' => $username, 'login' => $login,
            'password' => md5($password), 'roleid' => $roleid,
            'state' => $state
        ]);
    }

    public function deleteUser($id)
    {
        return $this->prepare('DELETE FROM users WHERE ID = :id LIMIT 1')
            ->execute(['id' => $id]);
    }

    public function countAdvertises($with_outdated = false)
    {
        $stmt = $this->prepare(
            'SELECT COUNT(*) FROM advertise'
            .($with_outdated ? '' : ' WHERE advertise.DateTime > (CURRENT_DATE - INTERVAL 6 MONTH)')
        );
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public function fetchAdvertises($with_outdated = false)
    {
        $stmt = $this->prepare(
            'SELECT advertise.ID,
		    users.ID As UserID,
		    users.login As UserLogin,
		    advertise.Title,	
		    advertise.Content,		
		    advertise.DateTime
	        FROM advertise, users 
	        WHERE advertise.UserID=users.ID '
            .($with_outdated ? '' : 'AND advertise.DateTime > (CURRENT_DATE - INTERVAL 6 MONTH) ').
            'ORDER BY DateTime DESC'
        );
        $stmt->execute();
        return $stmt;
    }

    public function fetchAdvertise($id)
    {
        $stmt = $this->prepare('SELECT * FROM advertise WHERE ID = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addAdvertise($user_id, $title, $content)
    {
        return $this->prepare(
            'INSERT INTO advertise(UserID, Title, Content, DateTime)
            VALUES (:user_id, :title, :content, :datetime)'
        )->execute([
            'user_id' => $user_id,
            'title' => $title, 'content' => $content,
            'datetime' => date("Y-m-d H:i:s")
        ]);
    }

    public function updateAdvertise($id, $user_id, $title, $content)
    {
        return $this->prepare(
            'UPDATE advertise SET UserID = :user_id,
            Title = :title, Content = :content
            WHERE ID = :id'
        )->execute([
            'id' => $id,
            'user_id' => $user_id,
            'title' => $title, 'content' => $content,
        ]);
    }

    public function deleteAdvertise($id)
    {
        return $this->prepare('DELETE FROM advertise WHERE ID = :id LIMIT 1')
            ->execute(['id' => $id]);
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

    public function countVacancy($with_outdated = false)
    {
        $stmt = $this->prepare(
            'SELECT COUNT(*) FROM vacancy'
            .($with_outdated ? '' : ' WHERE vacancy.DateTime > (CURRENT_DATE - INTERVAL 6 MONTH) ')
        );
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public function fetchVacancies($with_outdated = false)
    {
        $stmt = $this->prepare(
            'SELECT vacancy.ID As ID,
		    users.Login As UserLogin,
		    users.ID As UserID,
            sections.ID As SectionID,
            sections.Name As SectionName,
		    vacancy.Title As Title,
		    vacancy.Content As Content,
		    vacancy.Salary As Salary,
		    vacancy.Experience As Experience,
		    vacancy.IsMain As IsMain,
		    vacancy.IsPartnership As IsPartnership,
		    vacancy.IsRemote As IsRemote,
		    vacancy.DateTime As DateTime
	        FROM vacancy, sections, users
            WHERE vacancy.SectionID = sections.ID AND vacancy.UserID = users.ID '
            .($with_outdated ? '' : 'AND vacancy.DateTime > (CURRENT_DATE - INTERVAL 6 MONTH) ').
            'ORDER BY DateTime DESC'
        );
        $stmt->execute();
        return $stmt;
    }

    public function fetchVacancy($id)
    {
        $stmt = $this->prepare('SELECT * FROM vacancy WHERE ID = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addVacancy($user_id, $section_id, $title, $content, $salary, $experience, $is_main, $is_partnership, $is_remote)
    {
        return $this->prepare(
            'INSERT INTO vacancy(UserID, SectionID, Title, Content, Salary, Experience, IsMain, IsPartnership, IsRemote, DateTime)
            VALUES (:user_id, :section_id,:title, :content, :salary, :experience, :is_main, :is_partnership, :is_remote, :datetime)'
        )->execute([
            'user_id' => $user_id, 'section_id' => $section_id, 'title' => $title,
            'content' => $content, 'salary' => $salary, 'experience' => $experience,
            'is_main' => $is_main, 'is_partnership' => $is_partnership,
            'is_remote' => $is_remote, 'datetime' => date("Y-m-d H:i:s")
        ]);
    }

    public function updateVacancy($id, $user_id, $section_id, $title, $content, $salary, $experience, $is_main, $is_partnership, $is_remote)
    {
        return $this->prepare(
            'UPDATE vacancy SET UserID = :user_id, SectionID = :section_id,
            Title = :title, Content = :content, Salary = :salary, Experience = :experience, IsMain = :is_main, IsPartnership = :is_partnership, IsRemote = :is_remote
            WHERE ID = :id'
        )->execute([
            'id' => $id,
            'user_id' => $user_id, 'section_id' => $section_id, 'title' => $title,
            'content' => $content, 'salary' => $salary, 'experience' => $experience,
            'is_main' => $is_main, 'is_partnership' => $is_partnership,
            'is_remote' => $is_remote
        ]);
    }

    public function deleteVacancy($id)
    {
        return $this->prepare('DELETE FROM vacancy WHERE ID = :id LIMIT 1')
            ->execute(['id' => $id]);
    }

    public function countCv($with_outdated = false)
    {
        $stmt = $this->prepare(
            'SELECT COUNT(*) FROM cv'
            .($with_outdated ? '' : ' WHERE cv.DateTime > (CURRENT_DATE - INTERVAL 6 MONTH) ')
        );
        $stmt->execute();
        return $stmt->fetch()[0];
    }

    public function fetchCvs($with_outdated = false)
    {
        $stmt = $this->prepare(
            'SELECT cv.ID, cv.UserID, users.UserName,
            cv.SectionID, sections.Name as SectionName,
            cv.Title, cv.Content, cv.DateTime
            FROM cv, sections, users
            WHERE cv.SectionID = Sections.ID AND cv.UserID = users.ID '
            .($with_outdated ? '' : 'AND cv.DateTime > (CURRENT_DATE - INTERVAL 6 MONTH) ').
            'ORDER BY DateTime DESC'
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

    public function addCv($user_id, $section_id, $title, $content)
    {
        return $this->prepare(
            'INSERT INTO cv(UserID, SectionID, Title, Content, DateTime)
            VALUES (:user_id, :section_id, :title, :content, :datetime)'
        )->execute([
            'user_id' => $user_id, 'section_id' => $section_id,
            'title' => $title, 'content' => $content,
            'datetime' => date("Y-m-d H:i:s")
        ]);
    }

    public function updateCv($id, $user_id, $section_id, $title, $content)
    {
        return $this->prepare(
            'UPDATE cv SET UserID = :user_id, SectionID = :section_id,
            Title = :title, Content = :content
            WHERE ID = :id'
        )->execute([
            'id' => $id,
            'user_id' => $user_id, 'section_id' => $section_id,
            'title' => $title, 'content' => $content
        ]);
    }

    public function deleteCv($id)
    {
        return $this->prepare('DELETE FROM cv WHERE ID = :id LIMIT 1')
            ->execute(['id' => $id]);
    }
}

<?php

require_once("$_SERVER[DOCUMENT_ROOT]/../db/common.dal.inc.php");
function DBCheckUser($email)
{
    $a = _DBGetQuery("SELECT COUNT(*) As N FROM users WHERE Login='$email'");
    return $a["N"];
}

function DBAddUser($username, $email, $password, $roleid)
{
    _DBQuery("
	INSERT INTO users(UserName,Login,Password,RoleID) 
	VALUES('$username','$email','$password','$roleid')");
}
//---------------------------------------------
function DBAddAspirant($userid, $age, $limitsid, $driverstateid)
{
    _DBQuery("INSERT INTO aspirants(UserID,Age,LimitsID,DriverStateID) 
	VALUES ('$userid','$age','$limitsid','$driverstateid')");
}

function DBUpdateAspirant($ID, $age, $limitsid, $driverstateid)
{
    _DBQuery("
	UPDATE aspirants SET Age='$age',LimitsID='$limitsid',DriverStateID='$driverstateid'  
	WHERE ID=$ID");
}

function DBGetAspirant($UserID)
{
    return _DBGetQuery("SELECT * FROM aspirants WHERE UserID=$UserID");
}
//---------------------------------------------
function DBAddEducation($userid, $edtype, $edname, $edyear)
{
    _DBQuery("INSERT INTO educations(UserID,EducationTypeID,Name,Year)
	VALUES ('$userid','$edtype','$edname','$edyear')");
}

function DBUpdateEducation($ID, $edtype, $edname, $edyear)
{
    _DBQuery("UPDATE educations 
	SET EducationTypeID='$edtype',Name='$edname',Year='$edyear'
	WHERE ID=$ID");
}

function DBDeleteEducation($ID)
{
    _DBQuery("DELETE FROM educations WHERE ID=$ID");
}

function DBGetEducation($ID)
{
    return _DBGetQuery("SELECT * FROM educations WHERE ID=$ID");
}

function DBFetchEducation($UserID)
{
    return _DBFetchQuery("
		SELECT 
			educations.ID As ID,
			educationtypes.Name As Type,
			educations.Name As Name,
			educations.Year As Year
		FROM educations,educationtypes 
		WHERE 
			educations.EducationTypeID=educationtypes.ID AND
			UserID=$UserID
	");
}
//---------------------------------------------
function DBFetchEducationType()
{
    return _DBFetchQuery("SELECT * FROM educationtypes");
}
//---------------------------------------------
function DBFetchOf()
{
    return _DBFetchQuery("SELECT * FROM ofs ORDER BY Name ASC");
}
//---------------------------------------------
function DBAddEmployer($userid, $name, $tpi, $ofid)
{
    return _DBQuery("INSERT INTO employers(UserID,Name,Tpi,OfID)
	VALUES('$userid','$name','$tpi','$ofid')");
}

function DBUpdateEmployer($id, $name, $tpi, $ofid)
{
    return _DBQuery("UPDATE employers SET Name='$name',Tpi='$tpi',OfID='$ofid' WHERE ID=$id");
}

function DBGetEmployer($ID)
{
    return _DBGetQuery("SELECT * FROM employers WHERE UserID=$ID");
}
//---------------------------------------------
function DBAddAdvertiser($userid, $name, $advtypeid)
{
    return _DBQuery("INSERT INTO advertisers(UserID,Name,AdvertiserTypeID)
	VALUES('$userid','$name','$advtypeid')");
}

function DBUpdateAdvertiser($id, $name, $advtypeid)
{
    return _DBQuery("UPDATE advertisers SET Name='$name',AdvertiserTypeID='$advtypeid' WHERE ID=$id");
}

function DBGetAdvertiser($ID)
{
    return _DBGetQuery("SELECT * FROM advertisers WHERE UserID=$ID");
}
//---------------------------------------------
function DBAddSection($name)
{
    _DBQuery("INSERT INTO sections(Name) VALUES('$name')");
}

function DBUpdateSection($id, $name)
{
    _DBQuery("UPDATE sections SET Name='$name' WHERE ID=$id");
}

function DBDeleteSection($id)
{
    _DBQuery("DELETE FROM sections WHERE ID=$id");
}

function DBGetSection($id)
{
    return _DBGetQuery("SELECT * FROM sections WHERE ID=$id");
}

function DBFetchSection()
{
    return _DBFetchQuery("SELECT * FROM sections");
}
//---------------------------------------------
function DBAddVacancy($userid, $title, $sectionid, $content, $experience, $salary, $ismain, $ispartnership, $isremote)
{
    _DBQuery("INSERT INTO vacancy(UserID,Title,SectionID,Content,Experience,Salary,IsMain,IsPartnership,IsRemote,DateTime) 
	 VALUES('$userid','$title','$sectionid','$content','$experience','$salary','$ismain','$ispartnership','$isremote','".date("Y-m-d H:i:s")."')");
}

function DBUpdateVacancy($id, $title, $sectionid, $content, $experience, $salary, $ismain, $ispartnership, $isremote)
{
    _DBQuery("UPDATE vacancy 
			SET Title='$title',
			SectionID='$sectionid',Content='$content',Experience='$experience',
			Salary='$salary',IsMain='$ismain',IsPartnership='$ispartnership',
			IsRemote='$isremote' WHERE id=$id");
}

function DBDeleteVacancy($ID)
{
    _DBQuery("DELETE FROM Vacancy WHERE ID=$ID");
}

function DBGetVacancy($ID)
{
    return _DBGetQuery("SELECT * FROM vacancy WHERE ID=$ID");
}

function DBFetchVacancy($UserID = -1, $SectionID = -1)
{
    $filter = "";
    if ($UserID == -1) {
        $filter = "";
    } else {
        $filter = "AND UserID=$UserID ";
    }

    if ($SectionID == -1) {
        $filter = "";
    } else {
        $filter .= "AND SectionID=$SectionID ";
    }
    //echo "SELECT * FROM vacancy $filter ORDER BY DateTime DESC";
    return _DBFetchQuery("
		SELECT 
			vacancy.ID As ID,
			users.login As Author,
			users.ID As AuthorID,
			vacancy.Title As Title,
			vacancy.Salary As Salary,
			vacancy.DateTime As DateTime
		FROM vacancy,users 
		WHERE vacancy.UserID=users.ID 
		$filter 
		ORDER BY DateTime DESC");
}
//---------------------------------------------
function DBAddCV($userid, $title, $sectionid, $content)
{
    _DBQuery("INSERT INTO cv(UserID,Title,SectionID,Content,DateTime) 
	 VALUES('$userid','$title','$sectionid','$content','".date("Y-m-d H:i:s")."')");
}

function DBUpdateCV($id, $title, $sectionid, $content)
{
    _DBQuery("UPDATE cv 
			SET Title='$title',
			SectionID='$sectionid',Content='$content' WHERE id=$id");
}

function DBDeleteCV($ID)
{
    _DBQuery("DELETE FROM cv WHERE ID=$ID");
}

function DBGetCV($ID)
{
    return _DBGetQuery("SELECT * FROM cv WHERE ID=$ID");
}

function DBFetchCV($UserID = -1, $SectionID = -1)
{
    if ($UserID == -1) {
        $filter = "";
    } else {
        $filter = "AND UserID=$UserID";
    }

    if ($SectionID == -1) {
        $filter = "";
    } else {
        $filter .= "AND SectionID=$SectionID ";
    }
    return _DBFetchQuery("
		SELECT 
			cv.ID As ID,
			users.login As Author,
			users.ID As AuthorID,
			cv.Title As Title,			
			cv.DateTime As DateTime
		FROM cv,users 
		WHERE cv.UserID=Users.ID $filter
		ORDER BY DateTime DESC");
}
//---------------------------------------------
function DBAddAdvertise($userid, $title, $content)
{
    _DBQuery("INSERT INTO advertise(UserID,Title,Content,DateTime) 
	 VALUES('$userid','$title','$content','".date("Y-m-d H:i:s")."')");
}

function DBUpdateAdvertise($id, $title, $content)
{
    _DBQuery("UPDATE advertise 
			SET Title='$title',Content='$content' WHERE id=$id");
}

function DBDeleteAdvertise($ID)
{
    _DBQuery("DELETE FROM advertise WHERE ID=$ID");
}

function DBGetAdvertise($ID)
{
    return _DBFetchQuery("SELECT * FROM advertise WHERE ID=$ID");
}

function DBFetchAdvertise($UserID = -1)
{
    if ($UserID == -1) {
        $filter = "";
    } else {
        $filter = "AND UserID=$UserID";
    }
    return _DBFetchQuery("
		SELECT 
			advertise.ID As ID,
			users.login As Author,
			users.ID As AuthorID,
			advertise.Title As Title,			
			advertise.DateTime As DateTime,
			advertise.Content As Content
		FROM advertise,users 
		WHERE advertise.UserID=Users.ID $filter
		ORDER BY DateTime DESC");
}
//---------------------------------------------
function DBToggleUser($ID)
{
    _DBQuery("UPDATE users SET State=IF(State=0,1,0) WHERE ID=$ID");
}

function DBDeleteUser($ID)
{
    _DBQuery("DELETE users WHERE ID=$ID");
}

function DBFetchUser()
{
    return _DBFetchQuery("
		SELECT 
			users.ID As ID,
			users.Login As Login,
			users.UserName As UserName,
			user_roles.Name As RoleName,
			users.State As State
		FROM users,user_roles
		WHERE users.RoleID=user_roles.ID
		GROUP BY users.RoleID
	");
}

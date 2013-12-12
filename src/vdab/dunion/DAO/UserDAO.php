<?php

/**
 * Version 1.05
 * changelog:
 * 1.06 Change functionname and parameters for login
 * 1.05 Bugfix create and getUsernameOrEmail KS
 * 1.04 Parameter check/validation Exceptions KS
 * 1.03 delete, getByUsernameOrEmail, checkPassword, getLastUpdated, logout, login KS
 * 1.02 fix createUser KS
 * 1.01 update database name KS
 * 1.00 created KS
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\User;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\DAO\LocationDAO;

class UserDAO extends AbstractDAO {

    /**
     * 
     * @return all Array of all users(entity user)
     * @throws DataSourceException
     */
    public static function getAll() {
        try {
            $userlist = array();
            $sql = "select id, username,  email, pasword, score, location_id, logged_in, last_updated from dunion_user";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->execute();
            $resultset = $pstmt->fetchAll();
            if ($resultset != false) {
                foreach ($resultset as $r) {
                    $location = LocationDAO::getById($r["location_id"]);
                    $userlist[] = User::create(intval($r["id"]), $r["username"], $r["pasword"], $r["email"], $r["score"], $location, $r["logged_in"], $r["last_updated"]);
                }
                return $userlist;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * Creates new user and returns Entity of user
     * @param type $username
     * @param type $password
     * @param type $email
     * @return User of boolean false
     * @throws DataSourceException
     */
    public static function createUser($username, $password, $email) {
        try {
            if (empty($username) || empty($password) || empty($email)) {
                throw new DataSourceException;
            }
            $score = 0;
            $location_start = 1;
            $logged_in = 1;
            $sql = "insert into dunion_user(username, pasword, email, score, location_id, logged_in) values(:username, :pasword, :email, :score, :location, :logged_in)";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":username", $username);
            $pstmt->bindParam(":pasword", $password);
            $pstmt->bindParam(":email", $email);
            $pstmt->bindParam(":score", $score);
            $pstmt->bindParam(":location", $location_start);
            $pstmt->bindParam(":logged_in", $logged_in);
            $pstmt->execute();
            $last_updated = date('Y-m-d H:i:s');
            $lastid = $dbh->lastInsertId();
            if ($lastid != null) {
                $location = LocationDAO::getById($location_start);

                return User::create($lastid, $username, $password, $email, $score, $location, $logged_in, $last_updated);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * 
     * @param type $id
     * @return entity User
     * @throws DataSourceException
     */
    public static function getById($id) {
        $id = intval($id);
        try {
            if (!is_int($id) || empty($id)) {
                throw new DataSourceException;
            }
            $sql = "select id, username,email, pasword, score, location_id, logged_in, last_updated from dunion_user where id=:id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $id);
            $pstmt->execute();
            $r = $pstmt->fetch();
            if ($r != false) {
                $location_id = $r["location_id"];
                $location = LocationDAO::getById($location_id);

                $user = User::create(intval($r["id"]), $r["username"], $r["pasword"], $r["email"], $r["score"], $location, $r["logged_in"], $r["last_updated"]);
                return $user;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * 
     * @param type $username
     * @return entity User
     * @throws DataSourceException
     */
    public static function getByUsername($username) {
        try {
            if (empty($username)) {
                throw new DataSourceException;
            }

            $sql = "select id, username,email, pasword,  score, location_id, logged_in, last_updated from dunion_user where username=:username";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":username", $username);
            $pstmt->execute();
            $r = $pstmt->fetch();
            if ($r != false) {
                $location_id = $r["location_id"];
                $location = LocationDAO::getById($location_id);

                return User::create(intval($r["id"]), $r["username"], $r["pasword"], $r["email"], $r["score"], $location, $r["logged_in"], $r["last_updated"]);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * 
     * @param type $location
     * @return Array of all users(entity user) that are on specific location
     * @throws DataSourceException
     */
    public static function getByLocationId($locationid) {
        try {
            // var_dump($location);
            if (empty($locationid) || !is_int($locationid)) {
                throw new DataSourceException;
            }
            $sql = "select id, username, email, pasword,  score, location_id, logged_in, last_updated from dunion_user where location_id = :location ";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":location", $locationid);
            $pstmt->execute();
            $resultset = $pstmt->fetchAll();
            // var_dump($resultset);
            //  exit(0);

            if ($resultset != false) {
                $location = LocationDAO::getById($locationid);
                
                foreach ($resultset as $r) {
                    $userlist[] = User::create(intval($r["id"]), $r["username"], $r["pasword"], $r["email"], $r["score"], $location, $r["logged_in"], $r["last_updated"]);
                }

                return $userlist;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * Set logged_in status to 0 when timestamp is greater than 5 seconds from now
     */
    public static function setAutoLogout() {
        try {
            $sql = "select id, username, email, pasword,  score, location_id, logged_in, last_updated from dunion_user where last_updated > unix_timestamp() + 60";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->execute();
            $results = $pstmt->fetchAll();
            if ($results != false) {
                foreach ($results as $r) {
                    $userlist[] = User::create(intval($r["id"]), $r["username"], $r["pasword"], $r["email"], $r["score"], $r["location_id"], $r["logged_in"], $r["last_updated"]);
                }
                foreach ($userlist as $r) {

                    $sql2 = "update dunion_user set logged_in = 0 where id= :id";
                    $pstmt2 = $dbh->prepare($sql2);
                    $idee = $r->getId();
                    $pstmt2->bindParam(":id", $idee);
                    $pstmt2->execute();
                }
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * NOG AFMAKEN
     * @param type $username
     * @throws DataSourceException
     */
    public static function deleteUser($loginname) {
        try {
            if (empty($loginname)) {
                throw new DataSourceException;
            }
            $sql = "delete from dunion_user where username= :loginname OR email = :loginname";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":loginname", $loginname);
            $pstmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * 
     * @param type $loginname
     * @param type $password
     * @return Entity User if true else false
     * @throws DataSourceException
     */
    public static function getByEmailOrUsername($loginname) {
        try {
            if (empty($loginname)) {
                throw new DataSourceException;
            }
            $sql = "select id, username, email, pasword, score, location_id, logged_in, last_updated from dunion_user where email=:loginname or username=:loginname";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":loginname", $loginname);
            //$pstmt->bindParam(":loginnametwee", $loginname);
            $pstmt->execute();
            $r = $pstmt->fetch();
            //var_dump($pstmt);
            //exit(0);
            if ($r != false) {

                $location = LocationDAO::getById($r["location_id"]);
                return User::create($r["id"], $r["username"], $r["pasword"], $r["email"], $r["score"], $location, $r["logged_in"], $r["last_updated"]);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    public static function updateUserLoggedIn($id) {
        try {
            if (!is_int($id) || empty($id)) {
                throw new DataSourceException;
            }
            $sql = "update dunion_user set logged_in = 1 where id = :id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $id);
            $pstmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    /*
     * @param type $id
     * @return boolean
     * @throws DataSourceException
     */

    public static function updateUserLoggedOut($id) {
        try {
            if (empty($id) || !is_int($id)) {
                throw new DataSourceException;
            }
            $sql = "update dunion_user  set logged_in = 0 where id=:id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $id);
            $pstmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    public static function updateUserLocation($user) {
        try {
            if (empty($user)) {
                throw new DataSourceException;
            }
            $userid = $user->getId();
            $location_id = $user->getLocation()->getId();


            $sql = "update dunion_user set location_id = :locid where id = :userid";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":locid", $location_id);
            $pstmt->bindParam("userid", $userid);
            $pstmt->execute();

            return self::getById($userid);
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

}
<?php

/**

 * 1.00 created MV
 */

namespace vdab\dunion\DAO;

use PDOException;
use vdab\dunion\DAO\UserDAO;
use vdab\dunion\Entity\Message;
use vdab\dunion\Exception\DataSourceException;

class MessageDAO extends AbstractDAO {

    /**
     * Creates new msg and return msg
     * @param type $text
     * @param type $user
     * @throws DataSourceException
     */
    public static function createMessage($text, $user) {
        try {
            if (empty($text) || empty($user)) {
                throw new DataSourceException;
            }
            $location_id = $user->getLocation()->getId();
            $user_id = $user->getId();
            $datetime = date("Y-m-d H:i:s");
            $sql = "insert into dunion_messages(text, location_id, user_id, datetime) values(:text, :location_id, :user_id, :datetime)";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":text", $text);
            $pstmt->bindParam(":location_id", $location_id);
            $pstmt->bindParam(":user_id", $user_id);
            $pstmt->bindParam(":datetime", $datetime);
            $pstmt->execute();

            $lastid = $dbh->lastInsertId();
            if ($lastid != null) {
                // $location = LocationDAO::getById($location_id);
                $location = $user->getLocation();
                 $dbh = null;
                return Message::create($lastid, $text, $user, $location, $datetime);
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new DataSourceException();
        }
    }

    /**
     * @param type $location
     * @throws DataSourceException
     */
    public static function getByLocation($location) {
        try {
            if (empty($location)) {
                throw new DataSourceException;
            }
            $msglist = array();
            $location_id = $location->getId();
            $sql = "select id, text, user_id, location_id, datetime from dunion_messages where location_id = :location_id order by datetime ASC limit 20";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":location_id", $location_id);
            $pstmt->execute();
            $resultset = $pstmt->fetchAll();
            if ($resultset != FALSE) {
            foreach ($resultset as $rij){
                $user = UserDAO::getById($rij["user_id"]);
                $msg = Message::create($rij["id"], $rij["text"], $user, $location, $rij["datetime"]);
                array_push($msglist, $msg);
            }
                $dbh = null;
                return $msglist;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new DataSourceException();
        }
    }

}
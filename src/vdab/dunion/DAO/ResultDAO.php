<?php

/**
  TDB
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\Result;
use vdab\dunion\Exception\DataSourceException;

class ResultDAO extends AbstractDAO {

    /**
     * @param type $event
     * @throws DataSourceException
     */
    public static function getByEvent($event) {
        try {
            if (empty($event)) {
                throw new DataSourceException;
            }
            $resultlist = array();
            $eventid = $event->getId();
            $sql = "select id, description, event_id, outcome from dunion_results where event_id = :event_id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":event_id", $eventid);
            $pstmt->execute();
            $resultset = $pstmt->fetchAll();
            if ($resultset != FALSE) {
                foreach ($resultset as $rij) {
                    $result = Result::create($rij["id"], $rij["description"], $event, $rij["outcome"]);
                    array_push($resultlist, $result);
                }
                $dbh = null;
                return $resultlist;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new DataSourceException();
        }
    }

}
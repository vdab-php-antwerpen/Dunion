<?php

/**
  TDB
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\Event;
use vdab\dunion\Exception\DataSourceException;

class EventDAO extends AbstractDAO {

    /**
     * @param type $location
     * @throws DataSourceException
     */
    public static function getByLocation($location) {
        try {
            if (empty($location)) {
                throw new DataSourceException;
            }
            $eventlist = array();
            $location_id = $location->getId();
            $sql = "select id, description, location_id from dunion_events where location_id = :location_id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":location_id", $location_id);
            $pstmt->execute();
            $r = $pstmt->fetch();
            if ($r != false) {
                $event = Event::create($r["id"], $r["description"], $location);
                $dbh = null;
                return $event;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            throw new DataSourceException();
        }
    }


}
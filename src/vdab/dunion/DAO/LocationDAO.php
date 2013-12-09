<?php

/**
 * TDB
 * Version 1.00
 * 1.00 created 
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\Location;
use vdab\dunion\DAO\RouteDAO;
use vdab\dunion\Exception\DataSourceException;

class LocationDAO extends AbstractDAO {
// getAll tested ovdb
    public static function getAll() {
        try {
            $locationlist = array();
            $sql = "select id, name, description, start, end, level from dunion_location";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->execute();
            $resultset = $pstmt->fetchAll();
            if ($resultset != false) {
                foreach ($resultset as $r) {
                    $routes = array();
                    $locationlist[] = Location::create(intval($r["id"]), $r["name"], $routes, $r["description"], $r["start"], $r["end"], $r["level"]);
                }
                return $locationlist;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }
// getById tested ovdb
    public static function getById($id) {
        try {
            if (empty($id)) {
                throw new DataSourceException();
            }
            $id = intval($id);
            if (!is_int($id)) {
                throw new DataSourceException();
            }
            $sql = "select id, name, description, start, end, level from dunion_location where id=:id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $id);
            $pstmt->execute();
            $r = $pstmt->fetch();
            if ($r != false) {
                $routes = RouteDAO::getByCurrent($id);
                return Location::create(intval($r["id"]), $r["name"], $routes, $r["description"], $r["start"], $r["end"], $r["level"]);
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    public static function create($name, $description, $start, $end, $level) {
        try {
            if (empty($name) || empty($start) || empty($end) || empty($level)) {
                throw new DataSourceException();
            }
            $start = intval($start);
            $end = intval($end);
            $level = intval($level);
            if (!is_int($start) || !is_int($end) || !is_int($level)) {
                throw new DataSourceException();
            }
            $sql = "insert into dunion_location (name, description, start, end,level) values (:name, :description, :start, :end, :level)";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":name", $name);
            $pstmt->bindParam(":description", $description);
            $pstmt->bindParam(":start", $start);
            $pstmt->bindParam(":end", $end);
            $pstmt->bindParam(":level", $level);
            $pstmt->execute();
            $id = $dbh->lastInsertId();
            $routes = array();
            return Location::create(intval($id), $name, $routes, $description, $start, $end, $level);
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    public static function delete($id) {
        try {
            if (empty($id)) {
                throw new DataSourceException();
            }
            $id = intval($id);
            if (!is_int($id)) {
                throw new DataSourceException();
            }
            $sql = "delete from dunion_location where id=:id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $id);
            $pstmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

    public static function update($id, $name, $description, $start, $end, $level) {
        try {
            if (empty($id) || empty($name) || empty($start) || empty($end) || empty($level)) {
                throw new DataSourceException();
            }
            $id = intval($id);
            $start = intval($start);
            $end = intval($end);
            $level = intval($level);
            if (!is_int($start) || !is_int($end) || !is_int($level) || !is_int($id)) {
                throw new DataSourceException();
            }
            $sql = "update dunion_location set name=:name, description=:description, start=:start, end=:end, level=:level where id=:id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $id);
            $pstmt->bindParam(":name", $name);
            $pstmt->bindParam(":description", $description);
            $pstmt->bindParam(":start", $start);
            $pstmt->bindParam(":end", $end);
            $pstmt->bindParam(":level", $level);
            $pstmt->execute();
            return true;
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

}
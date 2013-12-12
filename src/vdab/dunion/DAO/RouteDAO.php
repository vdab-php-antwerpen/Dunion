<?php

/**
 * MV
 * Version 1.03
 * 1.03 added getByCurrent
 * OVDB
 * Version 1.02
 * 1.02 added validation
 * TDB
 * Version 1.01
 * 1.01 update delete create toegevoegd 
 * 1.00 created 
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\Route;
use vdab\dunion\Exception\DataSourceException;

class RouteDAO extends AbstractDAO {
// getAll tested ovdb
//    public static function getAll() {
//        try {
//            $routelist = array();
//            $sql = "select id, current, target from dunion_route";
//            $dbh = parent::getConnection();
//            $pstmt = $dbh->prepare($sql);
//            $pstmt->execute();
//            $resultset = $pstmt->fetchAll();
//            if ($resultset != false) {
//                foreach ($resultset as $r) {
//                    $routelist[] = Route::create(intval($r["id"]), $r["current"], $r["target"]);
//                }
//                return $routelist;
//            } else {
//                return false;
//            }
//        } catch (\PDOException $e) {
//            throw new DataSourceException();
//        }
//    }
// getById tested ovdb
//    public static function getById($id) {
//        try {
//            if (empty($id)) {
//                throw new DataSourceException();
//            }
//            $id = intval($id);
//            if (!is_int($id)) {
//                throw new DataSourceException();
//            }
//            $sql = "select id, current, target from dunion_route where id=:id";
//            $dbh = parent::getConnection();
//            $pstmt = $dbh->prepare($sql);
//            $pstmt->bindParam(":id", $id);
//            $pstmt->execute();
//            $r = $pstmt->fetch();
//            if ($r != false) {
//                return Route::create(intval($r["id"]), $r["current"], $r["target"]);
//            } else {
//                return false;
//            }
//        } catch (\PDOException $e) {
//            throw new DataSourceException();
//        }
//    }
//
/////////////////////////////////////////create een nieuwe route 
//    public static function create($current, $target) {
//        try {
//            if (empty($current) || empty($target)) {
//                throw new DataSourceException();
//            }
//            $current = intval($current);
//            $target = intval($target);
//            if (!is_int($current) || !isint($target)) {
//                throw new DataSourceException();
//            }
//            $sql = "insert into dunion_route (current, target) values (:current, :target)";
//            $dbh = parent::getConnection();
//            $pstmt = $dbh->prepare($sql);
//            $pstmt->bindParam(":current", $current);
//            $pstmt->bindParam(":target", $target);
//            $pstmt->execute();
//            $id = $dbh->lastInsertId();
//            return Route::create(intval($id), $current, $target);
//        } catch (\PDOException $e) {
//            throw new DataSourceException();
//        }
//    }
//
///////////////////////////////delete op id (return true als gelukt is)
//    public static function delete($id) {
//        try {
//            if (empty($id)) {
//                throw new DataSourceException();
//            }
//            $id = intval($id);
//            if (!is_int($id)) {
//                throw new DataSourceException();
//            }
//            $sql = "delete from dunion_route where id=:id";
//            $dbh = parent::getConnection();
//            $pstmt = $dbh->prepare($sql);
//            $pstmt->bindParam(":id", $id);
//            $pstmt->execute();
//            return true;
//        } catch (\PDOException $e) {
//            throw new DataSourceException();
//        }
//    }
//
//    /////////////////// update met id (eerste parameter is id van diegene die je wil update)(volgende paramaters zijn welke waarden je wil update)
//    public static function update($id, $current, $target) {
//        try {
//            if (empty($id) || empty($current) || empty($target)) {
//                throw new DataSourceException();
//            }
//            $id = intval($id);
//            $current = intval($current);
//            $target = intval($target);
//            if (!is_int($id) || !is_int($current) || !is_int($target)) {
//                throw new DataSourceException();
//            }
//            $sql = "update dunion_route set current=:current, target=:target where id=:id";
//            $dbh = parent::getConnection();
//            $pstmt = $dbh->prepare($sql);
//            $pstmt->bindParam(":id", $id);
//            $pstmt->bindParam(":current", $current);
//            $pstmt->bindParam(":target", $target);
//            $pstmt->execute();
//            return Route::create(intval($id), $current, $target);
//        } catch (\PDOException $e) {
//            throw new DataSourceException();
//        }
//    }
// getByCurrent tested ovdb
    public static function getByCurrent($current) {
        try {
            $currentid = $current->getId();
            $routelist = array();
            $sql = "select id, current, target from dunion_route where current=:current";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":current", $currentid);
            $pstmt->execute();
            $resultset = $pstmt->fetchAll();
            if ($resultset != false) {
                foreach ($resultset as $r) {
                    $target = LocationDAO::getById($r["target"]);
                    $routelist[] = Route::create(intval($r["id"]), $current, $target);
                }
                return $routelist;
            } else {
                return false;
            }
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

}
<?php
namespace vdab\dunion\DAO;

use vdab\dunion\DAO\DBConfig;

abstract class AbstractDAO {

    private static $dbh;

    protected static function getConnection() {
        if (!isset(self::$dbh)) {
            self::$dbh = new \PDO(DBConfig::$connstring, DBConfig::$dbuser, DBConfig::$dbpwd);
        }
        if (self::$dbh == false) {throw new DataConnectionFailedException();}
        else {return self::$dbh;}
        
    }

}

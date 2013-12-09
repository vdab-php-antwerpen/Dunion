<?php

/**
 * TDB
 * Version 1.01
 * 1.01 stdClass toegevoegd
 * 1.00 created 
 */

namespace vdab\dunion\Entity;

class Route {

    private static $idMap = array();
    private $id;
    private $current;
    private $target;

    private function __construct($id, $current, $target) {
        $this->id = $id;
        $this->current = $current;
        $this->target = $target;
    }

    public static function create($id, $current, $target) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Route($id, $current, $target);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getCurrent() {
        return $this->current;
    }

    public function setCurrent($current) {
        $this->current = $current;
    }

    public function getTarget() {
        return $this->target;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->current = $this->getCurrent();
        $output->target = $this->getTarget();

        return $output;
    }

}


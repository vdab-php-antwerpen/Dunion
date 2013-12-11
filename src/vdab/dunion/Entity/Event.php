<?php

namespace vdab\dunion\Entity;

class Event {

    private static $idMap = array();
    private $id;
    private $description;
    private $location;

    private function __construct($id, $description, $location) {
        $this->id = $id;
        $this->description = $description;
        $this->location = $location;
    }

    public static function create($id, $description, $location) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Event($id, $description, $location);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->description = $this->getDescription();
        $output->location = $this->getLocation()->toStdClass();

        return $output;
    }

}


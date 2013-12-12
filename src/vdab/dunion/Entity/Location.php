<?php

namespace vdab\dunion\Entity;

class Location {

    private static $idMap = array();
    private $id;
    private $name;
    private $description;
    private $start;
    private $end;
    private $level;

    private function __construct($id, $name, $description, $start, $end, $level) {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->start = $start;
        $this->end = $end;
        $this->level = $level;
    }

    public static function create($id, $name, $description, $start, $end, $level) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Location($id, $name, $description, $start, $end, $level);
        }
        return self::$idMap[$id];  
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }


    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getStart() {
        return $this->start;
    }

    public function setStart($start) {
        $this->start = $start;
    }

    public function getEnd() {
        return $this->end;
    }

    public function setEnd($end) {
        $this->end = $end;
    }

    public function getLevel() {
        return $this->level;
    }

    public function setLevel($level) {
        $this->level = $level;
    }
    
    public function toStdClass() {
    	$output = new \stdClass;
    	$output->id = $this->getId();
    	$output->name = $this->getName();   	
 	$output->description = $this->getDescription();
    	$output->start = $this->getStart();
    	$output->end = $this->getEnd();
    	$output->level = $this->getLevel();
    
    	return $output;
    }
    
}



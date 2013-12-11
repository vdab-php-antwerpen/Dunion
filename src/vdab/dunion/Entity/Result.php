<?php

namespace vdab\dunion\Entity;

class Result {

    private static $idMap = array();
    private $id;
    private $description;
    private $event;
    private $outcome;

    private function __construct($id, $description, $event, $outcome) {
        $this->id = $id;
        $this->description = $description;
        $this->event = $event;
        $this->outcome = $outcome;
    }

    public static function create($id, $description, $event, $outcome) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Result($$id, $description, $event, $outcome);
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

    public function getEvent() {
        return $this->event;
    }

    public function setEvent($event) {
        $this->event = $event;
    }

    public function getOutcome() {
        return $this->outcome;
    }

    public function setOutcome($outcome) {
        $this->outcome = $outcome;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->description = $this->getDescription();
        $output->event = $this->getEvent()->toStdClass();
        $output->outcome = $this->getOutcome();

        return $output;
    }

}


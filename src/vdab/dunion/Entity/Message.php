<?php

namespace vdab\dunion\Entity;

class Message {

    private static $idMap = array();
    private $id;
    private $text;
    private $user;
    private $location;
    private $datetime;

    private function __construct($id, $text, $user, $location, $datetime) {

        $this->id = $id;
        $this->text = $text;
        $this->user = $user;
        $this->location = $location;
        $this->datetime = $datetime;
    }

    public static function create($id, $text, $user, $location, $datetime) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Message ($id, $text, $user, $location, $datetime);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getText() {
        return $this->text;
    }

    public function getUser() {
        return $this->user;
    }

    public function getLocation() {
        return $this->location;
    }

    public function getDatetime() {
        return $this->datetime;
    }

    public function setText($text) {
        $this->text = $text;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    public function setDatetime($datetime) {
        $this->datetime = $datetime;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->text = $this->getText();
        $output->user = $this->getUser()->toStdClass();
        $output->location = $this->getLocation()->toStdClass();
        $output->datetime = $this->getDatetime();

        return $output;
    }

}


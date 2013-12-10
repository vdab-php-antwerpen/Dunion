<?php

namespace vdab\dunion\Entity;

class User {

    private static $idMap = array();
    private $id;
    private $username;
    private $pasword;
    private $email;
    private $score;
    private $location;
    private $logged_in;
    private $last_updated;

    private function __construct($id, $username, $pasword, $email, $score, $location, $logged_in, $last_updated) {
        $this->id = $id;
        $this->username = $username;
        $this->pasword = $pasword;
        $this->email = $email;
        $this->score = $score;
        $this->location = $location;
        $this->logged_in = $logged_in;
        $this->last_updated = $last_updated;
    }

    public static function create ($id, $username, $pasword, $email, $score, $location, $logged_in, $last_updated) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new User($id, $username, $pasword, $email, $score, $location, $logged_in, $last_updated);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPasword() {
        return $this->pasword;
    }

    public function setPasword($pasword) {
        $this->pasword = $pasword;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getScore() {
        return $this->score;
    }

    public function setScore($score) {
        $this->score = $score;
    }
    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }
    public function getLogged_in() {
        return $this->logged_in;
    }

    public function setLogged_in($logged_in) {
        $this->logged_in = $logged_in;
    }
    public function getLast_updated() {
        return $this->last_updated;
    }

    public function setLast_updated($last_updated) {
        $this->last_updated = $last_updated;
    }

    public function toStdClass() {
        $output = new \stdClass;
        $output->id = $this->getId();
        $output->username = $this->getUsername();
        //$output->pasword = $this->getPasword();
        $output->email = $this->getEmail();
        $output->score = $this->getScore();
        $output->location = $this->getLocation()->toStdClass();
        $output->logged_in = $this->getLogged_in();
        $output->last_updated = $this->getLast_updated();

        return $output;
    }

}
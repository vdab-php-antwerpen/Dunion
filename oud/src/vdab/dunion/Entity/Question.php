<?php

/**
 * changelog
 * 1.01 added function toStdClass() KS
 * 1.00 created T
 */
namespace vdab\dunion\Entity;

class Question {

    private static $idMap = array();
    private $id;
    private $question;
    private $answers;
    private $points;

    private function __construct($id, $question, $answers, $points) {
        $this->id = $id;
        $this->question = $question;
        $this->answers = $answers;
        $this->points = $points;
    }

    public static function create($id, $question, $answers, $points) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Question($id, $question, $answers, $points);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }
    
    public function getAnswers() {
        return $this->answers;
    }

    public function setAnswers($answers) {
        $this->answers = $answers;
    }

    
    public function getPoints() {
        return $this->points;
    }

    public function setPoints($points) {
        $this->points = $points;
    }
    
    public function toStdClass(){
        $output = new \stdClass();
        $output->id = $this->getId();
        $output->question = $this->getQuestion();
        $output->answers = $this->getAnswers();
        $output->points = $this->getPoints();
        
        return $output;
    }

}


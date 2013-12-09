<?php

/**
 * Changelog:
 * 1.01 added function toStdClass() KS
 * 1.00 created T
 */
namespace vdab\dunion\Entity;

class Answer {

    private static $idMap = array();
    private $id;
    private $answer;
    private $question_id;
    private $correct;

    private function __construct($id, $answer, $question_id, $correct) {
        $this->id = $id;
        $this->answer = $answer;
        $this->question_id = $question_id;
        $this->correct = $correct;
    }

    public static function create($id, $answer, $question_id, $correct) {
        if (!isset(self::$idMap[$id])) {
            self::$idMap[$id] = new Answer($id, $answer, $question_id, $correct);
        }
        return self::$idMap[$id];
    }

    public function getId() {
        return $this->id;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function setAnswer($answer) {
        $this->answer = $answer;
    }

    public function getQuestion_id() {
        return $this->question_id;
    }

    public function setQuestion_id($question_id) {
        $this->question_id = $question_id;
    }

    public function getCorrect() {
        return $this->correct;
    }

    public function setCorrect($correct) {
        $this->correct = $correct;
    }
    
    public function toStdClass(){
        $output = new \stdClass();
        $output->id = $this->getId();
        $output->answer = $this->getAnswer();
        $output->question_id = $this->getQuestion_id();
        $output->correct = $this->getCorrect();
        
        return $output;
    }

}


<?php

/**
 * Changelog:
 * 1.00 created KS
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\Answer;
use vdab\dunion\Exception\DataSourceException;

class AnwserDAO extends AbstractDAO {

    public static function getAnwsersByQuestion($questionid) {
$questionid = intval($questionid);
        try {
            if (!is_int($questionid) || empty($questionid)) {
                throw new DataSourceException;
            }
            $answerlist = array();
            $sql = "select id, question_id, answer, correct from dunion_answers where question_id = :id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $questionid);
            $pstmt->execute();
            $answers = $pstmt->fetchAll();
            if ($answers != false) {
                foreach ($answers as $answer) {
                    $answer = Answer::create($answer["id"], $answer["answer"], $answer["question_id"], $answer["correct"]);
                    $answerlist[] = $answer->toStdClass();
                }
                return $answerlist;
            } else {
                return false;
            }
        } catch (\PDOException $se) {
            throw new DataSourceException();
        }
    }

}

?>

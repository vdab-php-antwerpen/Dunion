<?php

/**
 * Changelog:
 * 1.00 created KS
 */

namespace vdab\dunion\DAO;

use vdab\dunion\Entity\Question;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\DAO\AnwserDAO;

class QuestionDAO extends AbstractDAO {

    public static function getQuestionByLocation($locationId) {
        $locationId = intval($locationId);
        try {
            if (!is_int($locationId) || empty($locationId)) {
                throw new DataSourceException;
            }
            $sql = "select id, question, points from dunion_questions where id= :id";
            $dbh = parent::getConnection();
            $pstmt = $dbh->prepare($sql);
            $pstmt->bindParam(":id", $locationId);
            $pstmt->execute();
            $question = $pstmt->fetch();
            $answer = AnwserDAO::getAnwsersByQuestion($question["id"]);
            return Question::create($question["id"], $question["question"], $answer, $question["points"]);
        } catch (\PDOException $e) {
            throw new DataSourceException();
        }
    }

}

?>

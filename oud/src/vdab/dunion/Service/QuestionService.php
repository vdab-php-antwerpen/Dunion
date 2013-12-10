<?php

/**
 * changelog:
 * 1.01 created KS
 */

namespace vdab\dunion\Service;

use vdab\dunion\DAO\QuestionDAO;
use vdab\dunion\Exception\ServiceException;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\DTO\SimpleObjectResponse;

class QuestionService {
    
    
    public static function getById($id){
        try{
            $oResponse = new SimpleObjectResponse();
            if(empty($id) || is_null($id)){
                $oResponse->addException("IS_EMPTY_LOCATION");
                throw new ServiceException();
            }
            $question = QuestionDAO::getQuestionByLocation($id);
            
            if($question == false){
                $oResponse->addException("QUESTION_DOES_NOT_EXIST");
                throw new ServiceException();
            }
            $output = $question->toStdClass();
            $oResponse->addProperty('question', $output);
    }
    catch( ServiceException $se){
        
    }
    catch(DataSourceException $dse){
        $oResponse->reset();
        $oResponse->addException($dse->getMessage());
    }
    return $oResponse->getJSONOutput();
    }
    
}

?>

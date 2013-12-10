<?php

/**
 * 1.00 created MV
 */

namespace vdab\dunion\Service;

use stdClass;
use vdab\dunion\DAO\MessageDAO;
use vdab\dunion\DTO\SimpleObjectResponse;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\Exception\ServiceException;

class MessageService {

    public static function getMessagesByLocation($location) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($location) || is_null($location)) {
                $oResponse->addException("ID_NOT_FOUND");
                throw new ServiceException();
            }
            $messages = MessageDAO::getByLocation($location);

//            if ($messages == false) {
//               $oResponse->addProperty('lijstmessages', "no messages");
//            }else{
            $lijstmessages = array();
            foreach ($messages as $message) {
                $msg = $message->toStdClass();

                $lijstmessages[$message->getId()] = $msg;
            }
            $oResponse->addProperty('lijstmessages', $lijstmessages);
         //   }
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

    public static function createMessage($user, $text) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($text) || is_null($user)) {
                $oResponse->addException('IS_EMPTY_USER');
                throw new ServiceException();
            }

            if (empty($text) || is_null($text)) {
                $oResponse->addException('IS_EMPTY_TEXT');
                throw new ServiceException();
            }

            $msg = MessageDAO::createMessage($text, $user);

            $stdmsg = $msg->toStdClass();
            $oResponse->addProperty("msg", $stdmsg);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }

        return $oResponse->getJSONOutput();
    }

}


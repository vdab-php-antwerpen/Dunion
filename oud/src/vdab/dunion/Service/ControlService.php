<?php

namespace vdab\dunion\Service;

use vdab\dunion\DAO\LocationDAO;
use vdab\dunion\DAO\UserDAO;
use vdab\dunion\Exception\ServiceException;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\DTO\SimpleObjectResponse;

class ControlService {

    public static function getAllData($user) {
        try {
            $oResponse = new SimpleObjectResponse();

            if (empty($user) || is_null($user)) {
                $oResponse->addException("UNDEFINED_USER");
                throw new ServiceException();
            }

            // get all users by location
            $location_id = $user->getLocation()->getId();
           
            $userlist = UserDAO::getByLocation($location_id);
         
            
            if (!empty($userlist)) {
                $users = array();
                foreach ($userlist as $userlistitem) {
                    $users[] = $userlistitem->toStdClass();
                }
            } else {
                $users = 0;
            }
            $oResponse->addProperty('users', $users);

            // get userdata
            $userid = intval($user->getId());
            $userdata = UserDAO::getById($userid);
            $userdata = $userdata->toStdClass();
            $oResponse->addProperty('userdata', $userdata);

// 			// get locationdata
// 			$location = LocationDAO::getById($location_id);
// 			$oResponse->addProperty('location', $location);
            // get questions
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
            //vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

}


<?php
/**
 * MV
 * Version 1.01
 */

namespace vdab\dunion\Service;

use vdab\dunion\DAO\LocationDAO;
use vdab\dunion\DAO\UserDAO;
use vdab\dunion\DTO\SimpleObjectResponse;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\Exception\ServiceException;

class LocationService {

    public static function changeUserLocation($userobject, $location_id) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($userobject) || is_null($userobject)) {
                $oResponse->addException('IS_EMPTY_USEROBJECT');
                throw new ServiceException();
            }

            if (empty($location_id) || is_null($location_id)) {
                $oResponse->addException('IS_EMPTY_LOCATION_ID');
                throw new ServiceException();
            }

            $location = LocationDAO::getById($location_id);
            if ($location == false) {
                $oResponse->addException('LOCATION_DOES_NOT_EXIST');
                throw new ServiceException();
            }

            $userobj = $userobject->setLocation($location);

            $user = UserDAO::updateUserLocation($userobj);

            if ($user == false) {
                $oResponse->addException('USER_DOES_NOT_EXIST');
                throw new ServiceException();
            }

            $user->toStdClass();


            $oResponse->addProperty('user', $user);
        } catch (ServiceException $se) {
            //niks doen
        } catch (DataSourceException $dse) {
            //vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

}
<?php

/**
 * MV
 * Version 1.01
 */

namespace vdab\dunion\Service;

use vdab\dunion\DAO\RouteDAO;
use vdab\dunion\Exception\ServiceException;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\DTO\SimpleObjectResponse;

class RouteService {

    public static function getRoute($current) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($current) || is_null($current)) {
                $oResponse->addException('IS_EMPTY_CURRENT');
                throw new ServiceException();
            }

            $routes = RouteDAO::getByCurrent($current);
            $lijstroutes = array();
            foreach ($routes as $route) {
                $lijstroutes[] = $route->toStdClass();
            }

            $oResponse->addProperty('lijstroutes', $lijstroutes);
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
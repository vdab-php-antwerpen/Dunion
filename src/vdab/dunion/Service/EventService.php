<?php

/**
 * 1.00 created MV
 */

namespace vdab\dunion\Service;

use vdab\dunion\DAO\EventDAO;
use vdab\dunion\DAO\ResultDAO;
use vdab\dunion\DTO\SimpleObjectResponse;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\Exception\ServiceException;

class EventService {

    public static function getEvent($location) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($location) || is_null($location)) {
                $oResponse->addException("ID_NOT_FOUND");
                throw new ServiceException();
            }
            $event = EventDAO::getByLocation($location);
           

            if ($event == false) {
                $oResponse->addException("NO_EVENT");
                throw new ServiceException();
            }
            $results = ResultDAO::getByEvent($event);

            if ($results == false) {
                $oResponse->addException("NO_RESULT");
                throw new ServiceException();
            }
            $lijstresults = array();
            $eventStd = new \stdClass();
            $eventStd->event = $event->toStdClass();

            foreach ($results as $result) {
                $lijstresults[] = $result->toStdClass();
            }
            
            $eventStd->results = $lijstresults;
            $oResponse->addProperty('event', $eventStd);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

//

}


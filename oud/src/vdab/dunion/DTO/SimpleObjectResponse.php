<?php
/*
 * Hieronder de SimpleObjectResponse klasse en daaronder een voorbeeld van de implementatie.
 * Uitleg in vet.
 * Ge kunt het gewoon kopiëren en plakken in uwen IDE, voorbeeldklasse is gecommentariëerd zodat ge ze gewoon bij uw SimpleObjectResponse.class kunt laten staan ter referentie :)
 * zelfs de <?php-tag hierboven staat al klaar, is da volledig ofwa?
 */

/* SimpleObjectResponse.class */
/*--------------------------------------------*/


namespace vdab\dunion\DTO;

class SimpleObjectResponse {

    private $oContents;
    private $arExceptions;

    public function __construct() {
        $this->oContents = new \stdClass();
        $this->arExceptions = array();
    }

    public function addProperty($propName, $propVal) {
        $this->oContents->$propName = $propVal;
    }

    public function getProperty($propName) {
        $std = $this->getStdClassOutput();
        if (property_exists($std, $propName)) {
            return $std->propName;
        } else {
            return null;
        }
    }

    public function addException($exceptionName) {
        $this->arExceptions[] = $exceptionName;
    }

    public function hasExceptions() {
        return (count($this->arExceptions) > 0);
    }

    public function getStdClassOutput() {
        $oOutput = clone($this->oContents);
        if (count($this->arExceptions) > 0) {
            $oOutput->exceptions = $this->arExceptions;
        }
        return $oOutput;
    }

    public function getJSONOutput() {
        return json_encode($this->getStdClassOutput());
    }

    public function reset() {//reset functie heb ik zelf toegevoegd om het object makkelijk leeg te kunnen maken wanneer nodig (zie voorbeeld hieronder)
        if (isset($this->oContents)) {
            foreach ($this->oContents as $prop) {
                unset($prop);
            }
        }
        if (isset($this->arExceptions)) {
            foreach ($this->arExceptions as $prop) {
                unset($prop);
            }
        }
    }

}//end SimpleObjectResponse class

/*--------------------------------------------*/


/* Voorbeeld Implementatie */
/*--------------------------------------------*/

//
//namespace NSpace_One\NewProject\Business;
//
//require_once("preload.php");
//
//use NSpace_One\NewProject\Entities\SimpleObjectResponse;
//use NSpace_One\NewProject\Business\BestellingService;
//use NSpace_One\NewProject\Business\CursistService;
//use NSpace_One\NewProject\Exceptions\ServiceException;
//use NSpace_One\NewProject\Exceptions\DataSourceException;
//use NSpace_One\NewProject\Data\BroodjeDAO;
//use NSpace_One\NewProject\Data\BelegsoortDAO;
//
//class WinkelmandjeService {
//
//    public static function createBestelling($broodId, $arBelegIds) {
//        /*
//         * maakt een nieuwe bestelling adhv brood-id en beleg-ids
//         * en voegt deze toe aan $oResponse
//         * output in JSON
//         */
//
//        $oResponse = new SimpleObjectResponse();
//
//        try {
//
//            if (is_null($broodId) || $broodId == '') {
//                 $oResponse->addException('IS_EMPTY_BROOD_ID');
//                throw new ServiceException();//ServiceException wordt opgegooid om de rest van de functie over te slaan en vervolgens de exceptions in $oResponse te returnen
//            }
//            if (!ctype_alnum($broodId)) {
//                 $oResponse->addException('NON_ALPHANUMERIC_BROOD_ID');
//                throw new ServiceException();
//            }
//
//            foreach ($arBelegIds as $belegsoortId) {
//                if (is_null($belegsoortId) || $belegsoortId == '') {
//                     $oResponse->addException('IS_EMPTY_BELEG_ID');
//                    throw new ServiceException();
//                }
//                if (!ctype_alnum($belegsoortId)) {
//                     $oResponse->addException('NON_ALPHANUMERIC_BELEG_ID');
//                    throw new ServiceException();
//                }
//            }//end foreach
//
//            $tijd = CursistService::checkTijd();
//            if ($tijd->time == 'na_10u') {
//                $oResponse->addException('AFTER_10');
//                throw new ServiceException();
//            }
//            $oBroodje = BroodjeDAO::fnGetById($broodId);
//            $stdBroodje = $oBroodje->toStdClass();//toStdClass() is een functie in de entity van het object, staat los van SimpleObjectResponse.class
//            $stdBeleg = new \stdClass();
//            foreach ($arBelegIds as $belegsoortId) {
//                $oBelegsoort = BelegsoortDAO::fnGetById($belegsoortId);
//                $omschr = $oBelegsoort->getOmschrijving();
//                $stdBelegsoort = $oBelegsoort->toStdClass();
//                $stdBeleg->$omschr = $stdBelegsoort;
//            }
//            $oResponse->addProperty('broodje', $stdBroodje);
//            $oResponse->addProperty('beleg', $stdBeleg);
//        } catch (ServiceException $e) {//ServiceExceptions werden reeds in $oResponse gezet, daarom hoeft er nu niets gedaan te worden bij het opvangen
//            //do nothing
//        } catch (DataSourceException $e) {//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
//            $oResponse->reset();
//            $oResponse->addException($e->getMessage()); //getMessage() is een core functie
//        }
//        return $oResponse->getJSONOutput();
//    }//end function
//
//}//end class

/*--------------------------------------------*/
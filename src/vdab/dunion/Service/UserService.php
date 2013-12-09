<?php

/**
 * Version 1.00
 * changelog:
 * 1.02 changename login, register KS
 * 1.01 updateuserlocation KS
 * 1.00 created KS
 */

namespace vdab\dunion\Service;

use vdab\dunion\DAO\LocationDAO;
use vdab\dunion\DAO\UserDAO;
use vdab\dunion\DTO\SimpleObjectResponse;
use vdab\dunion\Exception\DataSourceException;
use vdab\dunion\Exception\ServiceException;

class UserService {

    public static function getAll() {
        try {
            $oResponse = new SimpleObjectResponse();
            $users = UserDAO::getAll();

            if (empty($users)) {
                $oResponse->addException("IS_EMPTY_CURRENT");
                throw new ServiceException();
            }
            $lijstusers = array();
            foreach ($users as $user) {
                $lijstusers[] = $user->toStdClass();
            }
            $oResponse->addProperty('lijstusers', $lijstusers);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

    /**
     * 
     * @param type $id
     * @return USER
     * @throws ServiceException
     */
    public static function getById($id) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($id) || is_null($id)) {
                $oResponse->addException("ID_NOT_FOUND");
                throw new ServiceException();
            }

            $user = UserDAO::getById($id);

            if ($user == false) {
                $oResponse->addException("USER_DOES_NOT_EXIST");
                throw new ServiceException();
            }

            $output = $user->toStdClass();
            $oResponse->addProperty('user', $output);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

    /**
     * 
     * @param type $username
     * @param type $password
     * @return JSON User else Exception
     * @throws ServiceException
     */
    public static function login($loginname, $password, &$user) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($loginname) || is_null($loginname)) {
                $oResponse->addException('IS_EMPTY_USERNAME');
                throw new ServiceException();
            }

            if (empty($password) || is_null($password)) {
                $oResponse->addException('IS_EMPTY_PASSWORD');
                throw new ServiceException();
            }

            $user = UserDAO::getByEmailOrUsername($loginname);

            if ($user == false) {
                $oResponse->addException('USER_DOES_NOT_EXIST');
                throw new ServiceException();
            }

            $dbpassword = $user->getPasword();
            $encrypted = self::passwordEncryption($password);
            if ($encrypted != $dbpassword) {
                $oResponse->addException('PASSWORD_INCORRECT');
                throw new ServiceException();
            }
            $id = intval($user->getId());
            UserService::updateUserLoggedIn($id);
            $output = $user->toStdClass();

            $oResponse->addProperty('user', $output);
        } catch (ServiceException $se) {
//niks doen
        } catch (DataSourceException $dse) {
//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

    /**
     * 
     * @param type $username
     * @param type $password
     * @param type $email
     * @return type
     * @throws ServiceException
     */
    public static function registerUser($username, $password, $email, &$user) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($username) || is_null($username)) {
                $oResponse->addException('IS_EMPTY_USERNAME');
                throw new ServiceException();
            }

            if (empty($password) || is_null($password)) {
                $oResponse->addException('IS_EMPTY_PASSWORD');
                throw new ServiceException();
            }

            if (empty($email) || is_null($email)) {
                $oResponse->addException('IS_EMPTY_EMAIL');
                throw new ServiceException();
            }
            if(!self::validatemail($email)){
                $oResponse->addException("NOT_VALID_EMAIL");
                throw new ServiceException();
            }


            $usernamecheck = UserDAO::getByEmailOrUsername($username);
            $emailcheck = UserDAO::getByEmailOrUsername($email);

            if ($usernamecheck != false) {
                $oResponse->addException('USERNAME_EXISTS');
                throw new ServiceException();
            }
            if ($emailcheck != false) {
                $oResponse->addException('EMAIL_EXISTS');
                throw new ServiceException();
            }
            $password = self::passwordEncryption($password);
            $user = UserDAO::createUser($username, $password, $email);

            $stduser = $user->toStdClass();
            $oResponse->addProperty("user", $stduser);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }


        return $oResponse->getJSONOutput();
    }

    /**
     * 
     * @param type $id
     * @throws ServiceException
     */
    public static function updateUserLoggedIn($id) {
        try {
            $oresponse = new SimpleObjectResponse();
            if (empty($id) || is_null($id) || !is_int($id)) {
                $oresponse->addException("IS_EMPTY_USERID");
                throw new ServiceException();
            }
            UserDAO::updateUserLoggedIn($id);
            return true;
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
            $oresponse->reset();
            $oresponse->addException($dse->getMessage());
        }
    }

    /**
     * 
     * @param type $id
     * @throws ServiceException
     */
    public static function updateUserLoggedOut($id) {
        try {
            $oresponse = new SimpleObjectResponse();
            if (empty($id) || is_null($id) || !is_int($id)) {
                $oresponse->addException("IS_EMPTY_USERID");
                throw new ServiceException();
            }
            UserDAO::updateUserLoggedOut($id);
            return true;
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
            $oresponse->reset();
            $oresponse->addException($dse->getMessage());
        }
    }

    /**
     * AUTO logout after 10 seconds of inactivity
     */
    public static function setAutoLogout() {
        try {
            UserDAO::setAutoLogout();
        } catch (ServiceException $se) {
            
        }
    }

    public static function deleteUser($loginname) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($loginname) || is_null($loginname)) {
                $oResponse->addException('IS_EMPTY_LOGINNAME');
                throw new ServiceException();
            }
            $deleted = UserDAO::deleteUser($loginname);
            $oResponse->addProperty("deleted", $deleted);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
            $oResponse->reset();
            $oResponse->addException($dse->getMessage());
        }
        return $oResponse->getJSONOutput();
    }

    public static function getByLocation($location) {
        try {
            $oResponse = new SimpleObjectResponse();
            if (empty($location) || is_null($location)) {
                $oResponse->addException("LOCATION_NOT_FOUND");
                throw new ServiceException();
            }

            $userlist = UserDAO::getByLocation($location);

            if ($userlist == false) {
                $oResponse->addException("NO_USER_ON_LOCATION");
                throw new ServiceException();
            }
            $users = array();
            foreach ($userlist as $user) {
                $users[] = $user->toStdClass();
            }

// $output = json_encode($userlist);
            $oResponse->addProperty('users', $users);
        } catch (ServiceException $se) {
            
        } catch (DataSourceException $dse) {
//vangt exceptions op uit data-laag en zet deze om in een object van SimpleObjectResponse.class
            $oResponse->reset();
            $oResponse->addException($dse->getMessage()); //getMessage() is een core functie
        }
        return $oResponse->getJSONOutput();
    }

    public static function updateUserLocation($user, $location_id) {
        try {
            if (empty($user) || is_null($user)) {
                throw new ServiceException();
            }
            if (empty($location_id) || is_null($location_id)) {
                throw new ServiceException();
            }



            $location = LocationDAO::getById($location_id);
            $user->setLocation($location);



            $done = UserDAO::updateUserLocation($user);
            return $done;
        } catch (ServiceException $se) {
            
        }
    }

    /**
     * Encrypts password with SHA1 and returns it
     * @param type $password
     */
    private static function passwordEncryption($password) {
        $encrypted = sha1($password);
        return $encrypted;
    }

    private static function validatemail($email) {


            if (filter_var($email, FILTER_VALIDATE_EMAIL) == $email) {
                return true;
                throw new ServiceException();
            } 
            else{
                return false;
            }
    }

}
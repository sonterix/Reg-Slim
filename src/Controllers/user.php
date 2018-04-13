<?php

namespace App\Controller;

use App\Model\DB as DB;
use App\Model\CURL as CURL;

class User {

    private $settings;

    public function __construct() {   
        // Get config data
        $config = require __DIR__ . '/../../src/settings.php';
        $this->settings = $config['settings']['db'];
    }

    public function registration($request, $response) {
        $data = [
            'login' => trim($request->getParam('login')),
            'password' => trim($request->getParam('pass'))
        ];

        $db = new DB($this->settings);
        $user = $db->getUser($data['login']);

        if($user != false) {
            return $response->withStatus(200)
                ->withJson('User already exist');
        }

        $db->regUser($data);
        return $response->withStatus(200)
            ->withJson('User successfully registered');       

    }


    public function login($request, $response) {
        $data = [
            'login' => trim($request->getParam('login')),
            'password' => trim($request->getParam('pass'))
        ];

        $db = new DB($this->settings);
        $user = $db->getUser($data['login']);

        if($user == false) {
            return $response->withStatus(404)
                ->withJson('User not found');
        }

        $userAccess = $db->userLogin($data);

        if($userAccess == false) {
            return $response->withStatus(404)
                ->withJson('Incorrect data');
        } else {
            $_SESSION['authorized'] = $user['id'];
            return $response->withStatus(200)
                ->withJson('User loged in');
        }
    }

    public function logout($request, $response) {
        $_SESSION = [];
        return $response->withRedirect('');   
    }

    public function addBalans($request, $response) {
        $data = [
            'id' => trim($request->getParam('user_id_author')),
            'user_id' => trim($request->getParam('user_id')),
            'balans' => trim($request->getParam('balans')),
        ];

        $db = new DB($this->settings);
        $balansAdd = $db->addBalance($data);
        $balansTakeOff = $db->takeOffBalans($data);

        if($balansAdd != 1 && $balansTakeOff != 1) { 
            return $response->withStatus(400)
                ->withJson('Error');
        } else {
            return $response->withStatus(200)
                ->withJson('Balans successfully updated');     
        }
    }

    public function takeOffBalans($request, $response) {
        $data = [
            'id' => trim($request->getParam('user_id')),
            'balans' => trim($request->getParam('balans')),
        ];

        $db = new DB($this->settings);
        $balans = $db->takeOffBalans($data);

        if($balans != 1) { 
            return $response->withStatus(400)
                ->withJson('Error');
        } else {
            return $response->withStatus(200)
                ->withJson('Balans successfully updated');     
        }
    }

    public function getBalans($request, $response, $args) {
        $user_id = $args['id'];

        $db = new DB($this->settings);
        $balans = $db->getBalans($user_id);

        return $response->withStatus(200)
            ->withJson($balans);     
    }

    public function getDistance($request, $response) {
        $data = [
            'apiKey' => 'AIzaSyAwQ9RPK8fNSMBNYmWtlbe1qrI8stfqjFw',
            'from' => str_replace(" ", "", $request->getParam('from')),
            'to' => str_replace(" ", "", $request->getParam('to')),
            'mode' => ['driving', 'walking']
        ];
        
        $curl = new CURL();
        $result = $curl->getDistanceTwoDots($data);

        return $response->withStatus(200)
        ->withJson($result); 
    }

}
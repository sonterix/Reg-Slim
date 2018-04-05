<?php

namespace App\Controller;

use App\Model\DB as DB;

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

}
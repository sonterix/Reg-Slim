<?php

namespace App\Controller;

use App\Model\BalansModel as BalansModel;

class BalansController {
    private $settings;

    public function __construct() {   
        // Get config data
        $config = require __DIR__ . '/../../src/settings.php';
        $this->settings = $config['settings']['db'];
    }

    public function addBalans($request, $response) {
        $data = [
            'id' => trim($request->getParam('user_id_author')),
            'user_id' => trim($request->getParam('user_id')),
            'balans' => trim($request->getParam('balans')),
        ];

        $db = new BalansModel($this->settings);
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

        $db = new BalansModel($this->settings);
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

        $db = new BalansModel($this->settings);
        $balans = $db->getBalans($user_id);

        return $response->withStatus(200)
            ->withJson($balans);     
    }

}
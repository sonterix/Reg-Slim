<?php

namespace App\Controller;

use App\Model\MapModel as MAP;

class BalansController {
    private $settings;

    public function __construct() {   
        // Get config data
        $config = require __DIR__ . '/../../src/settings.php';
        $this->settings = $config['settings']['db'];
    }

    public function getDistance($request, $response) {
        $data = [
            'apiKey' => 'AIzaSyAwQ9RPK8fNSMBNYmWtlbe1qrI8stfqjFw',
            'from' => str_replace(" ", "", $request->getParam('from')),
            'to' => str_replace(" ", "", $request->getParam('to')),
            'mode' => ['driving', 'walking']
        ];
        
        $curl = new MAP();
        $result = $curl->getDistanceTwoDots($data);

        return $response->withStatus(200)
        ->withJson($result); 
    }

}
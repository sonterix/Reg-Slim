<?php
namespace App\Model;

class MapModel {
    private $dbh;
    private $settings;

    public function __construct() {   
        $ch = curl_init(); 
    }

    public function getDistanceTwoDots($data) {
        $result = [];

        foreach($data['mode'] as $value) {
            $link = 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$data['from'].'&destinations='.$data['to'].'&key='.$data['apiKey'].'&mode='.$value;

            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, $link); 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $output = json_decode(curl_exec($ch)); 
            $result[$value] = [
                'distance' => $output->rows[0]->elements[0]->distance->text,
                'time' => $output->rows[0]->elements[0]->duration->text
            ];
            curl_close($ch); 
        } 
        
        return $result;
    }
   
} 
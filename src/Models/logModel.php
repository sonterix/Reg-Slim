<?php
namespace App\Model;

class LogModel {
    private $dbh;
    private $settings;

    public function __construct($config = []) {   
        // Get config data
        $this->settings = $config;

        // Connect to db
        $dsn = "mysql:host=".$this->settings['host'].";dbname=".$this->settings['dbname'].";charset=".$this->settings['charset'];

        $this->dbh = new \Slim\PDO\Database($dsn, $this->settings['user'], $this->settings['pass']);
    }

    public function writeBalansLog($user_id, $value, $currentValue, $action) {
        $log = $this->dbh->insert(['user_id', 'value', 'current_value', 'action'])
            ->into('balans_log')
            ->values([$user_id, $value, $currentValue, $action]);

        $log->execute();
    }
    
}
<?php
namespace App\Model;

class BalansModel {
    private $dbh;
    private $settings;

    public function __construct($config = []) {   
        // Get config data
        $this->settings = $config;

        // Connect to db
        $dsn = "mysql:host=".$this->settings['host'].";dbname=".$this->settings['dbname'].";charset=".$this->settings['charset'];

        $this->dbh = new \Slim\PDO\Database($dsn, $this->settings['user'], $this->settings['pass']);
    }

    public function addBalance($data) {
        $balans = $this->dbh->select(['balans'])
            ->from('users')
            ->where('id', '=', $data['user_id']);

        $stmt = $balans->execute();
        $result = $stmt->fetch();

        $newBalans = $result['balans'] + $data['balans'];

        $update = $this->dbh->update(['balans' => $newBalans])
            ->table('users')
            ->where('id', '=', $data['user_id']);

        $resultUpdate = $update->execute();
        
        return $resultUpdate;
    }

    public function takeOffBalans($data) {
        $balans = $this->dbh->select(['balans'])
            ->from('users')
            ->where('id', '=', $data['id']);

        $stmt = $balans->execute();
        $result = $stmt->fetch();

        $newBalans = $result['balans'] - $data['balans'];

        $update = $this->dbh->update(['balans' => $newBalans])
            ->table('users')
            ->where('id', '=', $data['id']);

        $resultUpdate = $update->execute();
        
        return $resultUpdate;
    }

    
    public function getBalans($user_id) {
        $balans = $this->dbh->select(['balans'])
            ->from('users')
            ->where('id', '=', $user_id);

        $stmt = $balans->execute();
        $result = $stmt->fetch();
        
        return $result;
    }
    
}
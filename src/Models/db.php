<?php
namespace App\Model;

class Db {
    private $dbh;
    private $settings;

    public function __construct($config = []) {   
        // Get config data
        $this->settings = $config;

        // Connect to db
        $dsn = "mysql:host=".$this->settings['host'].";dbname=".$this->settings['dbname'].";charset=".$this->settings['charset'];

        $this->dbh = new \Slim\PDO\Database($dsn, $this->settings['user'], $this->settings['pass']);
    }

    public function getUser($login) {
        $user = $this->dbh->select()
            ->from('users')
            ->where('login', '=', $login);

        $stmt = $user->execute();
        $result = $stmt->fetch();
        
        return $result;
    }

    public function regUser($data) {
        $user = $this->dbh->insert()
            ->into('users')
            ->columns(['login', 'password'])
            ->values([$data['login'], $data['password']]);
        
        $user->execute();
    }

    public function userLogin($data) {
        $user = $this->dbh->select()
            ->from('users')
            ->where('login', '=', $data['login'])
            ->where('password', '=', $data['password']);

        $stmt = $user->execute();
        $result = $stmt->fetch();
        
        return $result;
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

        // write log
        $this->writeBalansLog($data['user_id'], $data['balans'], $newBalans, 'add to balans');
        
        return $resultUpdate;
    }

    public function takeOffBalans($data) {
        $balans = $this->dbh->select(['balans'])
            ->from('users')
            ->where('id', '=', $data['user_id']);

        $stmt = $balans->execute();
        $result = $stmt->fetch();

        $newBalans = $result['balans'] - $data['balans'];

        $update = $this->dbh->update(['balans' => $newBalans])
            ->table('users')
            ->where('id', '=', $data['user_id']);

        $resultUpdate = $update->execute();

        // write log
        $this->writeBalansLog($data['user_id'], $data['balans'], $newBalans, 'take off balans');
        
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

    public function writeBalansLog($user_id, $value, $currentValue, $action) {
        $log = $this->dbh->insert(['user_id', 'value', 'current_value', 'action'])
            ->into('balans_log')
            ->values([$user_id, $value, $currentValue, $action]);

        $log->execute();
    }
}
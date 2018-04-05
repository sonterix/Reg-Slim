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
        $data = $stmt->fetch();
        
        return $data;
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
        $data = $stmt->fetch();
        
        return $data;
    }

}
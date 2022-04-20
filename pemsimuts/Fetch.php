<?php
class Fetch
{
    public $dbh;
    public $user = 'root';
    public $pass = '';
    function __construct()
    {
        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try {
            $this->dbh = new PDO('mysql:host=localhost;dbname=pemsimuts', $this->user, $this->pass, $option);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {

        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->stmt->execute();
    }

    public function arrExecute($data = [])
    {
        $this->stmt->execute($data);
    }

    public function resultSet()
    {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function rExecute()
    {
        return $this->stmt->execute();
    }

    public function columnCount()
    {
        return $this->stmt->columnCount();
    }
}

class Model extends Fetch
{
    public function userCheck($user)
    {
        $query = 'SELECT user FROM user WHERE user = :user';
        $this->query($query);
        $this->bind('user', $user);
        $this->execute();
        return $this->rowCount();
    }

    public function loadData($user)
    {
        $query = 'SELECT * FROM user WHERE user = :user';
        $this->query($query);
        $this->bind('user', $user);
        return $this->single();
    }

    public function tambahUser($user)
    {
        $query = 'INSERT INTO user (user) VALUES (:user)';

        $this->query($query);
        $this->bind('user', $user);
        $this->execute();
        return $this->rowCount();
    }

    public function hapusData($user)
    {
        $query = 'DELETE FROM user WHERE user = :user';
        $this->query($query);
        $this->bind('user', $user);
        $this->execute();
        return $this->rowCount();
    }

    public function tambahUserData($arr)
    {
        $query = 'INSERT INTO user (user, x, y) VALUES (:user, :x, :y)';
        $this->query($query);
        $this->bind('user', $arr[0]);
        $this->bind('x', $arr[1]);
        $this->bind('y', $arr[2]);
        $this->execute();
        return $this->rowCount();
    }
}

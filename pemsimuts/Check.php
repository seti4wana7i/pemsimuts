<?php
header('Access-Control-Allow-Origin: *');
require_once 'Fetch.php';
class Check
{
    public $x = [];
    public $y = [];
    public $model;

    public function __construct()
    {
        $this->model = new Model();
    }

    function api()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        foreach ($data as $v) {
            array_push($this->x, $v[0]);
            array_push($this->y, $v[1]);
        }

        $x = implode("/", $this->x);
        $y = implode("/", $this->y);

        $arr = [$_SESSION['user'], $x, $y];

        echo $this->model->hapusData($_SESSION['user']);
        echo $this->model->tambahUserData($arr);
    }
}
session_start();
$iki = new Check();
$iki->api();

<?php
define('root', 'http://localhost/pemsimuts/');
require_once 'Login.php';
require_once 'Fetch.php';

class Index
{
    public $login, $model;
    function __construct()
    {
        $this->login = new Login();
        $this->model = new Model();
    }
    function home()
    {
        if (isset($_SESSION['user'])) {
            $_SESSION['user'];

            if ($this->model->userCheck($_SESSION['user']) != 0) {
                $data = $this->model->loadData($_SESSION['user']);
                $x = explode("/", $data['x']);
                $y = explode("/", $data['y']);
                $this->excel($x, $y);
            } else {
                $this->model->tambahUser($_SESSION['user']);
                $x = null;
                $y = null;
                $this->excel($x, $y);
            }
        } else {
            $this->login->index();
        }
    }

    function excel($x, $y)
    {
        $x;
        $y;
        require_once 'Home_view.php';
    }

    function close()
    {
        unset($_SESSION['user']);
        echo '<script>window.location.href = "http://localhost/pemsimuts/Index.php"</script>';
    }
}

if (!session_id()) session_start();

$index = new index();
$index->home();
if (isset($_GET['haha'])) {
    $var = $_GET['haha'];
    $index->$var();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>
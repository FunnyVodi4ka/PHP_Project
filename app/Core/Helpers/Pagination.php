<?php
//Пагинация
class Pagination
{
    public function CalculatePagParams($recordCount)
    {
        session_start();
        if (isset($_GET['?PageRows']) && ($_GET['?PageRows'] == 10 ||
                $_GET['?PageRows'] == 25 || $_GET['?PageRows'] == 50)) {
            $_SESSION['PageRows'] = $_GET['?PageRows'];
        }

        if (empty($_SESSION['PageRows'])) {
            $PageCount = 10;
        } else {
            $PageCount = $_SESSION['PageRows'];
        }

        if (!isset($_GET['list'])) {
            $_GET['list'] = 1;
        }

        if (isset($_GET['?list'])) {
            $_GET['list'] = (int)$_GET['?list'];
        }

        if ($_GET['list'] > ceil($recordCount / $PageCount)){
            $_GET['list'] = ceil($recordCount / $PageCount);
        }

        if ($_GET['list'] < 1) {
            $_GET['list'] = 1;
        }

        return $PageCount;
    }
}
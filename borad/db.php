<?php
    header('Content-Type: text/html; charset=utf-8');

    $db = new mysqli("127.0.0.1", "root","","cap");
    $db->set_charset("utf8");

    function mq($sql)
    {
        global $db;
        return $db->query($sql);
    }
?>
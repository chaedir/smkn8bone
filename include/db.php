<?php
//$Connection = new mysqli("localhost", "root", "", "phpcms");
//$Connection = new mysqli("localhost", "u7065655_chaedir", "I.L.U.All", "u7065655_phpcms");
$Connection = new mysqli("localhost", "u7065655_chaedir", "I.L.U.All", "u7065655_phpcms2");

if (!$Connection) {
    echo "Connection error!";
    exit();
}

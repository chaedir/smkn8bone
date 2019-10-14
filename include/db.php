<?php
$Connection = new mysqli("localhost", "root", "", "phpcms");

if (!$Connection) {
    echo "Connection error!";
    exit();
}

<?php

$conn = oci_connect('TESTORACLE', 'Tu01228671340', 'localhost/XE:BloodBank','Al32UTF8');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}else {
    echo "connected to database with me !";
}

?>

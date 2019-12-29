<?php
/**
 * Created by PhpStorm.
 * User: T.Aathman
 * Date: 12/29/2019
 * Time: 11:26 AM
 */


$id = $_GET['id'];
$query = "update reports set pending=0, acceptReject=0 where id='$id'";

$mysqli = new mysqli('localhost', 'root', '', 'accidentreporter');
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: " . $mysqli->connect_error;
    exit();
}
if (!$mysqli->query($query)) {
    echo("Error description: " . $mysqli->error);
}
$mysqli->close();

header("location: index.php");
?>


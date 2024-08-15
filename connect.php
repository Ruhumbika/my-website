<?php

$con=new mysqli('localhost', 'root','','crudopperation');

if(!$con){
    die(mysqli_error($con));
}
?>
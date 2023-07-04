<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$num = $_GET['num'];

$fsql = "delete from test_file where num = $num";
$fresult = $mysqli -> query($fsql) or die($mysqli->error);
$sql = "delete from test_content where num = $num";
$result = $mysqli -> query($sql) or die($mysqli->error);

if($result){
    echo '<script>location.href=\'/medsoft/board_index.php\';</script>';
    exit;
}else{
    echo '<script>alert(\'insert failed\');history.back();</script>';
    exit;
}
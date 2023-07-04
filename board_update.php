<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$num = $_POST['modify_board_num'];
$title = $_POST['modify_board_title'];
$title = addslashes($title);
$content = $_POST['modify_board_content'];
$content = addslashes($content);

$sql = "update test_content set title = '$title', content = '$content' where num = $num";
$result = $mysqli -> query($sql) or die($mysqli->error);

if($result){
    echo '<script>location.href=\'/medsoft/board_index.php\';</script>';
    exit;
}else{
    echo '<script>alert(\'insert failed\');history.back();</script>';
    exit;
}
?>
<?php
$serverName = 'localhost'; // MySQL 서버 이름
$userName = 'root'; // MySQL 사용자 이름
$password = '123456'; // MySQL 사용자 비밀번호
$dbName = 'test_board'; // 사용할 데이터베이스 이름

$mysqli = new mysqli($serverName, $userName, $password, $dbName);
if ($mysqli->connect_errno) {
    die("failed to connect mysql => ".$mysqli->connect_error);
}
?>
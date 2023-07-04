<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$userpw = $_POST['userpw'];
$userpwok = $_POST['userpwok'];
$userid = $_POST['userid'];
$username = $_POST['username'];
$userage = $_POST['userage'];
$usersex = $_POST['usersex'];
$graduate = $_POST['graduate'];
$academic = implode(" || ", $graduate);
$addr1 = $_POST['register_juso'];
$addr2 = $_POST['gyunggido'];
if($addr1 == 'gyunggido'){
    $useraddress = $addr1." || ".$addr2;
}else {
    $useraddress = $addr1;
}
$emailid = $_POST['useremail_id'];
$emailurl = $_POST['useremail_url'];
$useremail = $emailid.'@'.$emailurl;
$length = count($graduate)-1;
/*
echo "<pre>";
print_r ($_POST);
print_r ($academic);
echo "</pre>";
exit;
*/
$sql = "insert into test_member (userid, userpw, userpwok, username, userage, usersex, graduate, useraddress, useremail) 
        values ('".$userid."', '".$userpw."', '".$userpwok."', '".$username."', '".$userage."', '".$usersex."', '".$academic."', '".$useraddress."', '".$useremail."')";
$result=$mysqli->query($sql) or die($mysqli->error);
$psql = "update test_member set userpw = hjm_pass('".$userpw."'), userpwok = hjm_pass('".$userpwok."') where userid = '".$userid."';";
$presult=$mysqli->query($psql) or die($mysqli->error);

if($result && $presult){
    echo '<script>location.href=\'/medsoft/board_index.php\';</script>';
    exit;
}else{
    echo '<script>alert(\'insert failed\');history.back();</script>';
    exit;
}
?>
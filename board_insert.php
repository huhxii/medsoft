<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

// $num = $_POST['board_num'];
// 제목,내용 맨 앞에 ' 가 들어가면 오류가 남 >> 해결할 것 : addslashes(), stripslashes()
// addslashes() : 작은 따옴표('), 큰 따옴표(")앞에 역슬래쉬(\)가 추가된다
// stripslashes() : 추가된 역슬래쉬를 없앤다
$title = $_POST['board_title'];
$title = addslashes($title);
$content = $_POST['board_content'];
$content = addslashes($content);
$author = 'admin'; //userid는 없어서 임의로 넣어줬다.
$userid = 'unknown';
$file_name = 'nofile';
/*
$check = $_FILES["upfile"];
foreach($_POST as $key => $val){
    echo $key.".".$val."<br>";
    echo $_POST[$key]."<br>";
}
echo "<pre>";
print_r($_POST);
echo "</pre>";
exit;
*/
$sql = "insert into test_content (author, userid, title, content, file_name) values ('".$author."', '".$userid."', '".$title."', '".$content."', '".$file_name."')";
$result=$mysqli->query($sql) or die($mysqli->error);

$nsql = "select num from test_content order by num desc limit 1";// "select last_insert_id() from test_content limit 1";
$nresult = $mysqli->query($nsql) or die($mysqli->error);
$nrs = $nresult -> fetch_object();
$num = $nrs -> num;

echo "<pre>";
print_r($_FILES);
echo $_FILES['file']['name'];
echo "</pre>";
exit;


if(!empty($_FILES['file']['name']) && isset($_FILES['file']['name'])){//첨부한 파일이 있으면
    echo "111";
    exit;
    $fsql = "update test_content set file_name = 'exist' where num = '".$num."')";
    $fresult = $mysqli->query($fsql) or die($mysqli->error);

    for($i=0;$i<count($_FILES["upfile"]["name"]);$i++){
        $upfile_size = $_FILES['upfile']['size'][$i];
        $upfile_type = $_FILES['upfile']['type'][$i];
        $upfile_tmp_name = $_FILES["upfile"]["tmp_name"][$i];
        if($upfile_size>10240000){//10메가
            echo '<script>alert(\'10MB 이하만 파일 첨부할 수 있습니다.\');history.back();</script>';
            exit;
        }
        /*
        if($upfile_type != 'image/jpeg' && $upfile_type != 'image/gif' && $upfile_type != 'image/png'){
            echo '<script>alert(\'이미지만 첨부할 수 있습니다.\');history.back();</script>';
            exit;
        }
        */
        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/medsoft/data/';
        $upfile_name = $_FILES["upfile"]["name"][$i];
        $file_ext = pathinfo($upfile_name,PATHINFO_EXTENSION);//확장자 구하기
        $copied_file_name = date("YmdHis").$upfile_name;
        $uploaded_file = $copied_file_name.".".$file_ext;//새로운 파일이름과 확장자를 합친다
        if(move_uploaded_file($upfile_tmp_name, $upload_dir.$uploaded_file)){//파일 등록에 성공하면 디비에 등록해준다.
            $fsql = "insert into test_file (num, userid, file_name, file_type, copied_file) values ('$num', '$userid', '$upfile_name', '$file_ext', '$copied_file_name')";
            $fresult = $mysqli->query($fsql) or die($mysqli->error);
        }
    }
}
if($result){
    echo '<script>location.href=\'/medsoft/board_index.php\';</script>';
    exit;
}else{
    echo '<script>alert(\'insert failed2\');history.back();</script>';
    exit;
}
?>
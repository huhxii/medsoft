<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$upload_dir = $_SERVER['DOCUMENT_ROOT'].'/medsoft/data/';
$num = $_GET['num'];
$result = $mysqli->query('select * from test_content where num='.$num) or die('query error => '.$mysqli->error);
$rs = $result->fetch_object();
$file_check = $rs->file_name;
$file_count = '';
if($file_check == 'exist'){
    $fresult = $mysqli->query("select * from test_file where num='$num' order by fid asc") or die('query error => '.$mysqli->error);
    while($frs = $fresult->fetch_object()){
        $fileArray[]=$frs;
    }
    $file_count = array_column($fileArray, 'file_name');
    $count = count($fileArray);
    /*
    echo "<pre>";
    echo "$count";
    echo "<br>";
    print_r($fileArray);
    echo "</pre>";
    */
}
// 조회수
$views = $rs->views;
if(isset($views)){
    $mysqli->query("update test_content set views = '$views' + 1 where num = $num");
}
/*
// 다중 파일
$fquery = 'select * from test_content where num = '.$rs->num;
$file_result = $mysqli->query($fquery) or die('query error => '.$mysqli->error);
$frs = $file_result->fetch_object();
while($frs = $file_result->fetch_object()){
    
    $fileArray[]=$frs;
}
*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>글읽기</title>
        <style>
            a { text-decoration: none; color: black; }
            a:visited { text-decoration: none; color: black; }
            :root { --font-color: black; }
            * { padding: 0; margin: 0; }
            body { margin-top: 10%;}
            #view_section { display: flex; flex-direction: column; justify-content: center; align-items: center; }
            #view_board_title { width: 70%; margin: auto; padding: 10px; border-bottom: 3px solid silver; }
            #view_board_title input:focus { width: 98.5%; margin: auto; padding: 10px; font-size: 20px; outline: none; }
            #view_board_content { width: 70%; height: 300px; margin: auto; padding: 10px; border-bottom: 3px solid silver; }
            #view_board_content input:focus { width: 98.5%; margin: auto; padding: 10px; font-size: 15px; outline: none; }
            #view_board_files1 { width: 71%; margin: 0; display: flex; flex-direction: row; justify-content: left; align-items: center; padding: 15px 0 20px 0; border-bottom: 1px solid silver; }
            #view_board_files2 { width: 71%; margin: 0; display: flex; flex-direction: row; justify-content: left; align-items: center; padding: 15px 0 20px 0; border-bottom: 1px solid silver; }
            #view_board_files3 { width: 71%; margin: 0; display: flex; flex-direction: row; justify-content: left; align-items: center; padding: 15px 0 20px 0; border-bottom: 1px solid silver; }
            #view_button_file_insert { margin: 10px 0 0 20px; padding: 5px 10px 5px 10px; color: black; border: 1px solid silver; background-color: silver; border-radius: 5px; }
            #view_board_files input { margin: 8px 0 0 5px; font-size: 20px; outline: none; }
            #view_board_files a { margin: 6px 0 0 10px; }
            #view_board_reg_btn { width: 70%; margin: 0; display: flex; justify-content: right; align-items: center; padding-top: 15px; }
            #view_button_index { margin-top: 10px; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
        <script type="text/javascript">
            // delete jQuery 이용
            $(document).ready(function() {
                var file_count = $('#file_count').val();
                var file_name1 = $('#file_check1').val();
                var file_name2 = $('#file_check2').val();
                var file_name3 = $('#file_check3').val();
                if(file_count == 1){
                    $('#view_file1').attr('value', file_name1);
                }
                if(file_count == 2){
                    $('#view_file1').attr('value', file_name1);
                    $('#view_file2').attr('value', file_name2);
                }
                if(file_count == 3){
                    $('#view_file1').attr('value', file_name1);
                    $('#view_file2').attr('value', file_name2);
                    $('#view_file3').attr('value', file_name3);
                }
                /*
                switch(file_count){
                    case 1 : 
                        $('#view_file1').attr('value', "file_name1");
                        $('#view_file2').val("");
                        $('#view_file3').val("");
                        break;
                    case 2 : 
                        $('#view_file1').attr('value', file_name1);
                        $('#view_file2').attr('value', file_name2);
                        $('#view_file3').val("");
                        break;
                    case 3 : 
                        $('#view_file1').attr('value', file_name1);
                        $('#view_file2').attr('value', file_name2);
                        $('#view_file3').attr('value', file_name3);
                        break;
                    default : 
                        $('#view_file1').val("");
                        $('#view_file2').val("");
                        $('#view_file3').val("");
                        break;
                }
                */
            });
        </script>
    </head>
<body>
    <section id="view_section">
        <div id="view_board_title"><?php echo $rs->title;?></div>
        <div id="view_board_content"><?php echo $rs->content;?></div>
        <input id="file_count" type="hidden" value="<?php echo count($fileArray);?>">
        <input id="file_check1" type="hidden" value="<?php echo $file_count[0];?>">
        <input id="file_check2" type="hidden" value="<?php echo $file_count[1];?>">
        <input id="file_check3" type="hidden" value="<?php echo $file_count[2];?>">
        <div id="view_board_files1">
            <!-- 첨부파일 다운로드 가능하게 바꿀것 -->
            <input id="view_file1">
            <a href='./download.php?file=<?php echo $fileArray[0]->copied_file;?>.<?php echo $fileArray[0]->file_type;?>&target_dir=<?php echo $upload_dir;?>'>다운</a>
        </div>
        <div id="view_board_files2">  
            <input id="view_file2">
            <a href='./download.php?file=<?php echo $fileArray[1]->copied_file;?>.<?php echo $fileArray[1]->file_type;?>&target_dir=<?php echo $upload_dir;?>'>다운</a>
        </div>
        <div id="view_board_files3">  
            <input id="view_file3">
            <a href='./download.php?file=<?php echo $fileArray[2]->copied_file;?>.<?php echo $fileArray[2]->file_type;?>&target_dir=<?php echo $upload_dir;?>'>다운</a>
        </div>
        <div id="view_board_reg_btn">
            <button type="button" id="view_button_index" onclick="document.location.href='/medsoft/board_index.php'">목록</button>
        </div>
    </section>
</body>
</html>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$num=$_GET['num'];
$result = $mysqli->query('select * from test_content where num='.$num) or die('query error => '.$mysqli->error);
$rs = $result->fetch_object();
$fresult = $mysqli->query('select * from test_file where num='."$num".' order by fid asc') or die("query error => ".$mysqli->error);
while($frs = $fresult->fetch_object()){
    $fileArray[] = $frs;
}
echo "111";
// echo "<pre>";
// print_r($rs);
// echo "</pre>";
$title = $rs->title;
$title = stripslashes($title);
$content = $rs->content;
$content = stripslashes($content);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>수정</title>
        <style>
            :root { --font-color: black; }
            * { padding: 0; margin: 0; }
            body { margin-top: 10%;}
            #modify_section { display: flex; flex-direction: column; justify-content: center; align-items: center; }
            #modify_board_title { width: 70%; margin: auto; padding: 10px; border-bottom: 3px solid silver; }
            #modify_board_title input { width: 98.5%; margin: auto; padding: 10px; font-size: 20px; }
            #modify_board_title input:focus { width: 98.5%; margin: auto; padding: 10px; font-size: 20px; }
            #modify_board_content { width: 70%; height: 300px; margin: auto; padding: 10px; border-bottom: 3px solid silver; }
            #modify_board_content textarea { width: 98.5%; height: 94%; margin: auto; padding: 10px; font-size: 15px; }
            .modify_board_files { width: 71%; margin: 0; display: flex; justify-content: left; align-items: center; padding: 15px 0 20px 0; border-bottom: 1px solid silver; }
            #modify_button_file_insert { margin: 10px 0 0 20px; padding: 5px 10px 5px 10px; color: black; border: 1px solid silver; background-color: silver; border-radius: 5px; }
            .modify_board_files input { margin: 8px 0 0 5px; font-size: 20px; outline: none; }
            #modify_board_reg_btn { width: 70%; margin: 0; display: flex; justify-content: right; align-items: center; padding-top: 15px; }
            #modify_button_cancel { margin: 10px 10px 0 0; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
            #modify_button_update { margin-top: 10px; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
    </head>
<body>
    <form method="post" action="board_update.php" enctype="multipart/form-data">
        <input type="hidden" name="modify_board_num" value="<?php echo $num;?>">
        <section id="modify_section">
            <div id="modify_board_title"><input type="text" name="modify_board_title" style="font-size: 20px;" value="<?php echo $title;?>"></div>
            <div id="modify_board_content"><textarea name="modify_board_content" style="font-size: 15px;"><?php echo $content;?></textarea></div>
            <div class="modify_board_files">
                <input type="file" name="upfile[]">
                <!--
                <?php
                    // foreach($fileArray as $$k => $v){
                    //    echo $v[0];
                ?>
                <input type="file" name="upfile[]"><img src="/data/<?php echo $fa->filename;?>">
                <input type="file" name="upfile[]"><img src="/data/<?php echo $fa->filename;?>">
                <input type="file" name="upfile[]"><img src="/data/<?php echo $fa->filename;?>">
                <?php // }?>
                -->
            </div>
            <!--
            <div class="modify_board_files">
                <input type="file" name="upfile[]">
            </div>
            <div class="modify_board_files">
                <input type="file" name="upfile[]">
            </div>
            -->
            <div id="modify_board_reg_btn">
                <button type="button" id="modify_button_cancel" onclick="document.location.href='/medsoft/board_index.php'">취소</button>
                <button type="submit" id="modify_button_update">수정</button>
            </div>
        </section>
    </form>
</body>
</html>
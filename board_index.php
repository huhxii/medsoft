<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$result = $mysqli->query('select * from test_content order by num desc') or die('select query error => '.$mysqli->error);
while($rs = $result->fetch_object()){
    $title = $rs->title;
    $title = stripslashes($title);
    $content = $rs->content;
    $content = stripslashes($content);
    $rsc[]=$rs;
}
$num = $result->fetch_row();
$count = $mysqli->query('select count(*) from test_content') or die('count query error => '.$mysqli->error);
/*
fetch_array : Array ( [0] => 3 [count(*)] => 3 )
fetch_object : stdClass Object ( [count(*)] => 3 )
fetch_row : Array ( [0] => 3 )
*/
$cnt = $count->fetch_row();
$cntAll = $cnt[0];
/*
게시글 순서 DB순으로
1. $count : 쿼리이용해서 전체 테이블 행 개수 받기
2. $cnt : fetch이용해서 $count 배열중 개수 정보 받아오기
3. $cntAll : 이용해서 개수 받기 : 현재 $cntAll = 3
4. $i++ > $i-- 역순으로 변환
*/
/*
$member = $mysqli->query("select * from test_member where userid='testgraduate7'") or die('select query error => '.$mysqli->error);
$mrs = $member->fetch_object();
print_r($mrs);
*/
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>게시판</title>
        <style>
            a { text-decoration: none; color: black; }
            a:visited { text-decoration: none; color: black; }
            :root { --font-color: black; }
            * { padding: 0; margin: 0; }
            body { margin-top: 10%;}
            .table_title { width: 70%; margin: auto; padding: 10px; border-bottom: 3px solid black; }
            h3 { padding-left: 10px; }
            .table { width: 68%; margin: auto; border-collapse: collapse; }
            tr { margin: 0; }
            th, td { border-bottom: 1px solid gray; padding: 12px; margin: auto; }
            .update_delete_button { display: flex; justify-content: space-around; align-items: center; }
            .table_button { width: 82%; margin: 0; display: flex; justify-content: right; align-items: center; padding-top: 15px; }
            .button_write { margin-top: 10px; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
        <script type="text/javascript">
            // delete jQuery 이용
            $(document).ready(function() {
                $("#button_delete").click(function() {
                    var check = confirm("삭제 하시겠습니까?");
                    if(check == true){
                        alert("삭제 완료");
                        $("#board_form").submit();
                        return false;
                    }else{
                        alert("취소");
                        return false;
                    }
                });
                $("#member_view").click(function() {
                    // window.open('/medsoft/register_check_id.php','정보보기','width=650,height=300,scrollbars=no');
                    location.replace('/medsoft/register_check_id.php');
                });
            });
        </script>
    </head>
    <body>
        <section>
            <div class="table_title">
                <h3><a id="member_view">게시판 목록</a></h3>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 10%;">NO</th>
                        <th scope="col" style="display: none;">번호</th>
                        <th scope="col" style="width: 60%;">제목</th>
                        <th scope="col" style="width: 10%;">등록일</th>
                        <th scope="col" style="width: 10%;">조회수</th>
                        <th scope="col" style="width: 10%;">수정&nbsp/&nbsp삭제</th>
                    </tr>
                </thead>
                <?php 
                    $i = $cntAll;
                    foreach($rsc as $r){
                ?>
                <form id="board_form" method="post" action="board_delete.php?num=<?php echo $r->num;?>">
                <tbody>
                    <tr>
                    <th scope="row"><?php echo $i--;?></th>
                    <td id="board_num" style="display: none;"><?php echo $r->num;?></td>
                    <td><a href="/medsoft/board_view.php?num=<?php echo $r->num;?>" formaction="/medsoft/board_view.php"><?php echo $r->title?></a></td>
                    <td><?php echo $r->regist_date?></td>
                    <td class="views" style="text-align:center"><?php echo $r->views?></td>
                    <td>
                        <div class="update_delete_button">
                            <button type="button" class="button_update"><a href="/medsoft/board_modify.php?num=<?php echo $r->num;?>">수정</a></button>
                            &nbsp/&nbsp
                            <button type="button" class="button_delete" id="button_delete">삭제</button>
                        </div>
                    </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <div class="table_button">
                <button type="button" class="button_write" onclick="document.location.href='/medsoft/board_write.php'">글쓰기</button>
            </div>
        </section>
        </form>
    </body>
</html>
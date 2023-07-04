<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';
?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>회원보기</title>
        <style>
            :root { --font-color: black; font-size: 20px; }
            * { padding: 0; margin: 0; }
            body { margin-top: 10%; }
            section { width: 90%; margin: auto; }
            .basic_info { width: 80%; margin: auto; padding: 20px; display: flex; flex-direction: row; }
            .basic_info div { width: 100%; display: flex; flex-direction: row; justify-content: center; align-items: center; padding: 0 0 20px 0; }
            .basic_info div label { width: 150px; }
            .basic_info div input { height: 25px; }
            .basic_info div select { width: 150px; height: 30px; }
            .basic_info div select option { font-size: 20px; margin: auto; }
            .id_view_inputbox_id { width: 60%; }
            .id_view_inputbox_email { width: 10%; }
            #id_view_button { width: 100px; margin: 0 30px 0 0; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                // 필수체크 이벤트
                $("#id_view_button").click(function() {
                    var userid = $("input[name='userid']").val();
                    if(userid == ""){
                        alert ("ID를 입력해 주세요.");
                        $("input[name='userid']").focus();
                        return false;
                    }
                    $("#id_form").submit();
                    window.close();
                });
            });
        </script>
    </head>
    <body>
        <section>
        <div class="basic_info">
            <form id="id_form" method="post" action="register_view.php">
                <div class="id_view_userid">
                    <label class="id_view_userid_label">아이디</label>
                    <input id="id_check" type="text" name="userid" class="id_view_inputbox_id">&nbsp&nbsp
                    <button id="id_view_button" type="button" onclick="parent.location.href='/medsoft/register_view.php'">목록</button>
                </div>
            </form>
        </div>
        </section>
    </body>
</html>            
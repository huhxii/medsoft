<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>글쓰기</title>
        <style>
            :root { --font-color: black; }
            * { padding: 0; margin: 0; }
            body { margin-top: 10%;}
            .write_section { display: flex; flex-direction: column; justify-content: center; align-items: center; }
            .board_title { width: 70%; margin: auto; padding: 10px; border-bottom: 3px solid silver; }
            .board_title input { width: 98.5%; margin: auto; padding: 10px; font-size: 20px; }
            .board_title input:focus { width: 98.5%; margin: auto; padding: 10px; font-size: 20px; }
            .board_content { width: 70%; height: 300px; margin: auto; padding: 10px; border-bottom: 3px solid silver; }
            .board_content textarea { width: 98.5%; height: 94%; margin: auto; padding: 10px; font-size: 15px; }
            .board_files { width: 71%; margin: 0; display: flex; justify-content: left; align-items: center; padding: 15px 0 20px 0; border-bottom: 1px solid silver; }
            .button_file_insert { margin: 10px 0 0 20px; padding: 5px 10px 5px 10px; color: black; border: 1px solid silver; background-color: silver; border-radius: 5px; }
            .board_files input { margin: 8px 0 0 5px; font-size: 20px; outline: none; }
            .board_reg_btn { width: 70%; margin: 0; display: flex; justify-content: right; align-items: center; padding-top: 15px; }
            .button_cancel { margin: 10px 10px 0 0; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
            .button_insert { margin-top: 10px; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
        <!-- jQuery 필수체크 -->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script> <!-- 없으면 jQuery 작돟X -->
        <script type="text/javascript">
            $(function() { //기본 형태 : $(document).ready(function(){})
                $("#button_insert").click(function() { // $(".button_insert") : class="button_insert" 있는곳을 호출, .click() : 클릭시 이벤트 발생
                    var board_title = $.trim($("#board_title").val()); // $("#board_title").val().trim(); : 자바스크립트 함수 // $("#board_title") : id="board_title" 있는곳을 호출
                    var board_content = $("#board_content").val().trim(); // val() : 값, .trim() : 공백 삭제
                    if(board_title == ""){
                        alert ("제목을 입력해 주세요.");
                        $('#board_title').focus(); // .focus() : 커서 이동
                        return false;
                    }
                    if(board_content == ""){
                        alert ("내용을 입력해 주세요.");
                        $('#board_content').focus();
                        return false;
                    }
                    // $("#board_form").submit(); // .submit() : form 태그에만 사용 가능 type="submit" 역할
                });
            });
        </script>
    </head>
<body>
    <!-- enctype="multipart/form-data" : 파일 등록시 필요 -->
    <form id="board_form" method="post" action="board_insert.php" enctype="multipart/form-data">
        <input type="hidden" name="board_num" value="<?php echo $num;?>">
        <section class="write_section">
            <div class="board_title"><input type="text" name="board_title" placeholder="제목" style="font-size: 20px;"></div>
            <div class="board_content"><textarea type="text" name="board_content" placeholder="내용" style="font-size: 15px;"></textarea></div>
            <div class="board_files">
                <!-- 파일 다수일때 : name="upfile[]" multiple : 배열화 + multiple 입력 -->
                <input type="file" name="upfile[]"><!-- : 파일 선택 -->
            </div>
            <div class="board_files">
                <input type="file" name="upfile[]">
            </div>
            <div class="board_files">
                <input type="file" name="upfile[]">
            </div>
            <div class="board_reg_btn">
                <button type="button" class="button_cancel" onclick="document.location.href='/medsoft/board_index.php'">취소</button>
                <button type="submit" class="button_insert" id="button_insert">등록</button>
            </div>
        </section>
    </form>
</body>
</html>
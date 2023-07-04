<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

// 등록(가입)폼에 *나이(max 3자리, 숫자만), *성별(라디오 박스), *학력(초, 중, 고, 대 / 체크 박스)
// 주소(셀렉트 박스 3~5개), 상세주소(주소 경기도 선택시 라디오 버튼으로 성남, 용인, 화성 : 활성화 / 경기도 아닐때 비활성화) > 전부 필수 jQuery & DB저장
?>

<!doctype html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>회원가입</title>
        <style>
            :root { --font-color: black; font-size: 20px; }
            * { padding: 0; margin: 0; }
            body { margin-top: 10%; }
            section { width: 90%; margin: auto; }
            .basic_info { width: 80%; margin: auto; padding: 20px; display: flex; flex-direction: column; }
            .basic_info div { width: 100%; display: flex; flex-direction: row; justify-content: flex-start; align-items: center; padding: 0 0 20px 20%; }
            .basic_info div label { width: 300px; }
            .basic_info div input { height: 25px; }
            .basic_info div select { width: 150px; height: 30px; }
            .basic_info div select option { font-size: 20px; margin: auto; }
            .register_inputbox { width: 30%; }
            .register_inputbox_email { width: 10%; }
            .register_button { width: 70%; margin: 0; display: flex; justify-content: right; align-items: center; }
            #register_button { width: 100px; margin: 10px 30px 0 0; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script> <!-- 없으면 jQuery 작돟X -->
        <script type="text/javascript">
            $(document).ready(function() {
                $("input[name='gyunggido']").attr('disabled', true);
                $("input[name='useremail_url']").attr('value', 'naver.com');
                $("input[name='useremail_url']").attr('disabled', true);
                // 경기도 주소 선택시 이벤트
                $("#register_juso").change(function() {
                    var option = $("#register_juso option:selected").val();
                    if(option == "gyunggido"){
                        $("input[name='gyunggido']").attr("disabled", false);
                        return false;
                    }else{
                        $("input[name='gyunggido'][value='']").prop('checked', true);
                        $("input[name='gyunggido']").attr('disabled',true);
                        return false;
                    }
                });
                // 이메일 이벤트
                $("#useremail_url").change(function() {
                    var option = $("#useremail_url option:selected").val();
                    switch(option){
                        case "user_write" : 
                            $("input[name='useremail_url']").attr('disabled',false);
                            $("input[name='useremail_url']").attr('value', '');
                            $("input[name='useremail_url']").focus();
                            break;
                        case "daum" : 
                            $("input[name='useremail_url']").attr('value', 'daum.net');
                            break;
                        case "nate" : 
                            $("input[name='useremail_url']").attr('value', 'nate.com');
                            break;
                        case "gamil" : 
                            $("input[name='useremail_url']").attr('value', 'gamil.com');
                            break;
                        default : 
                            $("input[name='useremail_url']").attr('value', 'naver.com');
                            break;
                    }
                    /*
                    if(option == "user_write"){
                        $("input[name='useremail_url']").attr('disabled',false);
                        $("input[name='useremail_url']").attr('placeholder', "");
                        $("input[name='useremail_url']").focus();
                        return false;
                    }else{
                        $("input[name='useremail_url']").attr('disabled',true);
                        return false;
                    }
                    */
                });
                // 비밀번호 확인 이벤트
                $("input[name='userpwok']").change(function() {
                    var userpw = $("input[name='userpw']").val();
                    var userpwok = $("input[name='userpwok']").val();
                    if(userpw != userpwok){
                        alert ("비밀번호를 확인해 주세요.");
                        $("input[name='userpwok']").focus();
                        return false;
                    }
                });
                // 필수체크 이벤트
                $("#register_button").click(function() {
                    var userid = $("input[name='userid']").val();
                    var userpw = $("input[name='userpw']").val();
                    var userpwok = $("input[name='userpwok']").val();
                    var username = $("input[name='username']").val();
                    var userage = $("input[name='userage']").val();
                    // var graduate = $("input[name='graduate']").val();
                    var graduate_count = $("input:checkbox[name='graduate[]']:checked").length;
                    var graduate = "";
                    var register_juso = $("#register_juso option:selected").val();
                    var useremail_id = $("input[name='useremail_id']").val();
                    
                    if(userid == ""){
                        alert ("ID를 입력해 주세요.");
                        $("input[name='userid']").focus();
                        return false;
                    }
                    if(userpw == ""){
                        alert ("비밀번호를 입력해 주세요.");
                        $("input[name='userpw']").focus();
                        return false;
                    }
                    if(userpwok == ""){
                        alert ("비밀번호 확인을 입력해 주세요.");
                        $("input[name='userpwok']").focus();
                        return false;
                    }
                    if(userpw != userpwok){
                        alert ("비밀번호를 확인해 주세요.");
                        $("input[name='userpwok']").focus();
                        return false;
                    }
                    if(username == ""){
                        alert ("이름을 입력해 주세요.");
                        $("input[name='username']").focus();
                        return false;
                    }
                    if(userage == ""){
                        alert ("나이를 입력해 주세요.");
                        $("input[name='userage']").focus();
                        return false;
                    }
                    if($(":radio[name='usersex']:checked").length < 1){
                        alert ("성별을 입력해 주세요.");
                        $("input[name='usersex']").focus();
                        return false;
                    }
                    if(graduate_count < 1){
                        alert ("학력을 입력해 주세요.");
                        return false;
                    }
                    
                    $("input:checkbox[name='graduate[]']").each(function() {
                        if($(this).is(":checked") == true){
                            graduate += $(this).val();
                        }
                    });
                    if(graduate.includes('Middle') == true){ //값 비교
                        $("#graduate_e").prop('checked', true); //checked 처리
                    }
                    if(graduate.includes('High') == true){
                        $("#graduate_e").prop('checked', true);
                        $("#graduate_m").prop('checked', true);
                    }
                    if(graduate.includes('Universe') == true){
                        $("#graduate_e").prop('checked', true);
                        $("#graduate_m").prop('checked', true);
                        $("#graduate_h").prop('checked', true);
                    }
                    if(register_juso == "select_juso"){
                        alert ("주소를 입력해 주세요.");
                        $("#register_juso option:selected").focus();
                        return false;
                    }
                    if(register_juso == "gyunggido" && $(":radio[name='gyunggido']:checked").length < 1){
                        alert ("상세주소를 입력해 주세요.");
                        $("#register_juso option:selected").focus();
                        return false;
                    }
                    if(useremail_id == ""){
                        alert ("이메일을 입력해 주세요.");
                        $("input[name='useremail_id']").focus();
                        return false;
                    }
                    $("input[name='gyunggido']").attr('disabled', false);
                    $("input[name='useremail_url']").attr('disabled',false);
                    $("#register_form").submit();
                });
            });
        </script>
    </head>
    <body>
        <section>
        <div class="basic_info">
            <form id="register_form" method="post" action="register_insert.php">
                <div class="register_userid">
                    <label class="register_userid_label">아이디</label>
                    <input type="text" name="userid" class="register_inputbox">
                </div>
                <div class="resgister_userpw">
                    <label class="register_userpw_label">비밀번호</label>
                    <input type="password" name="userpw" class="register_inputbox">
                </div>
                <div class="resgister_userpwok">
                    <label class="register_userpwok_label">비밀번호 확인</label>
                    <input type="password" name="userpwok" class="register_inputbox">
                </div>
                <div class="register_username">
                    <label class="register_username_label">이름</label>
                    <input type="text" name="username" class="register_inputbox">
                </div>
                <div class="register_userage">
                    <label class="register_userage_label">나이</label>
                    <!-- ^ : Not, /g : global 전부 -->
                    <input type="text" id="userage" name="userage" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="3">&nbsp세
                </div>
                <div class="register_usersex">
                    <label class="register_usersex_label">성별</label>
                    <input type="radio" id="usersex_m" name="usersex" value="Male">&nbsp남&nbsp
                    <input type="radio" id="usersex_f" name="usersex" value="Female">&nbsp여
                </div>
                <div class="register_graduate">
                    <label class="register_graduate_label">학력</label>
                    <input type="checkbox" id="graduate_e" name="graduate[]" value="Element">&nbsp초&nbsp
                    <input type="checkbox" id="graduate_m" name="graduate[]" value="Middle">&nbsp중&nbsp
                    <input type="checkbox" id="graduate_h" name="graduate[]" value="High">&nbsp고&nbsp
                    <input type="checkbox" id="graduate_u" name="graduate[]" value="Universe">&nbsp대
                </div>
                <div class="register_useraddress">
                    <label class="register_useraddress_label">주소</label>                  
                    <select id="register_juso" name="register_juso">
                        <option value="select_juso">-지역선택-</option>
                        <option value="seoul">서울</option>
                        <option value="gyunggido">경기</option>
                        <option value="incheon">인천</option>
                        <option value="deajun">대전</option>
                        <option value="sejong">세종</option>
                    </select>
                    &nbsp
                    <input type="radio" id="gyunggido_s" name="gyunggido" value="Sungnam">&nbsp성남&nbsp
                    <input type="radio" id="gyunggido_y" name="gyunggido" value="Yongin">&nbsp용인&nbsp
                    <input type="radio" id="gyunggido_h" name="gyunggido" value="Hwasung">&nbsp화성
                </div>
                <div class="register_useremail">
                    <label class="register_useremail_label">이메일</label>
                    <input type="email" name="useremail_id" class="register_inputbox_email">&nbsp@&nbsp
                    <input type="email" name="useremail_url" class="register_inputbox_email">&nbsp
                    <select id="useremail_url">
                        <option value="naver">naver.com</option>
                        <option value="daum">daum.net</option>
                        <option value="nate">nate.com</option>
                        <option value="gamil">gamil.com</option>
                        <option value="user_write">직접입력</option>
                    </select>
                    </div>
                </div>
                <div class="register_button">
                    <button id="register_button" type="button">가입하기</button>
                </div>
            </form>
        </div>
        </section>
    </body>
</html>            
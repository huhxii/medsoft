<?php
include $_SERVER['DOCUMENT_ROOT'].'/medsoft/dbcon.php';

$userid = $_POST['userid'];
$result = $mysqli->query("select * from test_member where userid = '".$userid."'") or die('select query error => '.$mysqli->error);
if(!$result){
    echo '<script>alert (\'없는 ID 입니다.\');history.back();</script>';
    exit;
}
while($rs = $result->fetch_object()){
    $userid = $rs->userid;
    $userpw = $rs->userpw;
    $userpwok = $rs->userpwok;
    $username = $rs->username;
    $userage = $rs->userage;
    $usersex = $rs->usersex;
    $graduate = $rs->graduate;
    $graduate_array = explode(' || ', $graduate);
    $useraddress = $rs->useraddress;
    $useremail = $rs->useremail;
    $useremail_array = explode('@', $useremail);
    /*
    echo "<pre>";
    print_r ($useraddress_array);
    echo "</pre>";
    exit;
    */
}
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
            .basic_info { width: 80%; margin: auto; padding: 20px; display: flex; flex-direction: column; }
            .basic_info div { width: 100%; display: flex; flex-direction: row; justify-content: flex-start; align-items: center; padding: 0 0 20px 20%; }
            .basic_info div label { width: 200px; }
            .basic_info div input { height: 25px; }
            .basic_info div select { width: 150px; height: 30px; }
            .basic_info div select option { font-size: 20px; margin: auto; }
            .register_view_inputbox { width: 30%; }
            .register_view_inputbox_id { width: 10%; }
            .register_view_inputbox_email { width: 10%; }
            .register_view_button { width: 70%; margin: 0; display: flex; justify-content: right; align-items: center; }
            #register_view_button { width: 100px; margin: 0 30px 0 0; padding: 10px 20px 10px 20px; color: white; background-color: black; border-radius: 15px; }
        </style>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var usersex = $("#get_usersex").val();
                var graduate = $("#get_graduate").val();
                var juso = $("#get_juso").val();
                var email = $("#get_email").val();
                if(usersex == "Male"){
                    $("#usersex_m").prop('checked', true);
                }
                if(usersex == "Female"){
                    $("#usersex_f").prop('checked', true);
                }
                // 주소
                if(juso.includes(' || ') == true){
                    var useraddress_array = juso.split(' || ');
                    $("#register_view_juso").val(useraddress_array[0]).prop("selected", true);
                    switch(useraddress_array[1]){
                        case "Sungnam":
                            $("#gyunggido_s").attr("checked", true);
                            break;
                        case "Yongin":
                            $("#gyunggido_y").attr("checked", true);
                            break;
                        case "Hwasung":
                            $("#gyunggido_h").attr("checked", true);
                            break;
                    }
                }else{
                    $("#register_view_juso").val(juso).prop("selected", true);
                    $("input:radio[name='gyunggido']").attr("disabled", true);
                }
                if(email.includes('.') == true){
                    var email_array = email.split('.');
                    switch(email_array[0]){
                        case "naver":
                            $("#useremail_url").val("naver").prop("selected", true);
                            break;
                        case "daum":
                            $("#useremail_url").val("daum").prop("selected", true);
                            break;
                        case "nate":
                            $("#useremail_url").val("nate").prop("selected", true);
                            break;
                        case "gamil":
                            $("#useremail_url").val("gamil").prop("selected", true);
                            break;
                        default :
                            $("#useremail_url").val("user_write").prop("selected", true);
                            break;
                    }
                }
            });
        </script>
    </head>
    <body>
        <section>
        <div class="basic_info">
            <form id="register_view_form" method="post" action="register_view_insert.php">
                <div class="register_view_userid">
                    <label class="register_view_userid_label">아이디</label>
                    <input type="text" name="userid" class="register_view_inputbox_id" value="<?php echo $userid;?>">
                </div>
                <div class="resgister_userpw">
                    <label class="register_view_userpw_label">비밀번호</label>
                    <input type="password" name="userpw" class="register_view_inputbox">
                </div>
                <div class="resgister_userpwok">
                    <label class="register_view_userpwok_label">비밀번호 확인</label>
                    <input type="password" name="userpwok" class="register_view_inputbox">
                </div>
                <div class="register_view_username">
                    <label class="register_view_username_label">이름</label>
                    <input type="text" name="username" class="register_view_inputbox" value="<?php echo $username;?>">
                </div>
                <div class="register_view_userage">
                    <label class="register_view_userage_label">나이</label>
                    <input type="text" id="userage" name="userage" onKeyup="this.value=this.value.replace(/[^0-9]/g,'');" maxlength="3" value="<?php echo $userage;?>">&nbsp세
                </div>
                <div class="register_view_usersex">
                    <label class="register_view_usersex_label">성별</label>
                    <input type="hidden" id="get_usersex" value="<?php echo $usersex;?>">
                    <input type="radio" id="usersex_m" name="usersex" value="Male">&nbsp남&nbsp
                    <input type="radio" id="usersex_f" name="usersex" value="Female">&nbsp여
                </div>
                <div class="register_view_graduate">
                    <label class="register_view_graduate_label">학력</label>
                    <!-- 삼항연산자, in_array(확인 값, 배열)?'True 일때':'False 일때' -->
                    <input type="checkbox" id="graduate_e" name="graduate[]" <?php echo in_array('Element', $graduate_array)?'checked':'';?>>&nbsp초&nbsp
                    <input type="checkbox" id="graduate_m" name="graduate[]" <?php echo in_array('Middle', $graduate_array)?'checked':'';?>>&nbsp중&nbsp
                    <input type="checkbox" id="graduate_h" name="graduate[]" <?php echo in_array('High', $graduate_array)?'checked':'';?>>&nbsp고&nbsp
                    <input type="checkbox" id="graduate_u" name="graduate[]" <?php echo in_array('Universe', $graduate_array)?'checked':'';?>>&nbsp대
                </div>
                <div class="register_view_useraddress">
                    <label class="register_view_useraddress_label">주소</label>    
                    <input type="hidden" id="get_juso" value="<?php echo $useraddress;?>">              
                    <select id="register_view_juso" name="register_view_juso">
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
                <div class="register_view_useremail">
                    <label class="register_view_useremail_label">이메일</label>
                    <input type="email" name="useremail_id" class="register_view_inputbox_email" value="<?php echo $useremail_array[0];?>">&nbsp@&nbsp
                    <input type="email" name="useremail_url" class="register_view_inputbox_email" value="<?php echo $useremail_array[1];?>">&nbsp
                    <input type="hidden" id="get_email" value="<?php echo $useremail_array[1];?>"> 
                    <select id="useremail_url">
                        <option value="naver">naver.com</option>
                        <option value="daum">daum.net</option>
                        <option value="nate">nate.com</option>
                        <option value="gamil">gamil.com</option>
                        <option value="user_write">직접입력</option>
                    </select>
                    </div>
                </div>
                <div class="register_view_button">
                    <button id="register_view_button" type="button">목록</button>
                </div>
            </form>
        </div>
        </section>
    </body>
</html>            
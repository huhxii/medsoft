<?php
    /* 230602
    *게시글 순서 DB순으로 : board_index.php
    *조회수 : board_view.php (form 태그 전체적 수정)
    *php '', "" 처리
    *제목,내용 맨 앞에 ' 가 들어가면 오류가 남 >> 해결할 것 : board_insert.php
    *jQuery 필수체크 : board_write.php
    *delete 수정 : board_index.php
    *php.ini > <?php?> php 생략 가능하게 만듦 : C:\xampp\php\php.ini > magic_quotes_gpc
    *첨부파일 다운로드 가능하게 바꿀것 >> 1개만 받아짐, 2개부터는 글도 2개 등록되고 따로 받아야 함
    -데이터베이스 만들고 > 데이터베이스에 접속 가능한 사용자(admin) 권한 : mysql workbench 사용자 권한 설정
    >> lost connection to mysql server at reading initial communication packet 오류
    */

    /* 230605
    *클릭 이벤트는 id로
    *등록(가입)폼에 나이(max 3자리, 숫자만), 성별(라디오 박스), 학력(초, 중, 고, 대 / 체크 박스)
    -주소(셀렉트 박스 3~5개), 상세주소(주소 경기도 선택시 라디오 버튼으로 성남, 용인, 화성 : 활성화 / 경기도 아닐때 비활성화) > 전부 필수 jQuery & DB저장
    */

    /* 230612
    *password() 함수 사용 / 복호화 : register_insert.php
    *checkbox >> 배열 each로 loop 접근 가능 : register_index.php
    *다중 파일 첨부 : 파일 다수일 경우 해결방법 : board_write.php, board_insert.php
    *조인 종류 : 게시글, 파일 : mysql_workbench > unique, foreign key
    *addslashes 사용해서 쿼리문 바꾸기
    -gyunggido 빈 라디오 없애기 >> DB alter : 유지 
    */

    /* 230626
    *password() 함수 사용 : mysql 8.0부터 삭제 > function hjm_pass()생성
    *php 체크박스(foreach) 배열로 넘기는 방법 > || 추가해서 > 상세보기 들어가면 다시 체크되게
    *insert 중복은 후문을 update로 처리
    -mysql last_insert id : 배열에서 안받아짐 찾아봐야함
    */
    
    /* 230627
    *상세보기는 비밀번호 빼기
    *체크박스 필수체크
    */

    /* 230628
    *삼항연산자, in_array이용 : register_view.php
    *loop > 변경할것 : register_index.php
    *주소 / 라디오 : register_view.php
    *E-mail : register_view.php
    */

    /* 230703
    input box 보이게 할것 : *board_write.php, board_modify.php
    hidden 안쓰고 하기 : register_index.php, register_view.php(주소부분)
    */

    /*
    파일 등록시 > 중간에 넣는 경우 해결 > loop 돌려서 해결(다른 방식 : foreach)
    addslashes : 230626 php > 참고.txt
    훗날 : 로그인, 마이페이지, 관리자 > 목록 보기 가능, 회원목록
    수정 : 1. 파일 새로 업로드시 기존파일 삭제 2. 이미지 파일은 보이게 > 클릭시 새창에서 확인 3. 다운로드 기능
    */

    /*
    Study
    *전역변수, 지역변수 (230607)
    *배열 찍는법 : foreach, for문 카운트 (230607)
    *typescript (230607)
    *var, let, const (230607)
    *varchar(10) 10글자일때 20바이트, 10숫자, 영문일때 10바이트 (230612)
    배열과 loop
    동기화, 비동기화
    DOM(트리구조), this(현재 접근 되어 있는곳)
    훗날 : DB책 
    */
?>
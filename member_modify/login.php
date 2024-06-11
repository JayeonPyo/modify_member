<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "spider2";
$dbname = "WHITESPIDER";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function filter_input_data($data) {
    // 공백과 # 문자 필터링
    $data = str_replace(' ', '', $data);
    $data = str_replace('#', '', $data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = filter_input_data($conn->real_escape_string($_POST['username']));
    $pass = filter_input_data($conn->real_escape_string($_POST['password']));

    // 취약한 SQL 쿼리 (Blind SQL 인젝션 실습용)
    $query = "SELECT * FROM MEMBER WHERE id = '$user' AND password = '$pass'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['ses_id'] = $user;
        header("Location: index.php");
        exit();
    } else {
        echo "<script>alert('Invalid username or password.');window.location.href='login.php';</script>";
    }
}

$conn->close();

$g_title = "로그인!";
$js_array = ['js/login.js'];
$menu_code = 'login';

include 'inc_header.php';
?>
<main class="mx-auto border rounded-5 p-5 d-flex gap-5" style="height: calc(100vh - 257px)">
    <form method="post" class="w-25 mt-5 m-auto" action="">
        <img src="./images/icon.svg" width="72" alt="">
        <h1 class="h3 mb-3">로그인</h1>
        <div class="form-floating mt-2">
            <input type="text" class="form-control" id="f_id" name="username" placeholder="아이디 입력" autocomplete="off">
            <label for="f_id">아이디</label>
        </div> 
        <div class="form-floating mt-2">
            <input type="password" class="form-control" id="f_pw" name="password" placeholder="비밀번호 입력">
            <label for="f_pw">비밀번호</label>
        </div> 
        <button class="w-100 mt-2 btn btn-lg btn-primary" id="btn_login" type="submit">확인</button>
    </form>
</main>

<?php
include 'inc_footer.php';
?>

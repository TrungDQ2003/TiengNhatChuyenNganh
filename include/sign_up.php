<?php
// Kết nối đến cơ sở dữ liệu MySQL
$host = 'localhost';
$db = 'kanji_memory_master'; // tên database của bạn
$user = 'root'; // tên người dùng MySQL của bạn
$password = ''; // mật khẩu MySQL của bạn

// Tạo kết nối
$conn = new mysqli($host, $user, $password, $db);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra nếu dữ liệu đã được gửi từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ form
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $gender = $_POST['gender'];
    $birthdate = $_POST['birthdate'];

    // Hash password trước khi lưu vào database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Tạo câu lệnh SQL để chèn dữ liệu vào bảng user
    $sql = "INSERT INTO user (username, password, email, gender, date_of_birth) 
            VALUES ('$username', '$hashed_password', '$email', '$gender', '$birthdate')";

    if ($conn->query($sql) === TRUE) {
        echo "Đăng ký thành công!";
        // Có thể chuyển hướng đến trang đăng nhập
        // header("Location: sign_in.html");
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

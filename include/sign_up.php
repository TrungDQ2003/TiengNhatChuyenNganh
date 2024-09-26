<?php
// Kết nối đến cơ sở dữ liệu MySQL
$host = 'localhost';
$db = 'kanji_memory_master'; // tên database của bạn
$user = 'root'; // tên người dùng MySQL của bạn
$password = ''; // mật khẩu MySQL của bạn

// Tạo kết nối
$conn = new mysqli($host, $user, $password, $db, 3307);

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
    $date_of_birth = $_POST['date_of_birth'];

    // Hash password trước khi lưu vào database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Tạo câu lệnh SQL để chèn dữ liệu vào bảng user
    $sql = "INSERT INTO user (username, password, email, gender, date_of_birth) 
            VALUES ('$username', '$hashed_password', '$email', '$gender', '$date_of_birth')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng đến trang đăng nhập
        header("Location: ../index.html"); // Đường dẫn tương đối đến trang đăng nhập
        exit(); // Dừng thực thi script sau khi chuyển hướng
    } else {
        echo "Lỗi: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

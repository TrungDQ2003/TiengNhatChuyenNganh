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

    // Kiểm tra email đã tồn tại chưa
    $sql_check_email = "SELECT * FROM user WHERE email='$email'";
    $result_check_email = $conn->query($sql_check_email);

    if ($result_check_email->num_rows > 0) {
        // Email đã tồn tại, quay lại trang đăng ký với thông báo lỗi
        header("Location: ../sign_up.html?error=email_exists");
        exit();
    } else {
        // Tạo câu lệnh SQL để chèn dữ liệu vào bảng user
        $sql = "INSERT INTO user (username, password, email, gender, date_of_birth) 
                VALUES ('$username', '$hashed_password', '$email', '$gender', '$date_of_birth')";

        if ($conn->query($sql) === TRUE) {
            // Đăng ký thành công, chuyển hướng lại trang sign_up.html với thông báo
            header("Location: ../sign_up.html?success=registration_complete");
            exit(); // Dừng thực thi script sau khi chuyển hướng
        } else {
            echo "Lỗi: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

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

    // Truy vấn kiểm tra email trong cơ sở dữ liệu
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy thông tin người dùng từ kết quả truy vấn
        $user = $result->fetch_assoc();
        
        // Kiểm tra mật khẩu (so sánh mật khẩu nhập vào với mật khẩu đã hash)
        if (password_verify($password, $user['password'])) {
            echo "Đăng nhập thành công!";
            // Chuyển hướng đến trang khác, ví dụ: dashboard.php
            // header("Location: dashboard.php");
        } else {
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Email không tồn tại!";
    }

    $conn->close();
}
?>

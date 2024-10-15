<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "honda_parts";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            echo "تم تسجيل الدخول بنجاح!";
        } else {
            echo "كلمة المرور غير صحيحة!";
        }
    } else {
        echo "المستخدم غير موجود!";
    }

    $stmt->close();
    $conn->close();
}
?>

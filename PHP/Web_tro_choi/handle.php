<?php
// include/handle.php
function register($firstname, $lastname, $country, $email, $username, $password, $gender) {
    global $conn;

    // Mã hóa mật khẩu
    $hashed_password = md5($password);

    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, country, email, username, password, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $firstname, $lastname, $country, $email, $username, $hashed_password, $gender);

    if ($stmt->execute()) {
        return "Registration successful.";
    } else {
        return "Error: " . $stmt->error;
    }
}

function login($user_input, $password) {
    global $conn;
    // Kiểm tra nếu user_input là email hoặc username
    if (filter_var($user_input, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    } else {
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    }
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, md5($user['password']))) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function logoutUser() {
    session_start();
    session_unset();
    session_destroy();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}
?>

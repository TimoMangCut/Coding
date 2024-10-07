<?php
    session_start();
    include('db.php');
    function login($user_input, $password) {
      global $conn;
      // Kiểm tra nếu user_input là email hoặc username
      if (filter_var($user_input, FILTER_VALIDATE_EMAIL)) {
          $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
      }
      $stmt->bind_param("s", $user_input);
      $stmt->execute();
      $result = $stmt->get_result();
  
      if ($result->num_rows === 1) {
          $user = $result->fetch_assoc();
          if (password_verify(md5($password), $user['password'])) {
              $_SESSION['user_id'] = $user['id'];
              return true;
          } else {
              return false;
          }
      } else {
          return false;
      }
  }
  
  if (isset($_SERVER["REQUEST_METHOD"])&& $_SERVER["REQUEST_METHOD"] == "POST") {
      $user_email = $_POST['username'];
      $password = $_POST['password'];
  
      if (login($user_email, $password)) {
          echo "Đăng nhập thành công!";
          header("Location:index.php");
         // exit();
      } else {
          echo "Đăng nhập thất bại!";
      }
  }
?>
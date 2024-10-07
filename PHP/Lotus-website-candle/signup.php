<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'otus - Signup</title>
    <!-- <link rel="stylesheet" href="path/to/your/css/styles.css"> -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <style>
        body {
            background-image: url('/var/www/html/Lotus/images/pexels.jpg');
            /* background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0; */
        }
        .form_wrapper {
            max-width: 500px;
            margin: auto;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .form_container {
            padding: 20px;
        }
        .title_container h2 {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body style="background-image: url('images/pexels.jpg');">
<div class="form_wrapper">
    <div class="form_container">
        <div class="title_container">
            <h2>Đăng Ký</h2>
        </div>
        <div class="row clearfix">
            <div class="">
                <form method="POST" action="register.php">
                <?php
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']); // Xóa thông báo lỗi sau khi hiển thị
                }
                ?>
                    <div class="input_field"> 
                        <span><i aria-hidden="true" class="fa fa-envelope"></i></span>
                        <input type="email" name="email" placeholder="Email" required />
                    </div>
                    <div class="input_field"> 
                        <span><i aria-hidden="true" class="fa fa-lock"></i></span>
                        <input type="password" name="password" placeholder="Password" required />
                    </div>
                    <div class="input_field"> 
                        <span><i aria-hidden="true" class="fa fa-lock"></i></span>
                        <input type="password" name="confirm_password" placeholder="Re-type Password" required />
                    </div>
                    <div class="row clearfix">
                        <div class="col_half">
                            <div class="input_field"> 
                                <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                <input type="text" name="first_name" placeholder="First Name" />
                            </div>
                        </div>
                        <div class="col_half">
                            <div class="input_field"> 
                                <span><i aria-hidden="true" class="fa fa-user"></i></span>
                                <input type="text" name="last_name" placeholder="Last Name" required />
                            </div>
                        </div>
                    </div>
                    <div class="input_field radio_option">
                        <input type="radio" name="gender" id="rd1" value="Male">
                        <label for="rd1">Male</label>
                        <input type="radio" name="gender" id="rd2" value="Female">
                        <label for="rd2">Female</label>
                    </div>
                    <div class="input_field select_option">
                        <select name="country">
                            <option value="">Select a country</option>
                            <option value="Viet Nam">Viet Nam</option>
                            <option value="VN">VN</option>
                        </select>
                        <div class="select_arrow"></div>
                    </div>
                    <div class="input_field checkbox_option">
                        <input type="checkbox" id="cb1" name="terms">
                        <label for="cb1">I agree with terms and conditions</label>
                    </div>
                    <div class="input_field checkbox_option">
                        <input type="checkbox" id="cb2" name="newsletter">
                        <label for="cb2">I want to receive the newsletter</label>
                    </div>
                    <input class="button" type="submit" value="Register" />
                </form>
            </div>
        </div>
    </div>
</div>
<p class="credit">Login Now ? <a href="signin.php">Signin</a></p>
<link href="./login_files/signup.css" rel="stylesheet">
</body>
</html>

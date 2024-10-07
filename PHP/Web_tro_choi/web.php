<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.php"); 
    exit();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$username = $_SESSION["username"];
$getInfo = $conn->query("SELECT username, so_tien from username where username = '$username';");
if ($getInfo->num_rows > 0) {
    $row = $getInfo->fetch_assoc();
    $account = $row["so_tien"];
    $loichao = "Chao mung ".$_SESSION["username"]." den voi trang web ca cuoc so 1 Chau Au cua chung toi! so du cua ban la ". $account . " VND<br>";
    $canh_bao = "Hanh vi ca do, ca cuoc duoi moi hinh thuc la bat hop phap!";
}
?>
<html>
    <body>
        <h3>
            <center>
            <?php
                if (isset($loichao)){
                    echo $loichao. "<br>";
                }
            ?> <mark>
            <?php 
                if (isset($canh_bao)) {
                    echo $canh_bao;
                }
            ?> </mark>
            </center>
        </h3>
        <center>
            <img src = "xocdia.png" width="200" height="250">
        </center>
        <form method ='POST'>
        <p><?php 
            if(isset($account)&& isset($username)){
                echo "username : ". $username . "<br>";
                echo "So du: ".$account. " VND<br>";
            }       
        ?></p>
        <input type="radio" name = "tai" value = "tai">
        <label for="tai">Tai</label>
        <input type="radio" name = "xiu" value = "xiu">
        <label for="xiu">Xiu</label>
        <label for="so_tien">So tien cuoc :</label>
        <input type="int" name="so_tien" required><br>
        <button type = "submit">Cuoc</button>
    </form>

</body>
</html>
  <?php  function countdown($seconds){
        while(true){
        for ($i = $seconds;$i>0;$i--){
        echo $i. ",";
        sleep(1);
        ob_flush();
        flush();
        }
        echo "Hết giờ<br>";
        ob_flush();
        flush();
        sleep(2);
        $xx1 = rand(1,6);
        $xx2 = rand(1,6);
        $xx3 = rand(1,6);
        // sleep(2);
        // echo $xx1. ' '. $xx2. ' '. $xx3 .'<br>';
        if($xx1 == 1){
            echo '<img src = nut1.jpg width="50" height="50">';
        }
        elseif ($xx1 == 2){
            echo '<img src = nut2.jpg width="50" height="50">';
        }
        elseif ($xx1 == 3) {
            echo '<img src = nut3.jpg width="50" height="50">';
        }
        elseif ($xx1 == 4) {
            echo '<img src = nut4.jpg width="50" height="50">';
        }

        elseif ($xx1 == 5) {
            echo '<img src = nut5.jpg width="50" height="50">';
        }
        else {
            echo '<img src = nut6.png width="50" height="50">';
        }

            if($xx2 == 1){
            echo '<img src = nut1.jpg width="50" height="50">';
        }
            elseif ($xx2 == 2){
            echo '<img src = nut2.jpg width="50" height="50">';
        }
            elseif ($xx2 == 3) {
            echo '<img src = nut3.jpg width="50" height="50">';
        }
            elseif ($xx2 == 4) {
            echo '<img src = nut4.jpg width="50" height="50">';
        }

            elseif ($xx2 == 5) {
            echo '<img src = nut5.jpg width="50" height="50">';
        }
            else {
            echo '<img src = nut6.png width="50" height="50">';
        }

                if($xx3 == 1){
            echo '<img src = nut1.jpg width="50" height="50"><br>';
        }
                elseif ($xx3 == 2){
            echo '<img src = nut2.jpg width="50" height="50"><br>';
        }
                elseif ($xx3 == 3) {
            echo '<img src = nut3.jpg width="50" height="50"><br>';
        }
                elseif ($xx3 == 4) {
            echo '<img src = nut4.jpg width="50" height="50"><br>';
        }

                elseif ($xx13 == 5) {
            echo '<img src = nut5.jpg width="50" height="50"><br>';
        }
                else {
            echo '<img src = nut6.png width="50" height="50"><br>'; 
        }
        $sum = $xx1 + $xx2 + $xx3;
        if (($sum) <= 10) {
            $sum = 0;
            echo "Xiu !<br>";
        }
        else {
            $sum = 1;
            echo "Tai !<br>";
        }
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
            $sotien = $_POST["so_tien"];
            global $account;
            if (isset($_POST["tai"]) && isset($_POST["so_tien"])){
                if ($sum == 1) {
                    $account = $account + $sotien;
                }
                elseif($sum == 0) {
                    $account = $account - $sotien;
                }
            }
            elseif(isset($_POST["xiu"]) && isset($_POST["so_tien"])){
                if ($sum == 1) {
                    $account = $account - $sotien;
                }
                elseif($sum == 0){
                    $account = $account + $sotien;
                }
            }
            else {
                continue;
            }
        }
            unset($_POST);

            global $conn;
            global $username;
            $account == $conn->query("UPDATE username SET so_tien = $account WHERE username = '$username';");
            // if ($account === true) {
            //     echo "Cap nhat vi tien thanh cong, so du moi cua ban la :" .$account. "VND<br>";
            // }
        echo  "so du moi cua ban la : " .$account. " VND<br>";
        var_dump($account);
        ob_flush();
        flush();
        sleep(1);

    }
}
    countdown(5);

?>


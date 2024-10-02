<?php
session_start();
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch address information from the database
$address = [
    'city' => '',
    'district' => '',
    'ward' => '',
    'house_number' => ''
];

$stmt = $conn->prepare("SELECT * FROM addresses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $address = $result->fetch_assoc();
}

// Fetch phone number
$user_info = $conn->prepare("SELECT phone_number FROM users WHERE id = ?");
$user_info->bind_param("i", $user_id);
$user_info->execute();
$user_result = $user_info->get_result();
$user_data = $user_result->fetch_assoc();
$phone_number = $user_data['phone_number'] ?? '';

// Update address and phone number
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['city'], $_POST['district'], $_POST['ward'], $_POST['house_number'], $_POST['phone_number'])) {
        $city = $_POST['city'];
        $district = $_POST['district'];
        $ward = $_POST['ward'];
        $house_number = $_POST['house_number'];
        $phone_number = $_POST['phone_number'];

        if ($result->num_rows > 0) {
            // Update address
            $stmt = $conn->prepare("UPDATE addresses SET city = ?, district = ?, ward = ?, house_number = ? WHERE user_id = ?");
            $stmt->bind_param("ssssi", $city, $district, $ward, $house_number, $user_id);
        } else {
            // Insert new address
            $stmt = $conn->prepare("INSERT INTO addresses (user_id, city, district, ward, house_number) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("issss", $user_id, $city, $district, $ward, $house_number);
        }
        $stmt->execute();

        // Update phone number
        $stmt = $conn->prepare("UPDATE users SET phone_number = ? WHERE id = ?");
        $stmt->bind_param("si", $phone_number, $user_id);
        $stmt->execute();

        header("Location: pay.php");
        exit();
    }
}

// Calculate total price from the cart
$totalPrice = 0;
$result = $conn->query("SELECT product_id, quantity, size FROM cart WHERE user_id = $user_id");
while ($row = $result->fetch_assoc()) {
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $size = $row['size'];
    $stmt = $conn->prepare("SELECT price_".$size. " FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $product_result = $stmt->get_result();
    $product = $product_result->fetch_assoc();
    $totalPrice += $product['price_'.$size] * $quantity;
}

// Default shipping cost
$shipping_cost = 0;
$result = $conn->query("SELECT shipping FROM users WHERE id = $user_id");
if ($row = $result->fetch_assoc()) {
    $shipping_cost = $row['shipping'];
} else {
    $shipping_cost = 0; // Default shipping cost if not found
}
$totalPrice = $totalPrice + $shipping_cost;

$final_price = $totalPrice;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2>Review Login Information</h2>
                <form method="POST">
                    <div class="mb-3">
                        <label for="city" class="form-label">City/Province</label>
                        <input type="text" class="form-control" id="city" name="city" value="<?php echo $address['city']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="district" class="form-label">District</label>
                        <input type="text" class="form-control" id="district" name="district" value="<?php echo $address['district']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="ward" class="form-label">Ward</label>
                        <input type="text" class="form-control" id="ward" name="ward" value="<?php echo $address['ward']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="house_number" class="form-label">Specific Address</label>
                        <input type="text" class="form-control" id="house_number" name="house_number" value="<?php echo $address['house_number']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Information</button>
                </form>
            </div>
            <div class="col-md-6 text-center">
                <h2>Payment Method - QR pay</h2>
                <?php
                    $result = $conn->query("SELECT product_id, quantity FROM cart WHERE user_id = $user_id");
                    while ($row = $result->fetch_assoc()) {
                        echo '<input type="hidden" name="product_ids[]" value="' . $row['product_id'] . '">';
                        echo '<input type="hidden" name="quantities[]" value="' . $row['quantity'] . '">';
                    }
                ?>
                <img src="https://api.vietqr.io/image/970436-phucduuu-rAaIT80.jpg?accountName=DO%20NGUYEN%20PHUC" class="img-fluid mb-3" alt="QR Code">
                <h2>Total Amount: <?php echo number_format($final_price); ?> VND</h2>
                <div>
                    <button class="btn btn-secondary me-2" onclick="window.location.href = 'cart.php';">Cancel</button>
                    <button class="btn btn-success" onclick="completeOrder();">Complete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    function completeOrder() {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'admin.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert('Order successfully placed!');
                window.location.href = 'index.php';
            } else if (xhr.readyState === 4) {
                alert('Error occurred: ' + xhr.status);
            }
        };

        var product_ids = document.querySelectorAll('input[name="product_ids[]"]');
        var quantities = document.querySelectorAll('input[name="quantities[]"]');

        var product_ids_values = [];
        var quantities_values = [];

        product_ids.forEach(function(input) {
            product_ids_values.push(input.value);
        });

        quantities.forEach(function(input) {
            quantities_values.push(input.value);
        });

        var data = 'user_id=<?php echo $user_id; ?>&total_cost=<?php echo $final_price; ?>';
        product_ids_values.forEach(function(value, index) {
            data += '&product_id[]=' + encodeURIComponent(value);
            data += '&quantities[]=' + encodeURIComponent(quantities_values[index]);
        });

        console.log(data); // Debug: Check data before sending
        xhr.send(data);
    }
</script>

</body>
</html>

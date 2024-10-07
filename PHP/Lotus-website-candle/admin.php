<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] !== 5) {
    header("Location: login_admin.php");
}
include 'db.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Fetch statistics
$query = "SELECT visitors, start_time FROM statistics WHERE id = 1";
$result = $conn->query($query);
$statistics = $result->fetch_assoc();

$visitors = $statistics['visitors'];
$start_time = $statistics['start_time'];

// Tính thời gian trung bình
$current_time = time();
$users_query = "SELECT COUNT(*) as user_count FROM users";
$users_result = $conn->query($users_query);
$user_count = $users_result->fetch_assoc()['user_count'];

$average_time = ($current_time - strtotime($start_time)) / 60; // Tính theo phút
$average_time_per_user = ($user_count * 30 * ($current_time - strtotime($start_time)) / 8640) / $visitors; // 5 phút/ngày/người dùng

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = filter_input(INPUT_POST, 'user_id', FILTER_VALIDATE_INT);
    $product_ids = filter_input(INPUT_POST, 'product_id', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $quantities = filter_input(INPUT_POST, 'quantities', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $total_cost = filter_input(INPUT_POST, 'total_cost', FILTER_VALIDATE_FLOAT);

    if ($user_id === null || $user_id === false || $product_ids === null || $quantities === null || $total_cost === null || $total_cost === false) {
        die("Invalid or missing data.");
    }

    // Fetch phone number
    $stmt = $conn->prepare("SELECT phone_number FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user_result = $stmt->get_result();
    $user_data = $user_result->fetch_assoc();
    $phone_number = $user_data['phone_number'] ?? '';

    // Fetch address information
    $stmt = $conn->prepare("SELECT city, district, ward, house_number FROM addresses WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $address_result = $stmt->get_result();
    $address = $address_result->fetch_assoc();

    if (!$address) {
        die("Address not found for user_id: " . htmlspecialchars($user_id));
    }

    // Create a new order
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_cost, status) VALUES (?, ?, 'pending')");
    if ($stmt === false) {
        die("Statement preparation error: " . $conn->error);
    }
    $stmt->bind_param("id", $user_id, $total_cost);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
    if ($stmt === false) {
        die("Statement preparation error: " . $conn->error);
    }

    for ($i = 0; $i < count($product_ids); $i++) {
        $stmt->bind_param("iii", $order_id, $product_ids[$i], $quantities[$i]);
        if (!$stmt->execute()) {
            die("Statement execution error: " . $stmt->error);
        }
    }

    echo "Order successfully created!";
} else {
    echo "";
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-image: url('https://i.pinimg.com/564x/db/cb/cc/dbcbccefbc20aa7a09267c8baf6c0abe.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <center><h1>Admin Page</h1></center>
            </div>
        </div>
        <div class="col">
        <button class="mb-0"><a href="statistics.php" class="text-body">Order statistics</a></button>
        <button class="mb-0"><a href="history_order.php" class="text-body">History Orders</a></button>
        </div>
        
        <br><br>
        <p><strong>Số lượt truy cập trang web :</strong> <?php echo $visitors; ?></p>
        <p><strong>Thời gian trung bình khách hàng xem website:</strong> <?php echo round($average_time_per_user, 2); ?> phút</p>
        
        <h2>Order List</h2>
        <table border="1" class="table table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User ID</th>
                    <th>Total Cost</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>City</th>
                    <th>District</th>
                    <th>Ward</th>
                    <th>House Number</th>
                    <th>Order Date</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                <!-- Orders will be populated here -->
            </tbody>
        </table>
        <div id="orderDetails">
            <!-- Order details will be loaded here -->
        </div>
    </div>

    <!-- Bootstrap JS and dependencies (if needed) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        function fetchOrders() {
            fetch('fetch_orders.php')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('ordersTableBody');
                    tableBody.innerHTML = ''; // Clear existing rows
                    const uniqueOrders = {};
                    data.forEach(order => {
                        // Create a unique key for each order based on all its properties
                        const key = `${order.order_id}_${order.user_id}_${order.total_cost}_${order.city}_${order.district}_${order.ward}_${order.house_number}_${order.order_date}_${order.status}`;
                        
                        if (!uniqueOrders[key]) {
                            uniqueOrders[key] = {
                                order_id: order.order_id,
                                user_id: order.user_id,
                                total_cost: order.total_cost,
                                city: order.city,
                                district: order.district,
                                ward: order.ward,
                                house_number: order.house_number,
                                order_date: order.order_date,
                                phone_number: order.phone_number,
                                status: order.status,
                                products: []
                            };
                        }
                        uniqueOrders[key].products.push({
                            product_id: order.product_id,
                            quantity: order.quantity
                        });
                    });

                    Object.values(uniqueOrders).forEach(order => {
                        const row = document.createElement('tr');
                        row.innerHTML = `<td>${order.order_id}</td>
                                         <td>${order.user_id}</td>
                                         <td>${order.total_cost}</td>
                                         <td>${order.products.map(p => p.product_id).join(', ')}</td>
                                         <td>${order.products.map(p => p.quantity).join(', ')}</td>
                                         <td>${order.city}</td>
                                         <td>${order.district}</td>
                                         <td>${order.ward}</td>
                                         <td>${order.house_number}</td>
                                         <td>${order.order_date}</td>
                                         <td>${order.phone_number}</td>
                                         <td>${order.status}</td>
                                         <td>
                                            <button onclick="updateOrderStatus(${order.order_id}, 'complete')">Complete</button>
                                            <button onclick="updateOrderStatus(${order.order_id}, 'cancel')">Cancel</button>
                                            <button onclick="loadOrderDetails(${order.order_id})">View Details</button>
                                         </td>`;
                        tableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching orders:', error));
        }

        function updateOrderStatus(order_id, status) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_order_status.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            alert('Order status updated successfully!');
            window.location.href = 'admin.php';
            // 'history_order.php?order_id=' + order_id; // Redirect to history_order.php

        } else if (xhr.readyState === 4) {
            alert('Error occurred: ' + xhr.status);
        }
    };
    xhr.send('order_id=' + order_id + '&status=' + status);
}


        function loadOrderDetails(order_id) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'order_details.php?order_id=' + order_id, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById('orderDetails').innerHTML = xhr.responseText;
                } else if (xhr.readyState === 4) {
                    alert('Error occurred: ' + xhr.status);
                }
            };
            xhr.send();
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetchOrders();
            setInterval(fetchOrders, 5000); // Refresh every 5 seconds
        });
    </script>
</body>
</html>

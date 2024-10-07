<?php
include 'db.php';

$order_id = filter_input(INPUT_POST, 'order_id', FILTER_VALIDATE_INT);
$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

if ($order_id === null || $order_id === false || !in_array($status, ['complete', 'cancel'])) {
    die("Invalid data.");
}

// Update the order status
$stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->bind_param("si", $status, $order_id);
$stmt->execute();

// Redirect to history_order.php if status is complete or cancel
if ($status === 'complete' || $status === 'cancel') {
    header("Location: history_order.php");
    exit();
}

$conn->close();
?>

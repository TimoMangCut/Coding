<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
include 'db.php';

$user_id = $_SESSION['user_id'] ?? 0;

// Fetch all products
$products = [];
$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()) {
    $products[$row['id']] = [
        'name' => $row['name'],
        'price_small' => $row['price_small'],
        'price_medium' => $row['price_medium'],
        'price_large' => $row['price_large']
    ];
}

// Function to calculate total price and item count
function calculateTotals($user_id, $products, $conn) {
    $totalPrice = 0;
    $itemCount = 0;
    $result = $conn->query("SELECT product_id, quantity, size FROM cart WHERE user_id = $user_id");
    while ($row = $result->fetch_assoc()) {
        $price = $products[$row['product_id']]['price_' . $row['size']];
        $totalPrice += $price * $row['quantity'];
        $itemCount += $row['quantity'];
    }
    return ['totalPrice' => $totalPrice, 'itemCount' => $itemCount];
}

$total_price = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo json_encode(['product_id' => $_POST['product_id'], 'size' => $_POST['size']]);
    // exit();
    if (isset($_POST['product_id']) && isset($_POST['size'])){
        $product_id = $_POST['product_id'];
        $size = $_POST['size'];

        $stmt = $conn->prepare("UPDATE cart SET size = ? WHERE product_id = ?");
        $stmt->bind_param("si", $size, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // $query = $conn->prepare("SELECT quantity FROM cart WHERE product_id = ? AND user_id = ?");
        // $query->bind_param('ii', $product_id, $user_id);
        // $query->execute();
        // $getQuantity = $query->fetch();
        $totals = calculateTotals($user_id, $products, $conn);
        echo json_encode(['status' => 'success', 'total_price' => $totals['totalPrice'], 'item_count' => $totals['itemCount'], 'size' => $size]);
        exit();
    }

    if (isset($_POST['product_id'])) {
        $product_id = $_POST['product_id'];
        $size = $_POST['size'];

        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows < 1) {
            $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, size) VALUES (?, ?, 1, ?)");
        }
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();

        $totals = calculateTotals($user_id, $products, $conn);

        echo json_encode(['status' => 'success', 'totalPrice' => $totals['totalPrice'], 'itemCount' => $totals['itemCount']]);
        exit();
    }

    

    if (isset($_POST['remove_id'])) {
        // Ensure these variables are defined
        // $conn, $user_id, $products
        
        $remove_id = $_POST['remove_id'];
    
        error_log('Received remove_id: ' . $remove_id); // Log the received data
    
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Database prepare failed']);
            exit();
        }
        $stmt->bind_param("ii", $user_id, $remove_id);
        if (!$stmt->execute()) {
            echo json_encode(['status' => 'error', 'message' => 'Database execute failed']);
            exit();
        }
    
        // Calculate totals assuming calculateTotals is a valid function
        $totals = calculateTotals($user_id, $products, $conn);
    
        echo json_encode(['status' => 'success', 'totalPrice' => $totals['totalPrice'], 'itemCount' => $totals['itemCount']]);
        exit();
    }
    if (isset($_POST['update_id']) && isset($_POST['quantity']) && isset($_POST['size'])) {
        $update_id = $_POST['update_id'];
        $quantity = $_POST['quantity'];
        $size = $_POST['size'];

        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("iiis", $quantity, $user_id, $update_id, $size);
        $stmt->execute();
        $totals = calculateTotals($user_id, $products, $conn);
        echo json_encode(['status' => 'success', 'totalPrice' => $totals['totalPrice'], 'itemCount' => $totals['itemCount']]);
        exit();
    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'concaaaa']);
        exit();
    }

    if (isset($_POST['ship_price'])) {
        $ship_price = $_POST['ship_price'];
        $user_id1 = $_SESSION['user_id'];
        $stmt = $conn->prepare("UPDATE users SET shipping = ? WHERE id = ?");
        $stmt->bind_param("ii", $ship_price, $user_id1);
        $stmt->execute();
        $stmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Shipping price updated']);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Bag</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    
</head>

<body>
    <section class="h-100 h-custom" style="background-color: #d2c9ff;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0 text-black">Shopping Cart</h1>
                                            <h6 class="mb-0 text-muted" id="item_count">
                                                <?php
                                                $itemCount = 0;
                                                $result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
                                                while ($row = $result->fetch_assoc()) {
                                                    $itemCount += $row['quantity'];
                                                }
                                                echo $itemCount . " items";
                                                ?>
                                            </h6>
                                        </div>
                                        <hr class="my-4">

                                        <?php
                                        $result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
                                        while ($row = $result->fetch_assoc()) {
                                            $product_id = $row['product_id'];
                                            $quantity = $row['quantity'];
                                            $size = $row['size'];
                                            $product = $products[$product_id];
                                            $price = $product['price_' . $size];
                                            $total_price += $price * $quantity;
                                        ?>
                                            <div class="row mb-4 d-flex justify-content-between align-items-center" data-item-id="<?php echo $product_id; ?>">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <img src="images/nenthom<?php echo $product_id; ?>.png" class="img-fluid rounded-3" alt="<?php echo $product['name']; ?>">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <h6 class="text-muted"><?php echo $product['name']; ?></h6>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                                    <input onchange="updateQuantity(this)" id="quantity_<?php echo $product_id;?>_<?php echo $size; ?>" min="1" name="quantity" value="<?php echo $quantity; ?>" type="number" class="form-control form-control-sm"  />
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                    <h6 class="mb-0" id="price_<?php echo $product_id;?>_<?php echo $size; ?>" data-price="<?php echo $price; ?>"><?php echo number_format($price * $quantity); ?> VND</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-2">
                                                    <select id="size_<?php echo $product_id; ?>" data-current-size="<?php echo $size ?>" class="form-select size-select" data-current-size="<?php echo $size; ?>" data-product-id="<?php echo $product_id; ?>" onchange="updateSize(this)">
                                                        <option value="small" <?php if ($size === 'small') echo 'selected'; ?>>Small</option>
                                                        <option value="medium" <?php if ($size === 'medium') echo 'selected'; ?>>Medium</option>
                                                        <option value="large" <?php if ($size === 'large') echo 'selected'; ?>>Large</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <button href="#!" class="btn btn-danger" onclick="removeProduct(<?php echo $product_id; ?>)"><i class="fas fa-times"></i>Xóa</button>
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                        <?php } ?>

                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="index.php" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-grey">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase">items <?php echo $itemCount; ?></h5>
                                            <h5 id="item_count_summary"><?php echo $itemCount; ?></h5>
                                        </div>

                                        <h5 class="text-uppercase mb-3">Shipping</h5>

                                        <div class="mb-4 pb-2">
                                            <select class="select p-2 bg-grey" id="shipping_method" onchange="updateShipping(this)">
                                                <option value="0">Standard-Delivery- 0 VND</option>
                                                <option value="30000">Registered-Delivery- 30,000 VND</option>
                                                <option value="50000">Express-Delivery- 50,000 VND</option>
                                            </select>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            <h5 id="total_price"><?php echo number_format($total_price); ?> VND</h5>
                                        </div>

                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Final price</h5>
                                            <h5 id="final_price"><?php echo number_format($total_price); ?> VND</h5>
                                        </div>
                                        
                                        <button type="button" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark" onclick="window.location.href = 'pay.php';">Order Now</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function addToCart(productId) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
                        alert('Sản phẩm đã được thêm vào giỏ hàng.');
                        document.getElementById('total_price').innerText = priceFormatter(response.totalPrice) + ' VND';
                        document.getElementById('final_price').innerText = priceFormatter(response.totalPrice + parseInt(document.getElementById('shipping_method').value)) + ' VND';
                        document.getElementById('item_count').innerText = response.itemCount + ' items';
                        document.getElementById('item_count_summary').innerText = response.itemCount;
                    } else {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                }
                else {
                    alert('Có lỗi xảy ra.');
                }
            };
            xhr.send('product_id=' + productId, '&size=small');
        }

        function updateSize(select) {
            const itemId = select.getAttribute('data-product-id');
            const size = select.value;
            // console.log(itemId);
            // console.log(size);
            const currentSize = select.getAttribute('data-current-size');
            const quantityInput = document.getElementById(`quantity_${itemId}_${currentSize}`);
            console.log(quantityInput);
            const quantity = quantityInput ? quantityInput.value : 1;
            const xhr = new XMLHttpRequest();

            xhr.open("POST", "cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    const response = JSON.parse(this.responseText);
                    console.log(this.responseText);
                    if (response.status === 'success') {
                        document.getElementById('item_count_summary').innerText = response.item_count + ' items';
                        document.getElementById('total_price').innerText = response.total_price.toLocaleString() + ' VND';
                        document.getElementById('final_price').innerText = response.total_price.toLocaleString() + ' VND';
                        const currentItemPrice = document.getElementById(`price_${itemId}_${currentSize}`);
                        if (response.size == 'small') {
                            currentItemPrice.innerText = `${70000 * quantityInput.value} VND`;
                        }
                        if (response.size == 'medium') {
                            currentItemPrice.innerText = `${150000* quantityInput.value} VND`;
                        }
                        if (response.size == 'large') {
                            currentItemPrice.innerText = `${250000 * quantityInput.value} VND`;
                        }
                        currentItemPrice.setAttribute('id', `price_${itemId}_${response.size}`);
                        location.reload();
                    }
                }
            }
            xhr.send(`product_id=${itemId}&size=${size}`);
        }

        function updateQuantity(input) {
            const amount = Number(input.value);
            const productId = input.getAttribute('id').split('_')[1];
            const sizeSelect = document.getElementById(`size_${productId}`); // Assuming you have a select element for size in each row
            const size = sizeSelect.value;                              
            const productPrice = Number(document.getElementById(`price_${productId}_${size}`).getAttribute('data-price'));
            console.log(size);
            console.log(productPrice);                                                      
            if (amount < 1) {
                alert('Số lượng không thể nhỏ hơn 1.');
                input.value = 1;
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'cart.php', true);
            xhr.onreadystatechange = function() {
                if (this.readyState === 4 && this.status === 200) {
                    var response = JSON.parse(this.responseText);
                    if (response.status === 'success') {
                        const updatedPrice = productPrice * amount; // Calculate new price based on quantity
                        document.getElementById(`price_${productId}_${size}`).textContent = priceFormatter(updatedPrice) + ' VND'; // Update displayed price
                        updateCartSummary(response.totalPrice, response.itemCount); // Update cart summary based on server response
                    } else {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                }
            }
            const formData = new FormData();
            formData.append('update_id', productId);
            formData.append('quantity', amount);
            formData.append('size', size);
            xhr.send(formData);
        }

        function priceFormatter(number) {
            return number.toLocaleString();
        }

        function updateCartSummary(totalPrice, itemCount) {
            document.getElementById('total_price').innerText = priceFormatter(totalPrice) + ' VND';
            document.getElementById('final_price').innerText = priceFormatter(totalPrice + parseInt(document.getElementById('shipping_method').value)) + ' VND';
            document.getElementById('item_count').innerText = itemCount + ' items';
            document.getElementById('item_count_summary').innerText = itemCount;
        }

        function removeProduct(productId) {
    var xhr = new XMLHttpRequest();
    const formData = new FormData();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    var productRow = document.querySelector("[data-item-id='" + productId + "']");
                    if (productRow) {
                        productRow.parentNode.removeChild(productRow);
                        updateCartSummary(response.totalPrice, response.itemCount);
                    }
                } else {
                    alert('An error occurred. Please try again.');
                }
            } else {
                alert('An error occurred. Please try again.');
            }
        }
    };
    formData.append('remove_id', productId);
    console.log('Sending remove_id:', productId); // Log the data being sent
    xhr.open('POST', 'cart.php', true);
    xhr.send(formData);
}


        function updateShipping() {
            var ship_price = parseInt(document.getElementById('shipping_method').value);
            var totalPrice = parseInt(document.getElementById('total_price').innerText.replace(/\D/g, ''));
            document.getElementById('final_price').innerText = priceFormatter(totalPrice + ship_price) + ' VND';
            
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(this.responseText);
                    alert('Đã cập nhật thành công phí ship');
                }
            }
            xhr.open("POST", 'solve.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('ship_price=' + encodeURIComponent(ship_price));
        }
    </script>
</body>


</html>

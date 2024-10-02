<?php
include 'db.php';

// Fetch completed orders percentage
$query = "SELECT COUNT(*) AS total_orders FROM orders";
$result = $conn->query($query);
$total_orders = $result->fetch_assoc()['total_orders'];

$query = "SELECT COUNT(*) AS completed_orders FROM orders WHERE status = 'complete'";
$result = $conn->query($query);
$completed_orders = $result->fetch_assoc()['completed_orders'];

$completed_orders_percentage = $total_orders > 0 ? ($completed_orders / $total_orders) * 100 : 0;

// Fetch total users
$query = "SELECT COUNT(*) AS total_users FROM users";
$result = $conn->query($query);
$total_users = $result->fetch_assoc()['total_users'];

// Fetch best seller
$query = "SELECT products.name, SUM(order_items.quantity) AS total_quantity 
          FROM order_items 
          JOIN products ON order_items.product_id = products.id 
          GROUP BY order_items.product_id 
          ORDER BY total_quantity DESC 
          LIMIT 1";
$result = $conn->query($query);
$best_seller = $result->fetch_assoc()['name'];

// Fetch total orders
$query = "SELECT COUNT(*) AS total_orders FROM orders";
$result = $conn->query($query);
$total_orders = $result->fetch_assoc()['total_orders'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.3.1/css/all.min.css" rel="stylesheet">
    <link href="statistics.css" rel="stylesheet">
</head>
<body class="bg-default">
  <div class="main-content">
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <h2 class="mb-5 text-white">Statistics</h2>
        <div class="header-body">
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Completed Orders</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo number_format($completed_orders_percentage, 2); ?>%</span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-check-circle"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-success mr-2"><i class="fa fa-arrow-up"></i></span>
                    <span class="text-nowrap">Completed Orders Percentage</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Users</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_users; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">Total Number of User Accounts</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Best Seller</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $best_seller; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                        <i class="fas fa-trophy"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">Most Bought Product</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 class="card-title text-uppercase text-muted mb-0">Total Orders</h5>
                      <span class="h2 font-weight-bold mb-0"><?php echo $total_orders; ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                        <i class="fas fa-receipt"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span class="text-nowrap">Total Number of Orders</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
  </div>
  <footer class="footer">
    <div class="row align-items-center justify-content-xl-between">
      <div class="col-xl-6 m-auto text-center">
        <div class="copyright">
          <p>Result Statistics Of Lotus Candle</p>
        </div>
        <p class="mb-0"><a href="admin.php" class="text-body">Back to Admin-Page</a></p>
      </div>
    </div>
  </footer>
</body>
</html>

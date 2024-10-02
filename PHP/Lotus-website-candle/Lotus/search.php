<?php
require_once 'db.php'; // Kết nối cơ sở dữ liệu

// Lấy từ khóa tìm kiếm
$search_query = isset($_GET['query']) ? $_GET['query'] : '';

$products = [];
if ($search_query) {
    // Truy vấn cơ sở dữ liệu để lấy các sản phẩm phù hợp
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $like_query = "%" . $search_query . "%";
    $stmt->bind_param("ss", $like_query, $like_query);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tìm Kiếm Sản Phẩm</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,700&display=swap&subset=latin-ext" rel="stylesheet">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <style>
        body {
            background-image: url('https://i.pinimg.com/564x/db/cb/cc/dbcbccefbc20aa7a09267c8baf6c0abe.jpg');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <!-- header section start -->
    <div class="header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
                <div id="mySidenav" class="sidenav">
                    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                    <a href="index.php">Trang Chủ</a>
                    <a href="products.html">Sản Phẩm</a>
                    <a href="about.html">About</a>
                    <a href="client.html">Client</a>
                    <a href="contact.html">Liên Hệ</a>
                </div>
                <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
                <a class="logo" href="index.php"><img src="images/logo1.png"></a>
                <form class="form-inline" action="search.php" method="get">
                    <div class="input-group search-bar" id="search-bar" data-seeable="true">
                        <input type="search" name="query" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon">
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>
                <div class="login_text">
                    <ul>
                        <li><a href="profile.php"><img src="images/user-icon.png"></a></li>
                        <li><a href="cart.php"><img src="images/bag-icon.png"></a></li>
                        <li><a href="#"><img src="images/search-icon.png"></a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!-- header section end -->

    <!-- search results section start -->
    <div class="product_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="product_taital">Kết Quả Tìm Kiếm</h1>
                    <p class="product_text"><?php echo htmlspecialchars($search_query); ?></p>
                </div>
            </div>
            <div class="product_section_2 layout_padding">
                <div class="row">
                    <?php if (!empty($products)) : ?>
                        <?php foreach ($products as $product) : ?>
                            <div class="col-lg-3 col-sm-6">
                                <div class="product_box">
                                    <h4 class="bursh_text"><?php echo htmlspecialchars($product['name']); ?></h4>
                                    <p class="lorem_text"><?php echo htmlspecialchars($product['description']); ?></p>
                                    <img src="images/nenthom<?php echo htmlspecialchars($product['id']); ?>.png" class="image_1">
                                    <div class="btn_main">
                                        <div class="buy_bt">
                                            <ul>
                                                <li class="active">
                                                    <a href="#" class="buy_now_btn" data-id="<?php echo htmlspecialchars($product['id']); ?>" onclick="addToCart(event)">Buy Now</a>
                                                </li>
                                                <li><a href="products.php?id=<?php echo htmlspecialchars($product['id']); ?>">Details</a></li>
                                            </ul>
                                        </div>
                                        <h3 class="price_text">Just <?php echo htmlspecialchars($product['price_small']); ?> VND</h3>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>Không tìm thấy sản phẩm nào phù hợp với từ khóa của bạn.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- search results section end -->

    <!-- footer section start -->
    <div class="footer_section layout_padding">
        <div class="container">
            <div class="footer_logo"><a href="index.php"><img src="images/Logo_nenthom.png"></a></div>
            <div class="contact_section_2">
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="address_text">Contact Us</h3>
                        <div class="address_bt">
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i><span class="padding_left10">Address : FPT University Da Nang</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-phone" aria-hidden="true"></i><span class="padding_left10">Call : +84 779959016</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="fa fa-envelope" aria-hidden="true"></i><span class="padding_left10">Email : lotus_candles_shop@gmail.com</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="footer_logo_1"><a href="index.php"><img src="images/Logo_nenthom.png"></a></div>
                        <p class="dummy_text">L'otus Candle, sản phẩm của chúng tôi, chính là một bí mật. Nó không chỉ là một viên nến thơm thông thường. Khi thắp lên, những tia sáng nhỏ bắt đầu tỏa sáng, và cánh hoa nến mở ra như những bông hoa tinh khiết, xoa dịu tâm hồn chúng ta.</p>
                    </div>
                    <div class="col-sm-4">
                        <div class="main">
                            <h3 class="address_text">Best Products</h3>
                            <p class="ipsum_text">Lemon Co<br>Dalat Blossom<br>Minty Pine Breeze</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social_icon">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/profile.php?id=61555248526883" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/odayconenthom/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- footer section end -->

    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <!-- javascript -->
    <script src="js/owl.carousel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        // function addToCart(event) {
        //     event.preventDefault();
        //     const productId = event.target.dataset.id;
        //     // Code to add the product to the cart using productId
        // }
    </script>
          <script>
        function addToCart(event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
        
            var productId = event.target.getAttribute('data-id');
           const formData = new FormData();
            // Tạo yêu cầu AJAX
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status === 'success') {
        
                        alert('Sản phẩm đã được thêm vào giỏ hàng');
                        // Tính toán lại tổng số tiền
                        updateCartSummary(response.totalPrice, response.itemCount);
                    } else {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                }
            };
            formData.append('product_id', productId);
           //  formData.append('size', 'small');
            xhr.open('POST', 'cart.php', true);
            xhr.send(formData);
        } 
        </script>
</body>

</html>

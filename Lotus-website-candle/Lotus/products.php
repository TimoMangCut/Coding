<?php
include 'db.php'; // Kết nối đến database


// Lấy ID sản phẩm từ URL
$product_id = isset($_GET['id']) ? $_GET['id'] : 0;

$product = null;
if ($product_id) {
    // Truy vấn cơ sở dữ liệu để lấy thông tin chi tiết sản phẩm
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi Tiết Sản Phẩm</title>
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
        .banner_img {
            width: 100%;
            height: 500px; /* Adjust as needed */
            position: relative;
            overflow: hidden;
            border-radius: 20px; /* Rounded corners */
        }
        .banner_img img {
            width: 100%;
            height: auto;
            object-fit: cover; /* Ensure the image covers the container */
        }
        .banner_img:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Dark overlay */
            border-radius: 20px; /* Same as the image border radius */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5); /* Shadow effect */
            pointer-events: none; /* Allow interaction with underlying elements */
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
                        <li><a href="cart.php"><img height="25px" width="25px" src="images/bag.png"></a></li>
                        <li><a href="#"><img src="images/search-icon.png"></a></li>
                    </ul>
                </div>
                <br>
            </nav>
        </div>
    </div>
    <!-- header section end -->

    <!-- product details section start -->
    <div class="product_section layout_padding">
        <div class="container">
            <?php if ($product) : ?>
                <div class="row">
                    <div class="col-lg-6 col-sm-12">
                        <div class="banner_img">
                            <img src="images/nenthom<?php echo htmlspecialchars($product['id']); ?>.png" alt="<?php echo htmlspecialchars($product['name']); ?>" class="img-fluid">
                        </div>
                        <div class="text-center mt-4">
                            <h1 class="">Price: </h1>
                            <h2 class="" style="color: #fefefd; padding-top: 5px;">Small-<?php echo htmlspecialchars($product['price_small']); ?> VND</h2>
                            <h2 class="" style="color: #fefefd; padding-top: 5px;">Medium-<?php echo htmlspecialchars($product['price_medium']); ?> VND</h2>
                            <h2 class="" style="color: #fefefd; padding-top: 5px;">Large-<?php echo htmlspecialchars($product['price_large']); ?> VND</h2>
                            <div class="buy_bt mt-3">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" style="float: none; font-size: 19px;" data-id="<?php echo htmlspecialchars($product['id']); ?>" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-12">
                        <div class="product_detail_content">
                            <h1 class="product_name text-center" style="font-size: 50px; font-style: italic;"><strong><?php echo htmlspecialchars($product['name']); ?></strong></h1>
                            <p class="description_text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="des_text"><?php echo nl2br(htmlspecialchars($product['des'])); ?></p>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <p>Không tìm thấy sản phẩm này.</p>
            <?php endif; ?>
        </div>
    </div>
    <!-- product details section end -->

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

<?php
// Đóng kết nối
$conn->close();
?>

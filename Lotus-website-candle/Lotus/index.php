<?php 
  include "db.php";
    // Tăng số lượng truy cập
    $update_visitors = "UPDATE statistics SET visitors = visitors + 1 WHERE id = 1";
    $conn->query($update_visitors);
    $conn->close();
   if (!isset($_SESSION)) {
      session_start();
  }

   if (isset($_SESSION['success'])) {
       echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
       unset($_SESSION['success']); // Xóa thông báo sau khi hiển thị
   }
   if (isset($_SESSION['logout_success'])) {
      echo '<div class="alert alert-success" role="alert">' . $_SESSION['logout_success'] . '</div>';
      unset($_SESSION['logout_success']); // Xóa thông báo sau khi hiển thị
  }

?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>L'OTUS - Nến thơm số 1 FPT</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="products.css"> <!-- Link to your CSS file -->
    <!-- Bootstrap CSS -->
      <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <style>
        body {
            background-image: url('https://i.pinimg.com/564x/db/cb/cc/dbcbccefbc20aa7a09267c8baf6c0abe.jpg');
            background-size: cover;
            background-position: center;
        }
        .banner_taital {
            font-family: 'Roboto', sans-serif; /* Chọn font chữ Roboto */
            font-size: 3rem; /* Điều chỉnh kích thước font nếu cần */
            color: #000000; /* Chỉnh màu chữ nếu cần */
        }
        .banner_section {
            position: relative;
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
               <a class="logo" href="index.php"><img src="images/logo1.png"></a></a>
               <form class="form-inline ">
                  <div class="login_text">
                     <ul>
                        <li><a href="./profile.php"><img src="images/user-icon.png"></a></li>
                        <li><a href="cart.php"><img height="25px" width="25px" src="images/bag.png"></a></li>
                        <li><a href="#" id="search-icon"><img src="images/search-icon.png" alt="Search"></a></li>
                     </ul>
                  </div>
               </form>
               <div class="input-group search-bar" id="search-bar" data-seeable="true">
    <form action="search.php" method="GET" class="form-inline w-100">
        <input type="search" name="query" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon">
        <button type="submit" class="btn btn-outline-primary">Search</button>
    </form>
</div>

            </nav>
         </div>
      </div>
               
      <!-- header section end -->
      <!-- banner section start -->
      <div class="banner_section layout_padding">
         <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
               <div class="carousel-item active">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">L'OTUS <br>Candles</h1>
                           <p class="banner_text">Lemon Co - Mang đến hương chanh và dừa dịu nhẹ, nến thơm Lemon Co tạo không gian tươi mát và thư giãn ngay tại nhà.</p>
                           <div class="read_bt"><a href="products.php?id=1">Xem ngay</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/nenthom1.png"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">L'OTUS <br>Candles</h1>
                           <p class="banner_text">Lavender Woods Tranquility - Kết hợp hương lavender, gỗ và trà xanh, Lavender Woods Tranquility giúp bạn thư thái và cảm nhận sự tĩnh lặng tuyệt đối.</p>
                           <div class="read_bt"><a href="products.php?id=2">Xem ngay</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/nenthom2.png"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">L'OTUS <br>Candles</h1>
                           <p class="banner_text">Minty Pine Breeze - Tinh dầu bạc hà và hương thông tươi mát của Minty Pine Breeze sẽ làm mới không gian sống của bạn.</p>
                           <div class="read_bt"><a href="products.php?id=3">Xem ngay</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/nenthom3.png"></div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="container">
                     <div class="row">
                        <div class="col-sm-6">
                           <h1 class="banner_taital">L'OTUS <br>Candles</h1>
                           <p class="banner_text">Dalat Blossom - Hương Anh Đào, hoa Sen và Oải Hương, Dalat Blossom đem lại không gian ngát hương và thanh khiết.</p>
                           <div class="read_bt"><a href="products.php?id=8">Xem ngay</a></div>
                        </div>
                        <div class="col-sm-6">
                           <div class="banner_img"><img src="images/nenthom8.png"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- banner section end -->
      <!-- product section start -->
      <div class="product_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="product_taital">Sản Phẩm của chúng tôi</h1>
                <p class="product_text">L'otus tự hào mang đến nến thơm handmade organic với hương thơm đa tầng độc đáo. Được làm từ nguyên liệu thiên nhiên tinh khiết, mỗi ngọn nến của chúng tôi không chỉ an toàn và thân thiện với môi trường mà còn mang đến trải nghiệm mùi hương thú vị, lan tỏa từng lớp hương tinh tế. Khám phá sự độc đáo và sang trọng từ L'otus, để không gian sống của bạn luôn ngập tràn cảm hứng.</p>
            </div>
        </div>
        <div class="product_section_2 layout_padding">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Lemon Co</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp hai mùi hương dừa và chanh xanh</p>
                        <img src="images/nenthom1.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="1" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=1">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <!-- Các sản phẩm khác ở đây -->
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Lavender Woods Tranquility</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp ba mùi hương lavender, gỗ và trà xanh</p>
                        <img src="images/nenthom2.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="2" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=2">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Minty Pine Breeze</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp hai mùi hương bạc hà và thông</p>
                        <img src="images/nenthom3.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="3" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=3">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Lemon Frost Delight</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp hai mùi hương chanh xanh</p>
                        <img src="images/nenthom4.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="4" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=4">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
               <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Green Tea Burst</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp hai mùi hương trà xanh và xả</p>
                        <img src="images/nenthom5.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="5" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=5">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Orange Apple Delight</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp hai mùi hương táo và cam</p>
                        <img src="images/nenthom6.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="6" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=6">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Lavender Icy Pine</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp ba mùi hương lavender, thông</p>
                        <img src="images/nenthom7.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="7" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=7">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Dalat Blossom</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp ba mùi hương Anh Đào, hoa Sen, Oải Hương</p>
                        <img src="images/nenthom8.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="8" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=8">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
               <div class="row">
               <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Ginger Saffron Spice</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp ba mùi hương gừng, saffron, đinh lăng</p>
                        <img src="images/nenthom9.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="9" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=9">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Lotus Amber Glow</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp hai mùi hương hổ phách và hương hoa sen</p>
                        <img src="images/nenthom10.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="10" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=10">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Minty Apple Melon</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp ba mùi hương táo, bạc hà, và dưa hấu</p>
                        <img src="images/nenthom11.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="#" class="buy_now_btn" data-id="11" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=11">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="product_box">
                        <h4 class="bursh_text">Lily Violet Blossom</h4>
                        <p class="lorem_text">Nến thơm organic L'otus kết hợp ba mùi hương lily, hoa hồng, violet</p>
                        <img src="images/nenthom12.png" class="image_1">
                        <div class="btn_main">
                            <div class="buy_bt">
                                <ul>
                                    <li class="active">
                                        <a href="https://www.facebook.com/profile.php?id=61555248526883" target="_blank" class="buy_now_btn" data-id="12" onclick="addToCart(event)">Buy Now</a>
                                    </li>
                                    <li><a href="products.php?id=12">Details</a></li>
                                </ul>
                            </div>
                            <h3 class="price_text">Just 70.000 VND</h3>
                        </div>
                    </div>
                </div>
               <div class="seemore_bt"><a href="https://www.facebook.com/profile.php?id=61555248526883" target="_blank">See More on Facebook</a></div>
            </div>
         </div>
      </div>
            </div>
        </div>
    </div>
</div>

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

function removeProduct(productId) {
    // Tạo yêu cầu AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'cart.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.status === 'success') {
                var productRow = document.querySelector("[data-item-id='" + productId + "']");
                if (productRow) {
                    productRow.parentNode.removeChild(productRow);
                    updateCartSummary(response.totalPrice, response.itemCount);
                }
            }
        }
    };
    xhr.send("remove_id=" + productId);
}

function updateQuantity(productId, delta) {
    var quantityInput = document.getElementById('quantity_' + productId);
    var newQuantity = parseInt(quantityInput.value) + delta;
    if (newQuantity >= 0) {
        quantityInput.value = newQuantity;

        // Tạo yêu cầu AJAX để cập nhật số lượng
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'cart.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    updateCartSummary(response.totalPrice, response.itemCount);
                }
            }
        };
        xhr.send("update_id=" + productId + "&quantity=" + newQuantity);
    }
}

// function updateCartSummary(totalPrice, itemCount) {
//     document.getElementById('total_price').innerText = totalPrice.toLocaleString() + ' VND';
//     document.getElementById('final_price').innerText = (totalPrice + 15000).toLocaleString() + ' VND';
//     document.querySelector('.mb-0.text-muted').innerText = itemCount + ' items';
// }
</script>





                  
      <!-- product section end -->
      <!-- about section start -->
      <div class="about_section layout_padding">
         <div class="container">
            <div class="about_section_main">
               <div class="row">
                  <div class="col-md-6">
                     <div class="about_taital_main">
                        <h1 class="about_taital">L'OTUS CANDLES</h1>
                        <p class="about_text">Chúng tôi là một cửa hàng chuyên kinh doanh nến thơm hand-made, với sự tỉ mỉ và đam mê trong từng sản phẩm. Nến thơm của chúng tôi được tạo ra từ nguồn nguyên liệu chính là đậu nành, đảm bảo an toàn và thân thiện với môi trường. Mỗi chiếc nến thơm đều được thiết kế với hai tầng hương độc đáo, tạo nên không gian thơm lâng lâng và ấm áp cho không gian của bạn. Chúng tôi cam kết mang lại cho khách hàng những sản phẩm chất lượng nhất, đem lại không chỉ một cảm giác thư giãn mà còn là trải nghiệm thăng hoa cho các giác quan của bạn.</p>
                        <div class="readmore_bt"><a href="https://www.facebook.com/profile.php?id=61555248526883" target="_blank">Read More</a></div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div><img src="images/nenthom_structure.png" class="image_3"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about section end -->
      <!-- customer section start -->
      <div class="customer_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <h1 class="customer_taital">Feedback</h1>
               </div>
            </div>
            <div id="main_slider" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <div class="client_section_2">
                        <div class="client_main">
                           <div class="client_left">
                              <div class="client_img"><img src="images/customer1.png"></div>
                           </div>
                           <div class="client_right">
                              <h3 class="name_text">Cao Xuân Thiện</h3>
                              <p class="dolor_text">"Nến thơm mang lại không gian thoải mái và thư giãn. Giao hàng nhanh, đóng gói cẩn thận. Giá cả hợp lý, phù hợp với chất lượng sản phẩm. Sẽ tiếp tục ủng hộ."</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="client_section_2">
                        <div class="client_main">
                           <div class="client_left">
                              <div class="client_img"><img src="images/customer2.png"></div>
                           </div>
                           <div class="client_right">
                              <h3 class="name_text">Trần Thanh Điềm</h3>
                              <p class="dolor_text">"Mình rất thích mùi hương của nến, thật sự rất dễ chịu và thư giãn. Giao hàng nhanh và đúng hẹn. Chất lượng tốt nhưng giá cả có thể cân nhắc hợp lý hơn."</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="carousel-item">
                     <div class="client_section_2">
                        <div class="client_main">
                           <div class="client_left">
                              <div class="client_img"><img src="images/customer3.png"></div>
                           </div>
                           <div class="client_right">
                              <h3 class="name_text">Ngô Đức Quyền</h3>
                              <p class="dolor_text">"Sản phẩm nến thơm rất tuyệt vời, mùi hương dịu nhẹ và kéo dài. Dịch vụ giao hàng nhanh chóng, đúng giờ. Giá cả hợp lý, phù hợp với chất lượng. Rất hài lòng."</p>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
               <i class="fa fa-angle-left"></i>
               </a>
               <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
               <i class="fa fa-angle-right"></i>
               </a>
            </div>
         </div>
      </div>
      <!-- customer section end -->
      <!-- contact section start -->
      <div class="contact_section layout_padding">
         <div class="container">
            <div class="row">
               <div class="col-md-6">
                  <h1 class="contact_taital">Contact</h1>
                  <p class="contact_text">Chúng tôi rất mong được kết nối và hợp tác với bạn! Vui lòng liên hệ với chúng tôi qua email, Facebook, hoặc Instagram. Chúng tôi luôn sẵn lòng lắng nghe và hỗ trợ bạn.</p>
               </div>
               <div class="col-md-6">
               <div class="contact_main">
                     <div class="contact_bt"><a href="https://www.facebook.com/profile.php?id=61555248526883" target="_blank">To Facebook</a></div>
                     <div class="newletter_bt"><a href="https://www.instagram.com/odayconenthom/" target="_blank">To Instagram</a></div>
                  </div>
               </div>
            </div>
         </div>
         <div class="map_main">
            <div class="map-responsive">
               <iframe src="https://www.google.com/maps/embed/v1/place?key=AIzaSyA0s1a7phLN0iaD6-UE7m4qP-z21pH0eSc&amp;q=FPT-University-DaNang-VietNam" width="600" height="400" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
            </div>
         </div>
      </div>
      <!-- contact section end -->
      <!-- footer section start -->
      <div class="footer_section layout_padding">
         <div class="container">
            <div class="footer_logo"><a href="index.php"><img src="images/footer-logo.png"></a></div>
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
                        <p class="ipsum_text">Lemon Co<br>Dalat Blossom<br>  Minty Pine Breeze</p>
                     </div>
                  </div>
               </div>
            </div>
            <div class="social_icon">
               <ul>
                  <li>
                     <a href="https://www.facebook.com/profile.php?id=61555248526883" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                  <!-- <li>
                     <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                  </li> -->
                  <li>
                     <a href="https://www.instagram.com/odayconenthom/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <!-- footer section end -->
      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">L'otus Candles - Since 2024</p>
         </div>
      </div>
      <!-- copyright section end -->
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
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "100%";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
   </body>
</html>
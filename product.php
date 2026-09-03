<?php
include('inc/function.php');
/** @var mysqli $con */
if (isset($_GET["product"]) == true) {
  if (check_product($con, $_GET["product"]) == true) {
    $product_id = mysqli_fetch_array($con->query("select * from product WHERE slug='" . $_GET["product"] . "'"));
    $product = get_product($con, $product_id['id']);
    $get_gallery = get_gallery($con, $product[0]['id']);
    $get_color = get_color($con, $product[0]['id']);
    $get_reviews = get_product_reviews($con, $product[0]['id']);
    $disc = cal_percentage($product[0]['price'], $product[0]['mrp']);

    // Collect images
    $images = array();
    if (!empty($product[0]['image'])) {
      $img_url = $product[0]['image'];
      if (strpos($img_url, 'http') === 0) {
        $images[] = str_replace(' ', '%20', $img_url);
      } else {
        $images[] = PRODUCT_PATH . str_replace(' ', '%20', $img_url);
      }
    }
    foreach ($get_gallery as $g) {
      if (!empty($g['product_images'])) {
        $img_url = $g['product_images'];
        if (strpos($img_url, 'http') === 0) {
          $images[] = str_replace(' ', '%20', $img_url);
        } else {
          $images[] = PRODUCT_PATH . str_replace(' ', '%20', $img_url);
        }
      }
    }

    // Fallback: If no direct product gallery images, use the first color variant's gallery
    if (empty($get_gallery) && !empty($get_color) && !empty($get_color[0]['gallery_images'])) {
      foreach ($get_color[0]['gallery_images'] as $img_url) {
        if (!in_array($img_url, $images)) {
          $images[] = $img_url;
        }
      }
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <script>
        var MAIN_URL = "<?php echo SITE_PATH; ?>";
      </script>
      <meta charset="utf-8" />
      <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
      <title><?php echo htmlspecialchars($product[0]['name']); ?></title>
      <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
      <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
      <link href="/assets/css/product.css" rel="stylesheet" />
    </head>

    <body>
      <div class="fk-page-loader" id="fkPageLoader">
        <div class="fk-loader-spinner">
          <img alt="Loading" src="/images/fliplpogo.png" />
        </div>
      </div>
      <div class="header">
        <a class="header-icon" href="/">
          <svg class="svg-icon" style="fill:none; stroke:currentColor; stroke-width:2; stroke-linecap:round; stroke-linejoin:round;" viewbox="0 0 24 24">
            <line x1="19" x2="5" y1="12" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
          </svg>
        </a>
        <div class="search-bar">
          <svg aria-hidden="true" class="header-search-icon" viewbox="0 0 24 24">
            <circle cx="11" cy="11" r="8"></circle>
            <line x1="21" x2="16.65" y1="21" y2="16.65"></line>
          </svg>
          <input placeholder="Search for products" type="text" />
        </div>
        <button aria-label="Continue to address" class="cart-wrapper" form="productPurchaseForm" name="buy" type="submit" value="1">
          <svg aria-hidden="true" class="svg-icon" height="506" viewbox="0 0 493 506" width="493" xmlns="http://www.w3.org/2000/svg">
            <path d="M37 39h33c8 0 14 5 16 13l50 290h214M108 104h307l-23 146c-2 11-11 18-22 18H136M196 382a38 38 0 1 1-76 0 38 38 0 1 1 76 0m197 0a38 38 0 1 1-76 0 38 38 0 1 1 76 0" fill="none" stroke="#394247" stroke-linecap="round" stroke-linejoin="round" stroke-width="26"></path>
          </svg>
        </button>
      </div>
      <div class="ad-carousel-wrapper">
        <div class="ad-carousel" id="adCarousel">
          <?php $ad_products = get_product($con);
          if (is_array($ad_products)) {
            shuffle($ad_products);
            $ad_products = array_slice($ad_products, 0, 5);
          } else {
            $ad_products = [];
          }
          foreach ($ad_products as $ad): ?>
            <a class="ad-banner" href="/product?product=<?php echo htmlspecialchars($ad['slug']); ?>">
              <div class="ad-img-box">
                <img alt="Ad Image" src="<?php echo strpos($ad['image'], 'http') === 0 ? str_replace(' ', '%20', $ad['image']) : PRODUCT_PATH . str_replace(' ', '%20', $ad['image']); ?>" loading="lazy" />
              </div>
              <div class="ad-info">
                <div class="ad-title"><?php echo htmlspecialchars($ad['name']); ?></div>
                <div class="ad-pricing">
                  <span class="ad-discount">↓<?php echo cal_percentage($ad['price'], $ad['mrp']); ?>%</span> <span class="ad-mrp">₹<?php echo number_format($ad['mrp'], 0, '.', ','); ?></span> <span class="ad-price">₹<?php echo number_format($ad['price'], 0, '.', ','); ?></span>
                </div>
              </div>
              <div class="ad-badge">AD</div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <div aria-label="Sale countdown" class="sale-timer-section">
        <div class="sale-timer-card" data-duration-seconds="7200" id="saleCountdown">
          <span class="sale-timer-label">sale ends in</span>
          <span class="sale-time-box" id="saleHours">02</span>
          <span class="sale-time-unit">Hrs</span>
          <span class="sale-time-separator">:</span>
          <span class="sale-time-box" id="saleMinutes">00</span>
          <span class="sale-time-unit">Min</span>
          <span class="sale-time-separator">:</span>
          <span class="sale-time-box" id="saleSeconds">00</span>
          <span class="sale-time-unit">Sec</span>
        </div>
      </div>
      <div class="image-slider fk-gallery-card">
        <div class="fk-gallery-stage">
          <div class="fk-side-actions">
            <button aria-label="Wishlist" class="fk-side-btn" id="wishlistBtn" type="button">
              <img alt="" src="/images/heart.png" />
            </button>
            <button aria-label="Share" class="fk-side-btn" id="shareBtn" onclick="shareProduct()" type="button">
              <img alt="" src="/images/arrow.png" />
            </button>
          </div>
          <div aria-label="<?php echo number_format($product[0]['rating'], 1); ?> rating and <?php echo number_format($product[0]['reviews']); ?> reviews" class="fk-rating-badge">
            <span class="fk-rating-value">
              <?php echo number_format($product[0]['rating'], 1); ?> <span class="fk-rating-star">★</span>
            </span>
            <span class="fk-rating-count">| <?php echo $product[0]['reviews'] >= 1000 ? round($product[0]['reviews'] / 1000, 1) . 'k+' : $product[0]['reviews']; ?></span>
          </div>
          <div class="slider-track" id="sliderTrack">
            <?php foreach ($images as $img): ?>
              <div class="slide-img-wrap"><img src="<?php echo $img; ?>" /></div>
            <?php endforeach; ?>
          </div>
          <div class="dots-container" id="sliderDots">
            <?php foreach ($images as $idx => $img): ?>
              <div class="dot <?php echo $idx === 0 ? 'active' : ''; ?>" data-slide="<?php echo $idx; ?>"></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <section class="fk-info-card">
        <script>
          window.colorVariantsData = <?php echo json_encode($get_color); ?>;
        </script>
        <?php
        if (!empty($get_color) && count($get_color) > 0):
          $active_color_name = isset($get_color[0]['color']) ? $get_color[0]['color'] : '';
        ?>
          <div class="fk-selected-line">
            <span class="label">Selected Color:</span>
            <span class="value" id="activeColorText"><?php echo htmlspecialchars($active_color_name); ?></span>
          </div>
          <div class="fk-color-row">
            <?php foreach ($get_color as $idx => $color):
            ?>
              <a aria-label="Select <?php echo htmlspecialchars($color['color']); ?>" class="fk-color-thumb <?php echo $idx === 0 ? 'active' : ''; ?>" data-color-idx="<?php echo $idx; ?>" href="javascript:void(0);" title="<?php echo htmlspecialchars($color['color']); ?>">
                <img alt="<?php echo htmlspecialchars($color['color']); ?>" src="<?php echo strpos($color['product_images'], 'http') === 0 ? str_replace(' ', '%20', $color['product_images']) : PRODUCT_PATH . str_replace(' ', '%20', $color['product_images']); ?>" />
              </a>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>


        <div class="fk-title-wrap expandable-text product-title" data-lines="2">
          <span class="expandable-content"><?php echo htmlspecialchars($product[0]['name']); ?></span>
        </div>
        <div class="fk-price-line">
          <span class="off">
            <svg aria-hidden="true" class="discount-icon" fill="none" viewbox="0 0 24 24">
              <path d="M12 3.2V14.1" stroke="currentColor" stroke-linecap="round" stroke-width="3.2"></path>
              <path d="M6.9 9.5L12 14.9L17.1 9.5" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3.2"></path>
            </svg>
            <span class="discount-value"><?php echo $disc; ?>%</span>
          </span>
          <span class="pd-mrp">₹<?php echo number_format($product[0]['mrp'], 0, '.', ','); ?></span>
          <span class="pd-price">₹<?php echo number_format($product[0]['price'], 0, '.', ','); ?></span>
        </div>
        <div class="fk-protect-fee">+₹40 Protect Promise Fee <span class="fee-arrow">></span></div>
      </section>
      <div class="fk-wow-card is-collapsed" id="wowDealCard">
        <div class="fk-wow-topbar">
          <div class="fk-wow-top-left">
            <img alt="WOW Deal" class="fk-wow-logo" src="/images/wowdeal.png" />
            <div class="fk-wow-top-text">Buy at <strong>₹<?php echo number_format($product[0]['price'], 0, '.', ','); ?></strong></div>
          </div>
          <button aria-disabled="true" aria-expanded="false" aria-label="WOW deal is collapsed" class="fk-wow-toggle" type="button">
            <svg aria-hidden="true" fill="none" viewbox="0 0 24 24">
              <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.4"></path>
            </svg>
          </button>
        </div>
        <div class="fk-wow-body">
          <div class="fk-wow-buyline">Apply offers for maximum savings</div>
        </div>
      </div>
      <div class="fk-emi-card">
        <span>Apply for Card, EMI and Pay Later</span>
      </div>
      <div class="fk-delivery-card">
        <div class="fk-delivery-title">Delivery details</div>
        <div class="fk-delivery-stack">
          <button class="fk-delivery-row fk-delivery-row-location" form="productPurchaseForm" name="buy" type="submit" value="1">
            <img alt="" class="fk-delivery-icon" src="/images/location.png" />
            <div class="fk-delivery-content fk-delivery-inline">
              <span class="fk-delivery-home-label">HOME</span>
              <span class="fk-delivery-location-text">Select delivery address</span>
            </div>
            <svg aria-hidden="true" class="fk-delivery-arrow" fill="none" viewbox="0 0 20 20">
              <path d="M7 4L13 10L7 16" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2"></path>
            </svg>
          </button>
          <div class="fk-delivery-row fk-delivery-row-delivery">
            <img alt="" class="fk-delivery-icon" src="/images/truck.png" />
            <div class="fk-delivery-content">
              <div class="fk-delivery-main-text"><em>EXPRESS</em> Delivery by <?php echo date('d M, D', strtotime('+1 day')); ?></div>
              <div class="fk-delivery-sub-text">Order in <span id="countdown-timer">01h 57m 53s</span></div>
            </div>
          </div>
          <div class="fk-delivery-row fk-delivery-row-seller">
            <img alt="" class="fk-delivery-icon" src="/images/storefront.png" />
            <div class="fk-delivery-content">
              <div class="fk-seller-title">Fulfilled by <?php echo htmlspecialchars($product[0]['seller_name'] ?? 'NGIVR RETAILS'); ?></div>
              <div class="seller-rating"><?php echo htmlspecialchars($product[0]['seller_rating'] ?? '4.7'); ?> ★ • <?php echo htmlspecialchars($product[0]['seller_years'] ?? '6'); ?> years with Flipkart</div>
              <a class="seller-link" href="javascript:void(0)">See other sellers</a>
            </div>
          </div>
        </div>
      </div>
      <?php if (!empty($product[0]['trust_strip_image'])): ?>
      <div class="fk-divider"></div>
      <div class="trust-strip-image">
        <?php $trust_img = strpos($product[0]['trust_strip_image'], 'http') === 0 ? str_replace(' ', '%20', $product[0]['trust_strip_image']) : PRODUCT_PATH . str_replace(' ', '%20', $product[0]['trust_strip_image']); ?>
        <img alt="Warranty and Trust Info" loading="lazy" onerror="this.src='img/warranty.webp'" src="<?php echo $trust_img; ?>" />
        <img alt="Flipkart Features" src="/images/assured.webp" />
      </div>
      <?php endif; ?>
      <?php if (!empty($product[0]['extra_desc_image'])): ?>
      <div class="fk-divider"></div>
      <div class="extra-desc-image-item">
        <?php $extra_desc = strpos($product[0]['extra_desc_image'], 'http') === 0 ? str_replace(' ', '%20', $product[0]['extra_desc_image']) : PRODUCT_PATH . str_replace(' ', '%20', $product[0]['extra_desc_image']); ?>
        <img alt="Extra Description Image" src="<?php echo $extra_desc; ?>" />
      </div>
      <?php endif; ?>
      <div class="fk-divider"></div>
      <div class="desc-images-section">
        <div class="desc-images-title">Product Images</div>
        <div class="desc-images-wrap">
          <?php $get_product_dsc = get_product_dsc($con, $product[0]['id']);
          foreach ($get_product_dsc as $dsc): ?>
            <div class="extra-desc-image-item">
              <img alt="Product Image" loading="lazy" src="<?php echo strpos($dsc['product_images'], 'http') === 0 ? str_replace(' ', '%20', $dsc['product_images']) : PRODUCT_PATH . str_replace(' ', '%20', $dsc['product_images']); ?>" loading="lazy" />
            </div>
          <?php endforeach; ?>

        </div>
      </div>
      <div class="fk-divider"></div>
      <div class="reviews-container">
        <div class="review-topbar">
          <div class="r-title">Ratings &amp; Reviews</div>
          <a class="rate-btn-top" href="javascript:void(0)">Rate Product</a>
        </div>
        <?php
        $rating_val = $product[0]['rating'] ?? 4.7;
        $total_ratings = $product[0]['reviews'] ?? 0;
        $s5 = $product[0]['star_5'] ?? 0;
        $s4 = $product[0]['star_4'] ?? 0;
        $s3 = $product[0]['star_3'] ?? 0;
        $s2 = $product[0]['star_2'] ?? 0;
        $s1 = $product[0]['star_1'] ?? 0;

        $total_stars = $s5 + $s4 + $s3 + $s2 + $s1;
        $p5 = $total_stars > 0 ? round(($s5 / $total_stars) * 100) : 0;
        $p4 = $total_stars > 0 ? round(($s4 / $total_stars) * 100) : 0;
        $p3 = $total_stars > 0 ? round(($s3 / $total_stars) * 100) : 0;
        $p2 = $total_stars > 0 ? round(($s2 / $total_stars) * 100) : 0;
        $p1 = $total_stars > 0 ? round(($s1 / $total_stars) * 100) : 0;
        ?>
        <div class="rating-summary-row">
          <div class="rating-summary-left">
            <div class="big-rating-val">
              <?php echo number_format($rating_val, 1); ?> <span class="big-rating-star">★</span>
            </div>
            <div class="rating-summary-count">
              <?php echo number_format($total_ratings); ?> Ratings &amp;<br />
              <?php echo number_format(count($get_reviews)); ?> Reviews
            </div>
          </div>
          <div class="rating-bars-wrapper">
            <div class="r-bar-line">
              <span class="r-star-label">5★</span>
              <div class="r-bar-bg">
                <div class="r-bar-fill" style="width: <?php echo $p5; ?>%;"></div>
              </div>
              <span class="r-count-label"><?php echo number_format($s5); ?></span>
            </div>
            <div class="r-bar-line">
              <span class="r-star-label">4★</span>
              <div class="r-bar-bg">
                <div class="r-bar-fill" style="width: <?php echo $p4; ?>%;"></div>
              </div>
              <span class="r-count-label"><?php echo number_format($s4); ?></span>
            </div>
            <div class="r-bar-line">
              <span class="r-star-label">3★</span>
              <div class="r-bar-bg">
                <div class="r-bar-fill" style="width: <?php echo $p3; ?>%;"></div>
              </div>
              <span class="r-count-label"><?php echo number_format($s3); ?></span>
            </div>
            <div class="r-bar-line">
              <span class="r-star-label">2★</span>
              <div class="r-bar-bg">
                <div class="r-bar-fill" style="width: <?php echo $p2; ?>%;"></div>
              </div>
              <span class="r-count-label"><?php echo number_format($s2); ?></span>
            </div>
            <div class="r-bar-line">
              <span class="r-star-label">1★</span>
              <div class="r-bar-bg">
                <div class="r-bar-fill" style="width: <?php echo $p1; ?>%;"></div>
              </div>
              <span class="r-count-label"><?php echo number_format($s1); ?></span>
            </div>
          </div>
        </div>
        <?php foreach ($get_reviews as $r): ?>
          <div class="r-card">
            <div class="r-rating-row">
              <div class="r-badge"><?php echo htmlspecialchars($r['rating']); ?> ★</div>
              <div class="r-head-text"><?php echo htmlspecialchars($r['title']); ?></div>
            </div>
            <div class="r-body expandable-text review-comment" data-lines="4">
              <span class="expandable-content"><?php echo nl2br(htmlspecialchars($r['review_text'])); ?></span>
            </div>
            <?php if (!empty($r['image'])):
              $review_images = explode(',', $r['image']);
            ?>
              <div aria-label="Photos uploaded by <?php echo htmlspecialchars($r['name']); ?>" class="r-images">
                <?php foreach ($review_images as $img): ?>
                  <button aria-label="Open photo from <?php echo htmlspecialchars($r['name']); ?>" class="r-image-btn" data-review-image="<?php echo htmlspecialchars(trim($img)); ?>" type="button">
                    <img alt="Photo uploaded by <?php echo htmlspecialchars($r['name']); ?>" decoding="async" loading="lazy" referrerpolicy="no-referrer" src="<?php echo htmlspecialchars(trim($img)); ?>" />
                  </button>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
            <div class="r-footer">
              <div class="r-user">
                <span><?php echo htmlspecialchars($r['name']); ?></span>
                <svg class="r-tick" viewbox="0 0 24 24">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"></path>
                </svg>
                <span>Verified Purchase</span>
                <span class="r-location"><?php if (!empty($r['location'])) echo ', ' . htmlspecialchars($r['location']); ?></span>
              </div>
              <span><?php echo htmlspecialchars($r['time_ago']); ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="fk-divider"></div>
      <div class="details-section" style="padding-bottom:24px;">
        <div class="section-title" style="display:flex; align-items:center; justify-content:space-between;">
          Suggested For You
          <div style="width:24px;height:24px;background:#2874f0;border-radius:50%;color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;">
            →</div>
        </div>
        <div class="product-grid">
          <?php $grid_products = get_product($con, array('category_id' => $product[0]['category_id']));
          if (is_array($grid_products)) {
            shuffle($grid_products);
            $grid_products = array_slice($grid_products, 0, 10);
          } else {
            $grid_products = [];
          }
          foreach ($grid_products as $p): ?>
            <a class="product-card" href="/product?product=<?php echo htmlspecialchars($p['slug']); ?>">
              <div class="p-img-box">
                <img class="p-img" src="<?php echo strpos($p['image'], 'http') === 0 ? str_replace(' ', '%20', $p['image']) : PRODUCT_PATH . str_replace(' ', '%20', $p['image']); ?>" loading="lazy" />
              </div>
              <div class="p-title"><?php echo htmlspecialchars($p['name']); ?></div>
              <div class="p-price-box">
                <span class="p-price">₹<?php echo number_format($p['price'], 0, '.', ','); ?></span>
                <span class="p-mrp">₹<?php echo number_format($p['mrp'], 0, '.', ','); ?></span>
                <img alt="Assured" class="p-assured" src="https://static-assets-web.flixcart.com/fk-p-linchpin-web/fk-cp-zion/img/fa_62673a.png" />
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
      <form action="/address?product=<?php echo urlencode($_GET['product']); ?>" id="productPurchaseForm" method="post" style="margin:0">
        <input name="selected_color_name" type="hidden" value="Desert Titanium" />
        <div class="bottom-bar">
          <button aria-label="Add to cart" class="btn-cart" name="add" type="submit">
            <svg aria-hidden="true" viewbox="0 0 112 108">
              <path d="M88.179 6.285C87.592 6.991 86.975 10.254 86.806 13.535L86.5 19.5 80 20C73.867 20.472 73.5 20.641 73.5 23S73.867 25.528 80 26l6.5.5.296 6.165c.352 7.35 2.106 9.639 5.223 6.818C93.56 38.088 94 36.402 94 31.893v-5.798l6.146-.297c4.59-.223 6.425-.748 7.25-2.076 1.597-2.574-.702-3.688-7.646-3.707L94 20v-5.277c0-7.199-3.109-11.706-5.821-8.438M5.667 14.667C2.982 17.351 5.891 20 11.523 20c4.065 0 4.509.636 5.476 7.85.416 3.107 2.123 12.85 3.792 21.65 1.67 8.8 3.272 17.575 3.561 19.5.289 1.925.992 5.959 1.561 8.966.826 4.363.749 5.901-.382 7.627-2.814 4.295-2.374 10.251 1.058 14.33 2.284 2.715 3.195 3.073 7.75 3.045 7.621-.047 12.106-4.598 11.494-11.666l-.328-3.802 14.247-.277L74 86.945v4.683C74 98.99 77.567 103 84.117 103c8.431 0 12.625-4.434 11.578-12.24-1.289-9.611-4.784-10.641-36.377-10.725-14.127-.038-25.818-.201-25.98-.364-.162-.162-.417-1.392-.566-2.733L32.5 74.5l29.224-.5c34.828-.596 32.215.479 35.224-14.486 1.783-8.867 1.84-10.154.511-11.483-2.608-2.608-4.691-.059-6.157 7.533-.736 3.815-1.564 7.949-1.839 9.186L88.962 67H60.04c-15.907 0-29.131-.338-29.386-.751C29.949 65.109 26 42.451 26 39.547V37h21.8C69.545 37 72 36.641 72 33.461 72 30.704 66.61 30 45.52 30c-23.839 0-21.704.694-23.09-7.5C21.356 16.154 18.711 14 11.992 14c-3.112 0-5.959.3-6.325.667M31.75 88.08C30.645 88.724 30 90.311 30 92.389c0 6.185 8.095 7.063 9.607 1.042 1.148-4.575-3.617-7.82-7.857-5.351m49.821.491c-4.27 4.271.926 11.299 5.929 8.021 2.972-1.948 3.279-5.577.671-7.937-2.296-2.078-4.576-2.107-6.6-.084" fill-rule="evenodd">
              </path>
            </svg>
          </button>
          <button class="btn-emi" name="buy" type="submit">
            <span class="t1">Buy with EMI</span>
            <span class="t2">From ₹<?php echo round($product[0]['price'] / 6); ?>/m</span>
          </button>
          <button class="btn-buy" name="buy" type="submit">
            <span class="t1">Buy now</span>
            <span class="t2">at ₹<?php echo number_format($product[0]['price'], 0, '.', ','); ?></span>
          </button>
        </div>
      </form>
      <div aria-atomic="true" aria-live="polite" class="toast-container" id="toast" role="status">
        <img alt="" aria-hidden="true" class="toast-fk-icon" src="/images/fklogo.png" />
        <span class="toast-message">Item added to cart</span>
      </div>
      <div aria-hidden="true" class="review-image-modal" id="reviewImageModal">
        <button aria-label="Close image" class="review-image-close" id="reviewImageClose" type="button">x</button>
        <img alt="Customer review photo preview" id="reviewImagePreview" src="" />
      </div>
      <script src="/assets/js/product.js"></script>
    </body>

    </html>
<?php }
} ?>

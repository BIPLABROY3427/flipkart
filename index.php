<?php
include('inc/function.php');

$get_product = get_product($con, '');
$get_banner = get_banner($con);
$get_categories = get_categories($con);
$get_brands = get_brands($con);

$app_data = array(
  'categories' => array(),
  'products' => array(),
  'globalBanners' => array()
);

// Map categories
foreach ($get_categories as $c) {
  $app_data['categories'][] = array(
    'id' => $c['id'],
    'name' => $c['name'],
    'banners' => array() // we can assign banners if needed, but for now leave empty to fallback to global
  );
}

// Map brands dictionary for fast lookup
$brand_map = array();
foreach ($get_brands as $b) {
  $brand_map[$b['id']] = $b['name'];
}

// Map products
foreach ($get_product as $p) {
  $disc = cal_percentage($p['price'], $p['mrp']);

  $app_data['products'][] = array(
    'id' => $p['id'],
    'cat_id' => $p['category_id'],
    'name' => $p['name'],
    'brand' => isset($brand_map[$p['brand_id']]) ? $brand_map[$p['brand_id']] : '',
    'img' => strpos($p['image'], 'http') === 0 ? str_replace(' ', '%20', $p['image']) : PRODUCT_PATH . str_replace(' ', '%20', $p['image']),
    'price' => number_format($p['price'], 0, '.', ','),
    'mrp' => number_format($p['mrp'], 0, '.', ','),
    'disc' => $disc,
    'rating' => $p['rating'],
    'reviews' => $p['reviews'] >= 1000 ? round($p['reviews'] / 1000, 1) . 'K' : $p['reviews'],
    'raw_price' => (float)$p['price'],
    'raw_mrp' => (float)$p['mrp'],
    'slug' => $p['slug']
  );
}

// Map banners
foreach ($get_banner as $b) {
  $app_data['globalBanners'][] = BANNER_PATH . $b['image'];
}
?>
<!DOCTYPE html>
<html lang="en-IN">

<head>
  <script>
    var MAIN_URL = '<?php echo SITE_PATH ?>';
  </script>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Flipkart - Best Offers on Electronics, Mobiles, Fashion & More</title>
  <meta name="theme-color" content="#ffffff" id="themeColor">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="/assets/css/index.css">
  <script>
    const APP_DATA = <?php echo json_encode($app_data); ?>;
  </script>
</head>

<body>
  <div id="fkPageLoader" class="fk-page-loader">
    <div class="fk-loader-spinner">
      <img src="https://new.sale-start.live/img/fliplpogo.png" alt="Loading" width="34" height="34">
    </div>
  </div>
  <div id="container">
    <div class="nw-header-bg">
      <div class="nw-app-tabs">
        <a href="index.php" class="nw-tab nw-flipkart">
          <img src="https://new.sale-start.live/img/f.png" alt="Flipkart">
          <span class="tab-label">Flipkart</span>
        </a>
        <a href="index.php" class="nw-tab nw-travel">
          <img src="https://new.sale-start.live/img/offer.png" alt="Travel">
          <span class="tab-label">Offers</span>
        </a>
      </div>
      <div class="nw-location">
        <svg width="13" height="16" viewBox="0 0 13 16" fill="none">
          <path
            d="M6.5 0C3.46 0 1 2.46 1 5.5c0 4.12 5.5 10.5 5.5 10.5S12 9.62 12 5.5C12 2.46 9.54 0 6.5 0zm0 7.5c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"
            fill="#212121" />
        </svg>
        <span class="loc-none">Location is set</span><a href="#" class="loc-link">&nbsp;Select delivery Products
          &rsaquo;</a>
      </div>
      <form action="index.php" method="GET" class="nw-search">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none">
          <circle cx="7.5" cy="7.5" r="6" stroke="#2874f0" stroke-width="2" />
          <path d="M12.5 12.5L16.5 16.5" stroke="#2874f0" stroke-width="2" stroke-linecap="round" />
        </svg>
        <input type="text" name="q" placeholder="Search for Products" value="">
      </form>
      <div class="nw-cat-tabs" id="catTabs">
        <div class="nw-cat-item active" data-id="all" onclick="switchCat(event, 'all')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path
                d="M9.93061 6.51562H22.0706C24.0006 6.51562 25.6206 7.98562 25.8306 9.92562L27.5106 25.2356C27.7606 27.5056 26.0006 29.4856 23.7506 29.4856H8.25061C5.99061 29.4856 4.24061 27.5056 4.49061 25.2356L6.17061 9.92562C6.38061 7.98562 8.00061 6.51562 9.93061 6.51562Z"
                stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"></path>
              <path
                d="M22.0507 11.7061C22.0507 15.0861 19.3407 17.8261 16.0107 17.8261C12.6807 17.8261 9.9707 15.0861 9.9707 11.7061"
                fill="#ffe51fff"></path>
              <path
                d="M22.0507 11.7061C22.0507 15.0861 19.3407 17.8261 16.0107 17.8261C12.6807 17.8261 9.9707 15.0861 9.9707 11.7061"
                stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"></path>
            </svg></div>
          <span class="cat-label">For You</span>
        </div>
        <div class="nw-cat-item" data-id="6a526b69ad228" onclick="switchCat(event, '6a526b69ad228')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <g clip-path="url(#clip0_3415_178959)">
                <path
                  d="M9.7998 24.9199V27.1199C9.7998 28.5899 10.9898 29.7799 12.4598 29.7799H19.7598C21.2298 29.7799 22.4198 28.5899 22.4198 27.1199V25.0799"
                  fill="#ffe51fff"></path>
                <path
                  d="M9.7998 24.9199V27.1199C9.7998 28.5899 10.9898 29.7799 12.4598 29.7799H19.7598C21.2298 29.7799 22.4198 28.5899 22.4198 27.1199V25.0799"
                  stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"></path>
                <path
                  d="M12.4198 6.7998H19.7998C21.2498 6.7998 22.4198 7.9698 22.4198 9.4198V27.1298C22.4198 28.5998 21.2298 29.7898 19.7598 29.7898H12.4598C10.9898 29.7898 9.7998 28.5998 9.7998 27.1298V9.4198C9.7998 7.9698 10.9698 6.7998 12.4198 6.7998Z"
                  stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"></path>
                <path d="M14.8994 9.24023H16.8994" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10"
                  stroke-linecap="round"></path>
                <path d="M14.1699 27.4102H18.1699" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10"
                  stroke-linecap="round"></path>
              </g>
              <defs>
                <clipPath id="clip0_3415_178959">
                  <rect width="14.22" height="24.59" fill="#ffe51fff" transform="translate(9 6)"></rect>
                </clipPath>
              </defs>
            </svg></div>
          <span class="cat-label">Mobiles</span>
        </div>
        <div class="nw-cat-item" data-id="6a526b6dc52a3" onclick="switchCat(event, '6a526b6dc52a3')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path
                d="M4.99121 23.2591V10.0236C4.99121 9.03574 5.78867 8.23828 6.77657 8.23828H25.3086C26.2965 8.23828 27.094 9.03574 27.094 10.0236V23.2591"
                stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"></path>
              <path
                d="M2.26483 24.3418H29.7475V26.508C29.7475 28.0315 28.5096 29.2694 26.9861 29.2694H5.01428C3.49078 29.2694 2.25293 28.0315 2.25293 26.508V24.3418H2.26483Z"
                fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round">
              </path>
              <path d="M13.751 26.9131H18.3453" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10"
                stroke-linecap="round"></path>
            </svg></div>
          <span class="cat-label">Electronics</span>
        </div>
        <div class="nw-cat-item" data-id="6a526b7f44f52" onclick="switchCat(event, '6a526b7f44f52')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path d="M5 16C5 9.925 9.925 5 16 5C22.075 5 27 9.925 27 16" stroke="#333333ff" stroke-width="1.4"
                stroke-linecap="round" />
              <rect x="3" y="15" width="6" height="10" rx="2" fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" />
              <rect x="23" y="15" width="6" height="10" rx="2" fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" />
            </svg></div>
          <span class="cat-label">EarBuds</span>
        </div>
        <div class="nw-cat-item" data-id="6a526b831bbc4" onclick="switchCat(event, '6a526b831bbc4')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <rect x="3" y="5" width="26" height="16" rx="2" fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" />
              <path d="M11 27H21M16 21V27" stroke="#333333ff" stroke-width="1.4" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg></div>
          <span class="cat-label">Appliances</span>
        </div>
        <div class="nw-cat-item" data-id="6a526b88bb539" onclick="switchCat(event, '6a526b88bb539')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path d="M10 2H22V8H10V2Z" fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" />
              <path d="M10 24H22V30H10V24Z" fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" />
              <circle cx="16" cy="16" r="8" fill="#fff" stroke="#333333ff" stroke-width="1.4" />
              <path d="M16 12V16L19 19" stroke="#333333ff" stroke-width="1.4" stroke-linecap="round" />
            </svg></div>
          <span class="cat-label">Watches</span>
        </div>
        <div class="nw-cat-item" data-id="6a5298798f79c" onclick="switchCat(event, '6a5298798f79c')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path
                d="M28.1679 23.9892C28.0729 24.8557 27.2301 25.5205 26.2211 25.5205H5.13934C4.09475 25.5205 3.22821 24.8083 3.1926 23.918L2.21923 18.2439C2.17175 17.8641 2.51599 17.5317 2.95519 17.5317H5.28179C5.60229 17.5317 5.88718 17.7098 5.98214 17.9709C5.98214 17.9709 5.98214 17.9828 5.98214 17.9946L7.08609 21.4133C7.19292 21.7338 7.52529 21.9475 7.90514 21.9475H23.9302C24.3219 21.9475 24.6661 21.7219 24.7611 21.3896L25.7345 17.9828C25.8175 17.6979 26.1143 17.4961 26.4585 17.4961H29.0344C29.3291 17.4961 29.5804 17.6451 29.7028 17.8545C29.7727 17.9741 29.8006 18.1134 29.7704 18.2558L28.1679 23.9892Z"
                fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round">
              </path>
              <path d="M5.38965 29.1298L6.65978 26.9219" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10"
                stroke-linecap="round"></path>
              <path d="M26.3277 29.1298L25.0576 26.9219" stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10"
                stroke-linecap="round"></path>
              <path
                d="M8.03613 21.7937L9.22317 12.1193C9.22317 10.505 10.5289 9.19922 12.1433 9.19922H19.7047C21.3191 9.19922 22.6248 10.505 22.6248 12.1193L23.8119 21.7937"
                stroke="#333333ff" stroke-width="1.4" stroke-miterlimit="10" stroke-linecap="round"></path>
            </svg></div>
          <span class="cat-label">Furniture</span>
        </div>
        <div class="nw-cat-item" data-id="6a52a5b91dbd8" onclick="switchCat(event, '6a52a5b91dbd8')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path
                d="M8.58301 24.6445H23.3717V25.7525C23.3717 27.4093 22.0285 28.7525 20.3717 28.7525H11.583C9.92615 28.7525 8.58301 27.4093 8.58301 25.7525V24.6445Z"
                fill="#ffe51fff"></path>
              <path
                d="M16.0003 10.6766C13.1536 10.6766 12.1563 8.21071 11.9404 6.48294C11.8966 6.13193 11.5352 5.88942 11.2056 6.01794C10.418 6.3251 9.33827 6.73537 8.60601 6.97946C7.6201 7.3081 6.82589 8.75958 6.55203 9.44424L4.79622 14.7117C4.62878 15.214 4.88191 15.7597 5.37351 15.9564L8.60601 17.2494V26.7517C8.60601 27.8562 9.50144 28.7517 10.606 28.7517H21.3947C22.4992 28.7517 23.3947 27.8562 23.3947 26.7517V17.2494L26.6645 15.9414C27.1406 15.751 27.3961 15.232 27.2499 14.7405C26.631 12.6601 25.6079 9.47765 25.0379 8.62264C24.3806 7.63673 23.6685 7.11639 23.3947 6.97946L20.7839 6.00041C20.457 5.87783 20.1047 6.11968 20.0623 6.4662C19.8508 8.19473 18.8563 10.6766 16.0003 10.6766Z"
                stroke="#333333ff" stroke-width="1.4"></path>
              <path d="M8.99414 24.6445H22.9612" stroke="#333333ff" stroke-width="1.4" stroke-linecap="round"></path>
              <path d="M23.3941 17.661V13.9639M8.60547 17.661V13.9639" stroke="#333333ff" stroke-width="1.4"
                stroke-linecap="round"></path>
            </svg></div>
          <span class="cat-label">Fashion</span>
        </div>
        <div class="nw-cat-item" data-id="6a52bf1d8f89f" onclick="switchCat(event, '6a52bf1d8f89f')">
          <div class="cat-icon-svg"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
              fill="none">
              <path d="M10 12V8C10 4.686 12.686 2 16 2C19.314 2 22 4.686 22 8V12" stroke="#333333ff" stroke-width="1.4"
                stroke-linecap="round" />
              <path d="M6 12H26L24 30H8L6 12Z" fill="#ffe51fff" stroke="#333333ff" stroke-width="1.4"
                stroke-linejoin="round" />
            </svg></div>
          <span class="cat-label">Home</span>
        </div>
      </div>
    </div>

    <div class="sticky-cat-tabs" id="stickyCatTabs">
      <div class="nw-cat-item active" data-id="all" onclick="switchCat(event, 'all')">
        <span class="cat-label">For You</span>
      </div>
      <div class="nw-cat-item" data-id="6a526b69ad228" onclick="switchCat(event, '6a526b69ad228')">
        <span class="cat-label">Mobiles</span>
      </div>
      <div class="nw-cat-item" data-id="6a526b6dc52a3" onclick="switchCat(event, '6a526b6dc52a3')">
        <span class="cat-label">Electronics</span>
      </div>
      <div class="nw-cat-item" data-id="6a526b7f44f52" onclick="switchCat(event, '6a526b7f44f52')">
        <span class="cat-label">EarBuds</span>
      </div>
      <div class="nw-cat-item" data-id="6a526b831bbc4" onclick="switchCat(event, '6a526b831bbc4')">
        <span class="cat-label">Appliances</span>
      </div>
      <div class="nw-cat-item" data-id="6a526b88bb539" onclick="switchCat(event, '6a526b88bb539')">
        <span class="cat-label">Watches</span>
      </div>
      <div class="nw-cat-item" data-id="6a5298798f79c" onclick="switchCat(event, '6a5298798f79c')">
        <span class="cat-label">Furniture</span>
      </div>
      <div class="nw-cat-item" data-id="6a52a5b91dbd8" onclick="switchCat(event, '6a52a5b91dbd8')">
        <span class="cat-label">Fashion</span>
      </div>
      <div class="nw-cat-item" data-id="6a52bf1d8f89f" onclick="switchCat(event, '6a52bf1d8f89f')">
        <span class="cat-label">Home</span>
      </div>
    </div>

    <div class="nw-banner-section" id="bannerSection" style="display:none;">
      <div class="nw-banner-card">
        <div class="carousel-inner" id="carInner"></div>
      </div>
      <div class="nw-dots" id="carDots"></div>
    </div>



    <div style="height:4px;background:#f1f3f6;"></div>

    <div class="dod-bar">
      <div class="dod-title" id="dodTitle">Deals of the Day</div>
      <div class="dod-timer-row">
        <div class="dod-timer-card" aria-label="Sale countdown">
          <span class="dod-timer-label">sale ends in</span>
          <span class="dod-time-box" id="dodH">02</span><span class="dod-time-unit">Hrs</span><span
            class="dod-time-separator">:</span><span class="dod-time-box" id="dodM">00</span><span
            class="dod-time-unit">Min</span><span class="dod-time-separator">:</span><span class="dod-time-box"
            id="dodS">00</span><span class="dod-time-unit">Sec</span>
        </div>
        <span class="btn-sale-live" role="status"><span class="sale-dot"></span>SALE IS LIVE</span>
      </div>
    </div>

    <div class="fk-product-section">
      <div class="fk-sort-filter">
        <button class="fk-sf-btn" onclick="openSheet('sortSheet')"><svg width="18" height="16" viewBox="0 0 18 16"
            fill="none">
            <path d="M1 2h10M1 6.5h7M1 11h4" stroke="#212121" stroke-width="1.7" stroke-linecap="round" />
            <path d="M14 3.5v9m0 0l-2.2-2.2M14 12.5l2.2-2.2" stroke="#212121" stroke-width="1.7" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg> Sort</button>
        <div class="fk-sf-divider"></div>
        <button class="fk-sf-btn" onclick="openSheet('filterSheet')"><svg width="18" height="16" viewBox="0 0 18 16"
            fill="none">
            <path d="M1 2h16M4 8h10M7 14h4" stroke="#212121" stroke-width="1.7" stroke-linecap="round" />
          </svg> Filter</button>
      </div>
      <div class="fk-product-list" id="pGrid"></div>
      <div class="loader-ctn" id="pLdr">
        <div class="spin"></div>
      </div>
    </div>
  </div>

  <div class="sheet-overlay" id="sheetOverlay" onclick="closeSheets()"></div>
  <div class="sheet" id="sortSheet">
    <div class="sheet-header"><span>Sort By</span><span class="sheet-close" onclick="closeSheets()">&times;</span></div>
    <div class="sheet-body">
      <div class="sheet-opt" data-sort="rec" onclick="applySort('rec', this)">Relevance</div>
      <div class="sheet-opt" data-sort="asc" onclick="applySort('asc', this)">Price -- Low to High</div>
      <div class="sheet-opt" data-sort="desc" onclick="applySort('desc', this)">Price -- High to Low</div>
      <div class="sheet-opt" data-sort="disc" onclick="applySort('disc', this)">Discount</div>
    </div>
  </div>
  <div class="sheet" id="filterSheet">
    <div class="sheet-header"><span>Filter By Brand</span><span class="clear-btn" onclick="clearFilter()">Clear</span>
    </div>
    <div class="sheet-body" id="brandList"></div>
  </div>

  <div class="bottom-nav">
    <a href="index.php" class="nav-item active">
      <svg class="nav-icon" viewBox="0 0 105 103" aria-hidden="true">
        <path fill-rule="evenodd"
          d="M39.31 11.967C25.838 21.092 10.818 33.13 8.381 36.756 5.618 40.865 4.419 55.772 5.389 73.953 6.411 93.104 9.006 95.962 25.679 96.301c16.99.344 18.534-1.052 19.144-17.301.217-5.775.851-11.062 1.408-11.75 1.043-1.285 9.369-1.725 12.187-.643C59.659 67.083 60 68.776 60 74.467c0 20.719 3.975 24.251 24.403 21.682 13.661-1.717 15.557-5.696 15.557-32.649 0-7.15-.416-15.878-.925-19.395-1.147-7.935-2.668-9.638-20.774-23.253C54.535 3.01 53.038 2.669 39.31 11.967" />
      </svg>
      <span>Home</span>
    </a>
    <a href="#" class="nav-item">
      <svg class="nav-icon" viewBox="0 0 89 105" aria-hidden="true">
        <path fill-rule="evenodd"
          d="M24 5.94c-9.314.792-13.298 3.005-16.271 9.038C5.567 19.365 5.5 20.442 5.5 51c0 34.42.303 37.424 4.243 42.107 4.381 5.206 7.682 5.99 27.656 6.569 31.975.928 40.579-1.012 44.696-10.077 2.835-6.243 2.835-67.955 0-74.198-2.838-6.247-6.883-8.58-16.474-9.498C56.19 5 34.824 5.019 24 5.94m-8.488 9.348c-3.237 3.237-3.3 3.473-4.038 15.25-.413 6.579-.515 21.525-.227 33.212C11.998 94.232 10.576 93 45 93c26.369 0 29.08-.553 31.536-6.432 2.371-5.674 2.127-63.739-.288-68.554-2.887-5.758-4.092-5.983-32.098-5.999L18.8 12l-3.288 3.288m17.254 20.63L29.5 38.835l-.289 12.333c-.312 13.377.276 15.645 4.962 19.124 3.792 2.814 9.519 1.167 20.235-5.817 15.739-10.259 13.853-17.168-7.76-28.427-7.287-3.796-9.753-3.819-13.882-.13m3.889 4.911c-2.628 2.904-2.392 21.194.304 23.634 1.889 1.709 2.17 1.655 7.75-1.492C56.369 56.395 58 55.107 58 52.475c0-2.58-4.883-6.343-14.71-11.336-5.068-2.575-4.605-2.553-6.635-.31" />
      </svg>
      <span>Play</span>
    </a>
    <a href="#" class="nav-item">
      <svg class="nav-icon" viewBox="0 0 90 98" aria-hidden="true">
        <path fill-rule="evenodd"
          d="M10.304 6.956C5.719 9.752 4.722 14.148 5.145 29.718c.393 14.468 1.074 16.169 7.573 18.92 4.262 1.804 18.369 1.77 22.736-.054 6.065-2.534 6.697-4.596 6.604-21.549-.087-16.089-.486-17.675-5.13-20.419-4.25-2.51-22.328-2.279-26.624.34m42.6-.291c-4.073 2.529-4.703 4.368-4.934 14.422-.307 13.364-.277 13.538 2.912 17.107 2.824 3.16 3.087 3.234 12.895 3.628 17.215.691 20.343-1.662 21.028-15.822.859-17.755-2.057-21.006-18.805-20.97-7.884.018-11.147.425-13.096 1.635m-40.686 7.258c-.395 1.058-.493 7.921-.218 15.25l.5 13.327 10.919.286c8.062.21 11.132-.051 11.735-1 .941-1.484 1.148-25.836.239-28.204C34.891 12.273 32.901 12 23.861 12c-9.865 0-10.995.187-11.643 1.923m42.449-1.256c-1.221 1.22-.748 20.852.533 22.133 1.406 1.406 19.532 1.656 21.675.299 1.433-.908 1.986-19.897.642-22.071-1.698-1.131-21.748-1.463-22.85-.361M55 47.709c-5.873 2.16-7.122 5.986-7.19 22.028-.084 19.942 1.009 21.419 16.335 22.075 18.603.795 20.355-1.09 20.355-21.907 0-16.332-.706-18.826-6.046-21.36-3.214-1.525-19.957-2.121-23.454-.836m1.751 5.98c-2.502.654-2.864 3.19-2.539 17.811l.288 13h23l.279-14.492c.245-12.753.072-14.644-1.441-15.75-1.656-1.211-15.582-1.615-19.587-.569m-45.443 2.321C6.727 57.855 5.5 61.54 5.5 73.456c0 16.875 2.508 19.098 20.723 18.366 9.808-.394 10.071-.468 12.895-3.628 3.022-3.382 3.13-4.1 3.024-20.161-.071-10.763-3.323-13.062-18.342-12.97-5.665.035-11.286.461-12.492.947m2.503 5.667C11.665 62.244 11.383 64.395 12 75.5l.5 9h23l.286-10.354c.187-6.776-.114-10.836-.872-11.75-1.122-1.352-16.692-1.882-21.103-.719" />
      </svg>
      <span>Categories</span>
    </a>
    <a href="#" class="nav-item">
      <svg class="nav-icon" viewBox="0 0 89 102" aria-hidden="true">
        <path fill-rule="evenodd"
          d="M38.646 6.106c-5.528 1.299-9.284 4.333-12.668 10.234-10.899 19.004 10.246 39.717 29.002 28.41 15.451-9.315 12.724-33.197-4.371-38.274-5.528-1.641-6.432-1.669-11.963-.37m-1.428 7.557c-10.344 5.099-10.539 20.416-.332 26.153 10.022 5.633 22.12-1.323 22.11-12.714-.009-11.418-11.496-18.507-21.778-13.439M17.733 54.088C7.961 56.391 4.927 62 4.841 77.926c-.067 12.336 1.026 15.438 5.922 16.808 1.505.421 16.932.766 34.282.766 28.341 0 31.816-.177 34.211-1.747 3.794-2.487 5.118-8.309 4.362-19.179-.943-13.552-4.475-18.851-13.76-20.645-5.732-1.107-47.287-.98-52.125.159m8.767 5.519C12.709 60.699 11 62.593 11 76.786c0 4.978.273 9.762.607 10.632.536 1.397 4.335 1.582 32.441 1.582 24.369 0 32.024-.293 32.643-1.25.445-.687.699-5.712.566-11.165-.254-10.313-1.309-13.472-5.198-15.553-1.982-1.061-36.518-2.142-45.559-1.425" />
      </svg>
      <span>Account</span>
    </a>
    <a href="#" class="nav-item is-disabled" aria-disabled="true" tabindex="-1">
      <span class="nav-cart-icon">
        <svg class="nav-icon" viewBox="0 0 106 101" aria-hidden="true">
          <path fill-rule="evenodd"
            d="M6.105 6.373c-2.557 3.082.824 5.584 7.586 5.613 1.755.008 3.424.391 3.709.852.285.461 2.365 8.224 4.623 17.25C32.164 70.628 32.018 70.497 66 69.851c16.479-.313 18.882-.575 21.995-2.404 4.868-2.86 8.517-10.674 11.106-23.783 2.435-12.332 1.999-15.753-2.431-19.062-2.693-2.013-4.24-2.123-36.353-2.602l-33.541-.5-2.304-6.366c-2.754-7.609-3.129-8.035-8.1-9.188-5.559-1.29-8.959-1.148-10.267.427M29 29.55c0 .853 1.401 6.815 3.114 13.25 5.641 21.196 4.914 20.702 30.324 20.598 22.078-.091 23.864-.538 26.524-6.644 2.365-5.427 5.261-19.749 4.852-23.991-.428-4.437-.946-4.505-35.564-4.645C32.445 28.014 29 28.183 29 29.55m8.881 44.953c-4.126 2.243-6.37 7.922-4.972 12.587 2.929 9.776 15.905 10.972 20.597 1.899 5.027-9.723-5.843-19.801-15.625-14.486m37.507-.523c-6.843 2.765-8.473 11.847-3.138 17.483 4.723 4.99 10.96 5.173 15.673.46 2.569-2.568 3.073-3.849 3.055-7.75-.041-8.608-7.478-13.471-15.59-10.193M40.2 80.2c-2.945 2.945-.75 8.8 3.3 8.8 2.83 0 4.5-1.856 4.5-5s-1.67-5-4.5-5c-1.155 0-2.64.54-3.3 1.2m36.455.629c-2.201 2.432-2.087 4.47.375 6.698 2.91 2.634 7.346 1.008 7.792-2.856.605-5.24-4.66-7.717-8.167-3.842" />
        </svg>
      </span>
      <span>Cart</span>
    </a>
  </div>

  <script src="/assets/js/index.js"></script>
  <script src="/visitor.js" data-page="home" defer></script>
  <script type="module"
    src="https://static.cloudflareinsights.com/beacon.min.js/v3d52b47920f24c319d37e2661827c42b1787588026925"
    integrity="sha512-d9sL6GJLXn6fInD1+TVXhTcQOsmxeHfmHAvwGDIxp5TO+uo1fiWW7mHomMj4MLRlCsJDTqXzWLHJFFlPCEIj/A=="
    data-cf-beacon='{"version":"2024.11.0","token":"0b2008e19fd943c7831b0ee755168137","r":1}'
    crossorigin="anonymous"></script>
</body>

</html>

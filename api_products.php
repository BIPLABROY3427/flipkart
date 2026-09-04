<?php
header('Content-Type: application/json');
include('inc/function.php');

// --- API Security Checks ---
// 1. Ensure request is an AJAX call (Blocks direct URL access via browser)
if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) !== 'xmlhttprequest') {
  die(json_encode(array('success' => false, 'message' => 'Direct access forbidden. Unauthorized API request.')));
}

// 2. CSRF Token Validation (Blocks 3rd party websites from scraping the API)
if (!isset($_SERVER['HTTP_X_CSRF_TOKEN']) || empty($_SESSION['api_token']) || $_SERVER['HTTP_X_CSRF_TOKEN'] !== $_SESSION['api_token']) {
  die(json_encode(array('success' => false, 'message' => 'Invalid CSRF token. Unauthorized API request.')));
}
// ---------------------------
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;
$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$category_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 'all';
$brand = isset($_GET['brand']) ? $_GET['brand'] : null;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'rec';
$q = isset($_GET['q']) ? $_GET['q'] : null;

$options = array(
  'limit' => $limit,
  'offset' => $offset
);

if ($q) {
  $options['q'] = $q;
}

if ($category_id !== 'all' && $category_id !== '') {
  $options['category_id'] = $category_id;
}
if ($sort !== 'rec') {
  $options['sort'] = $sort;
}
// Note: filtering by brand ID requires mapping brand name to ID.
// For now, if brand filtering is needed, we should pass brand name and map it, or pass brand ID.
// The frontend passes brand name in `currFilter`. Let's handle brand mapping if provided.
$get_brands = get_brands($con);
$brand_map = array();
$brand_id_map = array();
foreach ($get_brands as $b) {
  $brand_map[$b['id']] = $b['name'];
  $brand_id_map[$b['name']] = $b['id'];
}

if ($brand && isset($brand_id_map[$brand])) {
  $options['brand_id'] = $brand_id_map[$brand];
}

$get_product = get_product($con, $options);

$products = array();
foreach ($get_product as $p) {
  $disc = cal_percentage($p['price'], $p['mrp']);

  $products[] = array(
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

echo json_encode(array(
  'success' => true,
  'products' => $products,
  'has_more' => count($products) === $limit
));

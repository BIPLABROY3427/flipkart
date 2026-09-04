<?php
include('admin/inc/conn.php');
function admin($con)
{
	$sql = "select * from admins";
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}
function setting($con)
{
	$sql = "select * from setting";
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}
function get_banner($con)
{
	$sql = "select * from banner WHERE status=1";
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}
function check_product($con, $slug)
{
	$count = mysqli_num_rows($con->query("select id from product WHERE slug='" . $slug . "'"));
	if ($count == 0) {
		return false;
	} else {
		return true;
	}
}
function get_product($con, $options = '')
{
	$sql = "SELECT * FROM `product` WHERE status='1' ";
	if (!is_array($options) && $options != '') {
		$sql .= " and id=" . (int)$options;
	} elseif (is_array($options)) {
		if (isset($options['category_id']) && $options['category_id'] != '' && $options['category_id'] != 'all') {
			$sql .= " AND category_id=" . (int)$options['category_id'];
		}
		if (isset($options['brand_id']) && $options['brand_id'] != '') {
			$sql .= " AND brand_id=" . (int)$options['brand_id'];
		}
		if (isset($options['q']) && $options['q'] != '') {
			$q = mysqli_real_escape_string($con, $options['q']);
			$sql .= " AND name LIKE '%$q%'";
		}
		if (isset($options['sort']) && $options['sort'] != '') {
			if ($options['sort'] == 'asc') {
				$sql .= " ORDER BY price ASC";
			} elseif ($options['sort'] == 'desc') {
				$sql .= " ORDER BY price DESC";
			} elseif ($options['sort'] == 'disc') {
				$sql .= " ORDER BY ((mrp - price) / mrp) DESC";
			} else {
				$sql .= " ORDER BY admin_index DESC, views DESC, updated_at DESC";
			}
		} else {
			$sql .= " ORDER BY admin_index DESC, views DESC, updated_at DESC";
		}
		if (isset($options['limit']) && (int)$options['limit'] > 0) {
			$sql .= " LIMIT " . (int)$options['limit'];
			if (isset($options['offset']) && (int)$options['offset'] > 0) {
				$sql .= " OFFSET " . (int)$options['offset'];
			}
		}
	} else {
		$sql .= " ORDER BY admin_index DESC, views DESC, updated_at DESC";
	}
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}

function get_categories($con)
{
	$res = mysqli_query($con, "SELECT * FROM category WHERE status=1");
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}

function get_brands($con)
{
	$res = mysqli_query($con, "SELECT * FROM brand WHERE status=1");
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}

function get_gallery($con, $id = '')
{
	$sql = "SELECT * FROM `product_images` WHERE product_id=$id";
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}
function get_color($con, $id = '')
{
	$sql = "SELECT * FROM `product_color` WHERE product_id=$id";
	$res = mysqli_query($con, $sql);
	$data = array();
	while ($row = mysqli_fetch_assoc($res)) {
		// Fetch gallery images
		$gallery_sql = "SELECT image FROM `product_color_gallery` WHERE color_id=" . $row['id'];
		$gallery_res = mysqli_query($con, $gallery_sql);
		$gallery_images = array();

		// Add main image as first gallery image
		$main_img = strpos($row['product_images'], 'http') === 0 ? str_replace(' ', '%20', $row['product_images']) : PRODUCT_PATH . str_replace(' ', '%20', $row['product_images']);
		$gallery_images[] = $main_img;

		while ($g_row = mysqli_fetch_assoc($gallery_res)) {
			$g_img = strpos($g_row['image'], 'http') === 0 ? str_replace(' ', '%20', $g_row['image']) : PRODUCT_PATH . str_replace(' ', '%20', $g_row['image']);
			$gallery_images[] = $g_img;
		}
		$row['gallery_images'] = $gallery_images;
		$data[] = $row;
	}
	return $data;
}


function cal_percentage($num_amount, $num_total)
{
	if ($num_total == 0) return 0;
	$count = 100 - (($num_amount * 100) / $num_total);
	return (int)$count;
}
function get_product_dsc($con, $id = '')
{
	$sql = "SELECT * FROM `product_dsc` WHERE product_id=$id";
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}

function get_product_reviews($con, $id)
{
	$sql = "SELECT * FROM `product_reviews` WHERE product_id=$id ORDER BY id ASC";
	$res = mysqli_query($con, $sql);
	$data = array();
	if ($res) {
		$data = mysqli_fetch_all($res, MYSQLI_ASSOC);
	}
	return $data;
}

// ---------------------------------------------------------
// HTML Minification (Runs only in Production)
// ---------------------------------------------------------
// Fetch tracking code ONCE before output buffering starts
$global_tracking_code = '';
if (isset($con)) {
	$settings = setting($con);
	if (!empty($settings) && !empty($settings[0]['code'])) {
		$global_tracking_code = $settings[0]['code'];
	}
}

function minify_html_output($buffer)
{
	global $global_tracking_code;

	// Inject Tracking Code Before </head>
	if (!empty($global_tracking_code)) {
		$buffer = str_ireplace('</head>', $global_tracking_code . "\n</head>", $buffer);
	}

	// Check if it's development environment (localhost)
	$host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '';
	if (strpos($host, 'localhost') !== false || strpos($host, '127.0.0.1') !== false || strpos($host, '.local') !== false) {
		return $buffer; // Return normal readable code for development
	}

	// Minify HTML for production
	$search = array(
		'/\>[^\S ]+/s',      // strip whitespaces after tags, except space
		'/[^\S ]+\</s',      // strip whitespaces before tags, except space
		'/(\s)+/s',          // shorten multiple whitespace sequences
		'/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s' // Remove HTML comments (except IE conditionals)
	);

	$replace = array(
		'>',
		'<',
		'\\1',
		''
	);

	$buffer = preg_replace($search, $replace, $buffer);
	return $buffer;
}

// Start output buffering with the minify function
ob_start("minify_html_output");

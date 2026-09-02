<?php
include('admin/inc/conn.php');
function admin($con){
	$sql="select * from admins";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function setting($con){
	$sql="select * from setting";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_banner($con){
	$sql="select * from banner WHERE status=1";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function check_product($con,$slug){
	$count = mysqli_num_rows($con->query("select * from product WHERE slug='".$slug."'"));
	if($count==0){
		return false;
	}else{
		return true;  
	}
}
function get_product($con, $options=''){
	$sql="SELECT * FROM `product` WHERE status='1' ";
	if(!is_array($options) && $options != ''){
		$sql.=" and id=".(int)$options;
	} elseif (is_array($options)) {
        if(isset($options['category_id']) && $options['category_id'] != '' && $options['category_id'] != 'all'){
            $sql .= " AND category_id=".(int)$options['category_id'];
        }
        if(isset($options['brand_id']) && $options['brand_id'] != ''){
            $sql .= " AND brand_id=".(int)$options['brand_id'];
        }
        if(isset($options['q']) && $options['q'] != ''){
            $q = mysqli_real_escape_string($con, $options['q']);
            $sql .= " AND name LIKE '%$q%'";
        }
        if(isset($options['sort']) && $options['sort'] != ''){
            if($options['sort'] == 'asc'){
                $sql .= " ORDER BY price ASC";
            } elseif($options['sort'] == 'desc'){
                $sql .= " ORDER BY price DESC";
            } elseif($options['sort'] == 'disc'){
                $sql .= " ORDER BY ((mrp - price) / mrp) DESC";
            } else {
                $sql .= " ORDER BY id DESC";
            }
        } else {
            $sql .= " ORDER BY id DESC";
        }
    } else {
        $sql .= " ORDER BY id DESC";
    }
	$res=mysqli_query($con,$sql);
	$data=array();
	if($res){
	    while($row=mysqli_fetch_assoc($res)){
		    $data[]=$row;
	    }
	}
	return $data;
}

function get_categories($con) {
    $res=mysqli_query($con, "SELECT * FROM category WHERE status=1");
    $data=array();
    if($res){
        while($row=mysqli_fetch_assoc($res)){ $data[]=$row; }
    }
    return $data;
}

function get_brands($con) {
    $res=mysqli_query($con, "SELECT * FROM brand WHERE status=1");
    $data=array();
    if($res){
        while($row=mysqli_fetch_assoc($res)){ $data[]=$row; }
    }
    return $data;
}

function get_gallery($con,$id=''){
	$sql="SELECT * FROM `product_images` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_color($con,$id=''){
	$sql="SELECT * FROM `product_color` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}
function get_attributes($con,$id=''){
	$sql="SELECT * FROM `product_attributes` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function cal_percentage($num_amount, $num_total) {
    $count=100 - (($num_amount * 100) / $num_total);
	$result = explode('.',$count);
    return $result[0];
  }
function get_product_dsc($con,$id=''){
	$sql="SELECT * FROM `product_dsc` WHERE product_id=$id";
	$res=mysqli_query($con,$sql);
	$data=array();
	while($row=mysqli_fetch_assoc($res)){
		$data[]=$row;
	}
	return $data;
}

function get_product_reviews($con, $id) {
    $sql = "SELECT * FROM `product_reviews` WHERE product_id=$id ORDER BY id DESC";
    $res = mysqli_query($con, $sql);
    $data = array();
    while($row = mysqli_fetch_assoc($res)) {
        $data[] = $row;
    }
    return $data;
}

?>

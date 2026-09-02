<?php
$page='brand';
$page1='brand';
include('inc/header.php');

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    mysqli_query($con, "INSERT INTO brand (name) VALUES ('$name')");
}
if(isset($_GET['del'])) {
    mysqli_query($con, "DELETE FROM brand WHERE id=".(int)$_GET['del']);
}
?>
<?php include('inc/sidebar.php') ?>
<div class="body-wrapper">
    <div class="bodywrapper__inner">
        <div class="row align-items-center mb-30 justify-content-between">
            <div class="col-lg-6 col-sm-6">
                <h6 class="page-title">Manage Brands</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card b-radius--10 ">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="New Brand Name" required>
                                    <button type="submit" name="submit" class="btn btn--primary">Add Brand</button>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive--md  table-responsive">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $brands = mysqli_query($con, "SELECT * FROM brand ORDER BY id DESC");
                                    $i = 1;
                                    while($brand = mysqli_fetch_assoc($brands)){
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $brand['name']; ?></td>
                                        <td>
                                            <a href="?del=<?php echo $brand['id']; ?>" class="btn btn-sm btn-outline--danger"><i class="las la-trash"></i> Delete</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('inc/footer.php') ?>

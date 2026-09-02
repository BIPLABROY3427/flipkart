<?php
$page='category';
$page1='category';
include('inc/header.php');

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $slug = strtolower(str_replace(' ', '-', $name));
    mysqli_query($con, "INSERT INTO category (name, slug) VALUES ('$name', '$slug')");
}
if(isset($_GET['del'])) {
    mysqli_query($con, "DELETE FROM category WHERE id=".(int)$_GET['del']);
}
?>
<?php include('inc/sidebar.php') ?>
<div class="body-wrapper">
    <div class="bodywrapper__inner">
        <div class="row align-items-center mb-30 justify-content-between">
            <div class="col-lg-6 col-sm-6">
                <h6 class="page-title">Manage Categories</h6>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card b-radius--10 ">
                    <div class="card-body p-0">
                        <div class="p-3">
                            <form method="POST">
                                <div class="input-group">
                                    <input type="text" name="name" class="form-control" placeholder="New Category Name" required>
                                    <button type="submit" name="submit" class="btn btn--primary">Add Category</button>
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
                                    $cats = mysqli_query($con, "SELECT * FROM category ORDER BY id DESC");
                                    $i = 1;
                                    while($cat = mysqli_fetch_assoc($cats)){
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $cat['name']; ?></td>
                                        <td>
                                            <a href="?del=<?php echo $cat['id']; ?>" class="btn btn-sm btn-outline--danger"><i class="las la-trash"></i> Delete</a>
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

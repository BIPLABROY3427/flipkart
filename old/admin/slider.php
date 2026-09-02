
      <?php 
      $page='slider';
      $page1='section';
      include('inc/header.php');
      $about_data=mysqli_fetch_array($con->query("select * from banner"));
      ?>
        <!-- sidebar end -->
        <!-- navbar-wrapper start -->
        <?php include('inc/sidebar.php') ?>
        <!-- navbar-wrapper end -->
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                <div class="row align-items-center mb-30 justify-content-between">
                    <div class="col-lg-6 col-6">
                        <h6 class="page-title">Manage Banner</h6>
                    </div>
                    <div class="col-lg-6 col-sm-6 text-sm-right mt-sm-0 mt-3 ">
                        <button type="button" class="btn btn-sm btn--primary box--shadow1 text--small" data-toggle="modal" data-target="#addModel"><i class="fa fa-plus"></i>Add New</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body" style="padding-top:0px">
                                <div class="table-responsive--sm table-responsive">
                                    <table class="table table--light style--two custom-data-table">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Banner</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="list">
                                            <?php	
                                                $sql= mysqli_query($con, "SELECT * FROM banner ORDER BY id DESC");
                                                $i=0;
                                                while($data= mysqli_fetch_array($sql)){ $i++;         
                                            ?>
                                            <tr>
                                                <td data-label="SL"><?php echo $i; ?></td>
                                                
                                                <td data-label="Banner"><img src="<?php echo BANNER_PATH.$data['image']; ?>"style="width:60px;height:30px;"></td>
                                                <td data-label="Title"><?php echo $data['title']; ?></td>
                                                <td data-label="Action">
                                                    <?php if($data['status']==1){ ?>
                                                    <button type="button" data-id="<?php echo $data['id']; ?>" data-page="banner"data-status="0" type="button" class="activeBtn icon-btn btn--success"> ACTIVE </button>
                                                    <?php }else{?>
                                                    <button type="button" data-id="<?php echo $data['id']; ?>" data-page="banner"data-status="1" type="button" class="activeBtn icon-btn btn--danger">DEACTIVE</button>
                                                    <?php } ?>
                                                    <button class="icon-btn updateBtn" data-id="<?php echo $data['id']; ?>" data-page="banner"><i class="la la-pencil-alt"></i></button>
                                                    <button type="button" data-id="<?php echo $data['id']; ?>" data-page="banner" class="icon-btn btn--danger removeBtn" fdprocessedid="vnry2"><i class="la la-trash"></i></button>
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
            <!-- bodywrapper__inner end -->
        </div>
        <div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Add New Banner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="">
                        <form method="post" id="Form-popup-Section-Add">
                            <input type="hidden" name="page" value="Banner-Item-Add" />
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Banner Image</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" style="background-image: url('');height:200px;">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" value=""name="img" id="profilePicUpload0" accept=".png, .jpg, .jpeg, .webp" />
                                                <label for="profilePicUpload0" class="bg--primary">Image</label>
                                                <small class="mt-2 text-facebook">
                                                    Supported files: <b>jpeg, jpg, png, webp</b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title" >
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-popup-Password" id="btn-popup-Password" value="Submit"class="btn btn--primary w-100">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModelLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="">
                        <form method="post" id="Form-popup-Section">
                            <input type="hidden" name="id"id="banner_id" value="" />
                            <input type="hidden" name="page"id="banner_page" value="Banner-Item-Edit" />
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Banner Image</label>
                                    <div class="image-upload">
                                        <div class="thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview" id="show_image"style="height:200px;">
                                                    <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type="file" class="profilePicUpload" value=""name="img1" id="profilePicUpload1" accept=".png, .jpg, .jpeg, .webp" />
                                                <label for="profilePicUpload1" class="bg--primary">Image</label>
                                                <small class="mt-2 text-facebook">
                                                    Supported files: <b>jpeg, jpg, png, webp</b>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" placeholder="Title" name="title"id="title" >
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="btn-popup-Password" id="btn-popup-Password" value="Submit"class="btn btn--primary w-100">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> 
        <!-- body-wrapper end -->
        <script>  
            $(document).ready(function() {
                $(document).on('click', '.updateBtn', function() {
                    var id = $(this).data("id");
                    var page = $(this).data("page");
                    if (id != '') {
                        $.ajax({
                            url: "module/get-edit-deta.php",
                            method: "POST",
                            data: {
                                id: id,page: page
                            },
                            success:function(result){
                                var data=jQuery.parseJSON(result);
                                if(data.statusCode=='200'){
                                    $("#banner_id").val(data.id);
                                    $("#banner_page").val('Banner-Item-Edit');
                                    $("#title").val(data.title);
                                    $("#show_image").css("background-image","url('uploads/banner/"+data.image+"')");
                                    $('#editModelLabel').html('Edit Banner Item');
                                    $('#editModel').modal('show');
                                    $("#btn-popup-Password").html('Update');	
                                }
                                
                            }
                        });
                    }
                });
            });
        </script>
        <!-- body-wrapper end -->
    <?php include('inc/footer.php') ?>
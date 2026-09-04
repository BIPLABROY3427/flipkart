<?php
function get_admin_img_url($img)
{
    if (empty($img)) return 'assets/img/squre.png';
    $parts = explode(',', $img);
    $first = trim($parts[0]);
    if (strpos($first, 'http') === 0) return $first;
    return PRODUCT_PATH . $first;
}

$page = 'all-product';
$page1 = 'product';
include('inc/header.php');
?>
<!-- sidebar end -->
<!-- navbar-wrapper start -->
<?php include('inc/sidebar.php') ?>
<!-- navbar-wrapper end -->

<style>
    /* ===== Premium Product Page Styles ===== */
    .product-page-wrapper {
        padding: 24px;
    }

    /* Page Header */
    .product-page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 28px;
    }

    .product-page-header .page-title-area h5 {
        font-size: 22px;
        font-weight: 700;
        color: #2d2d3f;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .product-page-header .page-title-area p {
        font-size: 13px;
        color: #8a92a6;
        margin: 2px 0 0;
    }

    /* Add Button */
    .btn-add-product {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: linear-gradient(135deg, #7367f0 0%, #9c8ff5 100%);
        color: #fff !important;
        border: none;
        border-radius: 12px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 15px rgba(115, 103, 240, 0.4);
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .btn-add-product:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(115, 103, 240, 0.5);
        color: #fff !important;
    }

    .btn-add-product i {
        font-size: 16px;
    }

    /* Stats Bar */
    .product-stats-bar {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .stat-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        border-radius: 14px;
        padding: 14px 20px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
        flex: 1;
        min-width: 140px;
        border-left: 4px solid transparent;
        transition: transform 0.2s ease;
    }

    .stat-pill:hover {
        transform: translateY(-2px);
    }

    .stat-pill.primary {
        border-left-color: #7367f0;
    }

    .stat-pill.success {
        border-left-color: #28c76f;
    }

    .stat-pill.danger {
        border-left-color: #ea5455;
    }

    .stat-pill .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .stat-pill.primary .stat-icon {
        background: rgba(115, 103, 240, 0.12);
        color: #7367f0;
    }

    .stat-pill.success .stat-icon {
        background: rgba(40, 199, 111, 0.12);
        color: #28c76f;
    }

    .stat-pill.danger .stat-icon {
        background: rgba(234, 84, 85, 0.12);
        color: #ea5455;
    }

    .stat-pill .stat-info .stat-num {
        font-size: 22px;
        font-weight: 700;
        color: #2d2d3f;
        line-height: 1;
    }

    .stat-pill .stat-info .stat-label {
        font-size: 12px;
        color: #8a92a6;
        margin-top: 2px;
    }

    /* Card */
    .product-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(0, 0, 0, 0.07);
        overflow: hidden;
        border: none;
    }

    .product-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        border-bottom: 1px solid #f0f0f8;
        flex-wrap: wrap;
        gap: 10px;
    }

    .product-card-header h6 {
        font-size: 15px;
        font-weight: 700;
        color: #2d2d3f;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .product-card-header h6 span.dot {
        width: 8px;
        height: 8px;
        background: #7367f0;
        border-radius: 50%;
        display: inline-block;
    }

    .product-card-body {
        padding: 0;
    }

    /* Table */
    #productTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 13.5px;
    }

    #productTable thead tr {
        background: linear-gradient(135deg, #f8f8ff 0%, #f0eeff 100%);
    }

    #productTable thead th {
        color: #7367f0;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 14px 16px;
        border-bottom: 2px solid #ede9ff;
        white-space: nowrap;
    }

    #productTable tbody tr {
        border-bottom: 1px solid #f5f5ff;
        transition: background 0.2s ease;
    }

    #productTable tbody tr:hover {
        background: #faf9ff;
    }

    #productTable tbody td {
        padding: 12px 16px;
        color: #4a4a6a;
        vertical-align: middle;
        border: none;
    }

    /* Product Image */
    .product-thumb {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        object-fit: contain;
        background: #f8f8ff;
        border: 1px solid #ede9ff;
        padding: 4px;
    }

    /* Product Name */
    .product-name {
        font-weight: 600;
        color: #2d2d3f;
        font-size: 13.5px;
        max-width: 200px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Price Badge */
    .price-mrp {
        color: #aaa;
        text-decoration: line-through;
        font-size: 12px;
    }

    .price-sale {
        font-weight: 700;
        color: #28c76f;
        font-size: 14px;
    }

    /* Rank Input */
    .rank-input {
        width: 72px;
        text-align: center;
        border: 2px solid #ede9ff;
        border-radius: 10px;
        padding: 6px 8px;
        font-size: 13px;
        font-weight: 600;
        color: #7367f0;
        transition: border-color 0.2s;
        background: #faf9ff;
    }

    .rank-input:focus {
        border-color: #7367f0;
        outline: none;
        box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.15);
    }

    /* Action Buttons */
    .action-group {
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }

    .btn-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        border: none;
        border-radius: 8px;
        padding: 5px 12px;
        font-size: 11.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        letter-spacing: 0.3px;
    }

    .btn-status.active-btn {
        background: rgba(40, 199, 111, 0.12);
        color: #28c76f;
    }

    .btn-status.active-btn:hover {
        background: #28c76f;
        color: #fff;
    }

    .btn-status.inactive-btn {
        background: rgba(234, 84, 85, 0.12);
        color: #ea5455;
    }

    .btn-status.inactive-btn:hover {
        background: #ea5455;
        color: #fff;
    }

    .btn-icon-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        transition: all 0.2s ease;
    }

    .btn-edit {
        background: rgba(115, 103, 240, 0.1);
        color: #7367f0;
    }

    .btn-edit:hover {
        background: #7367f0;
        color: #fff;
        transform: scale(1.1);
    }

    .btn-delete {
        background: rgba(234, 84, 85, 0.1);
        color: #ea5455;
    }

    .btn-delete:hover {
        background: #ea5455;
        color: #fff;
        transform: scale(1.1);
    }

    /* SL Badge */
    .sl-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        background: linear-gradient(135deg, #7367f0, #9c8ff5);
        color: #fff;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
    }

    /* DataTables Override */
    #productTable_wrapper .dataTables_filter input {
        border: 2px solid #ede9ff;
        border-radius: 10px;
        padding: 6px 14px;
        font-size: 13px;
        color: #4a4a6a;
    }

    #productTable_wrapper .dataTables_filter input:focus {
        border-color: #7367f0;
        outline: none;
        box-shadow: 0 0 0 3px rgba(115, 103, 240, 0.15);
    }

    #productTable_wrapper .dataTables_length select {
        border: 2px solid #ede9ff;
        border-radius: 10px;
        padding: 4px 10px;
        color: #4a4a6a;
    }

    #productTable_wrapper .dataTables_info {
        color: #8a92a6;
        font-size: 12.5px;
    }

    .paginate_button {
        border-radius: 8px !important;
        margin: 0 2px !important;
        font-weight: 600 !important;
    }

    .paginate_button.current {
        background: linear-gradient(135deg, #7367f0, #9c8ff5) !important;
        border: none !important;
        color: #fff !important;
    }

    .paginate_button:hover:not(.current) {
        background: #f0eeff !important;
        border-color: #ede9ff !important;
        color: #7367f0 !important;
    }

    /* Responsive mobile cards */
    @media (max-width: 768px) {
        .product-page-wrapper {
            padding: 12px;
        }

        .stat-pill {
            min-width: 100%;
        }

        .product-stats-bar {
            gap: 10px;
        }

        .product-card-header {
            padding: 14px 16px;
        }

        .product-name {
            max-width: 140px;
        }

        #productTable thead {
            display: none;
        }

        #productTable tbody tr {
            display: block;
            border: 1px solid #ede9ff;
            border-radius: 14px;
            margin-bottom: 12px;
            padding: 12px;
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
        }

        #productTable tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 4px;
            border-bottom: 1px solid #f5f5ff;
            font-size: 13px;
        }

        #productTable tbody td:last-child {
            border-bottom: none;
        }

        #productTable tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            color: #7367f0;
            letter-spacing: 0.5px;
            min-width: 90px;
        }

        .action-group {
            justify-content: flex-end;
        }

        .btn-add-product {
            font-size: 13px;
            padding: 9px 16px;
        }
    }

    /* Saving animation */
    .rank-input.saving {
        border-color: #ff9f43;
        background: #fff8ed;
    }

    .rank-input.saved {
        border-color: #28c76f;
        background: #f0fff6;
    }
</style>

<div class="body-wrapper">
    <div class="product-page-wrapper">

        <!-- Page Header -->
        <div class="product-page-header">
            <div class="page-title-area">
                <h5><i class="la la-boxes" style="color:#7367f0; margin-right:8px;"></i>Manage Products</h5>
                <p>View, edit & rank all products from here</p>
            </div>
            <button onclick="location.href='product-add.php'" type="button" class="btn-add-product">
                <i class="fa fa-plus"></i> Add New Product
            </button>
        </div>

        <?php
        $total_sql = mysqli_query($con, "SELECT COUNT(*) as total, SUM(status=1) as active, SUM(status=0) as inactive FROM product");
        $stats = mysqli_fetch_assoc($total_sql);
        ?>

        <!-- Stats Bar -->
        <div class="product-stats-bar">
            <div class="stat-pill primary">
                <div class="stat-icon"><i class="la la-boxes"></i></div>
                <div class="stat-info">
                    <div class="stat-num"><?php echo number_format($stats['total']); ?></div>
                    <div class="stat-label">Total Products</div>
                </div>
            </div>
            <div class="stat-pill success">
                <div class="stat-icon"><i class="la la-check-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-num"><?php echo number_format($stats['active']); ?></div>
                    <div class="stat-label">Active</div>
                </div>
            </div>
            <div class="stat-pill danger">
                <div class="stat-icon"><i class="la la-times-circle"></i></div>
                <div class="stat-info">
                    <div class="stat-num"><?php echo number_format($stats['inactive']); ?></div>
                    <div class="stat-label">Inactive</div>
                </div>
            </div>
        </div>

        <!-- Product Table Card -->
        <div class="product-card">
            <div class="product-card-header">
                <h6><span class="dot"></span> All Products</h6>
                <div class="filter-group">
                    <span class="filter-label"><i class="la la-filter"></i> Filter:</span>
                    <span class="filter-badge all" id="filter-all" onclick="filterStatus('')">All</span>
                    <span class="filter-badge active-f" id="filter-active" onclick="filterStatus('active')"><i class="la la-check"></i> Active</span>
                    <span class="filter-badge inactive-f" id="filter-inactive" onclick="filterStatus('inactive')"><i class="la la-times"></i> Inactive</span>
                </div>
            </div>
            <div class="product-card-body">
                <div style="overflow-x:auto; padding: 16px 0;">
                    <table id="productTable" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>MRP</th>
                                <th>Sale Price</th>
                                <th>Views</th>
                                <th>Rank</th>
                                <th>Action</th>
                                <th>status_search</th><!-- hidden col for filter -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = mysqli_query($con, "SELECT * FROM product ORDER BY admin_index DESC, id DESC");
                            $i = 0;
                            while ($data = mysqli_fetch_array($sql)) {
                                $i++;
                                $disc = $data['mrp'] > 0 ? round((($data['mrp'] - $data['price']) / $data['mrp']) * 100) : 0;
                            ?>
                                <tr>
                                    <td data-label="SL">
                                        <span class="sl-badge"><?php echo $i; ?></span>
                                    </td>
                                    <td data-label="Image">
                                        <img src="<?php echo get_admin_img_url($data['image']); ?>" class="product-thumb" alt="product">
                                    </td>
                                    <td data-label="Product Name">
                                        <div class="product-name"><?php echo htmlspecialchars($data['name']); ?></div>
                                        <?php if ($disc > 0): ?>
                                            <span style="font-size:11px; background:rgba(40,199,111,0.12); color:#28c76f; border-radius:6px; padding:2px 7px; font-weight:600;"><?php echo $disc; ?>% OFF</span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="MRP">
                                        <span class="price-mrp">₹<?php echo number_format($data['mrp']); ?></span>
                                    </td>
                                    <td data-label="Sale Price">
                                        <span class="price-sale">₹<?php echo number_format($data['price']); ?></span>
                                    </td>
                                    <td data-label="Views">
                                        <span style="font-size:12px; color:#8a92a6; display:inline-flex; align-items:center; gap:4px;">
                                            <i class="la la-eye" style="color:#7367f0;"></i>
                                            <?php echo number_format(isset($data['views']) ? $data['views'] : 0); ?>
                                        </span>
                                    </td>
                                    <td data-label="Rank">
                                        <input type="number"
                                            class="rank-input admin-index-input"
                                            data-id="<?php echo $data['id']; ?>"
                                            value="<?php echo isset($data['admin_index']) ? $data['admin_index'] : '0'; ?>"
                                            title="Higher = shows first on site">
                                    </td>
                                    <td data-label="Action">
                                        <div class="action-group">
                                            <?php if ($data['status'] == 1) { ?>
                                                <button type="button"
                                                    data-id="<?php echo $data['id']; ?>"
                                                    data-page="product"
                                                    data-status="0"
                                                    class="btn-status active-btn activeBtn">
                                                    <i class="la la-check"></i> Active
                                                </button>
                                            <?php } else { ?>
                                                <button type="button"
                                                    data-id="<?php echo $data['id']; ?>"
                                                    data-page="product"
                                                    data-status="1"
                                                    class="btn-status inactive-btn activeBtn">
                                                    <i class="la la-times"></i> Inactive
                                                </button>
                                            <?php } ?>
                                            <button class="btn-icon-action btn-edit"
                                                onclick="location.href='product-add.php?edit=<?php echo $data['id']; ?>'"
                                                title="Edit Product">
                                                <i class="la la-pencil-alt"></i>
                                            </button>
                                            <button type="button"
                                                data-id="<?php echo $data['id']; ?>"
                                                data-page="product"
                                                class="btn-icon-action btn-delete removeBtn"
                                                title="Delete Product">
                                                <i class="la la-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                    <td style="display:none;"><?php echo $data['status'] == 1 ? 'active' : 'inactive'; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- bodywrapper__inner end -->
</div>
<!-- body-wrapper end -->

<script>
    // Override DataTable init for this page
    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#productTable')) {
            $('#productTable').DataTable().destroy();
        }
        var table = $('#productTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [],
            language: {
                search: '',
                searchPlaceholder: '🔍 Search products...',
                lengthMenu: 'Show _MENU_ per page',
                info: 'Showing _START_–_END_ of _TOTAL_ products',
                paginate: {
                    previous: '<i class="la la-angle-left"></i>',
                    next: '<i class="la la-angle-right"></i>'
                }
            },
            columnDefs: [{
                    orderable: false,
                    targets: [1, 6, 7]
                },
                {
                    visible: false,
                    targets: [8]
                }
            ]
        });

        // ---- Status Filter (no reload) ----
        window.filterStatus = function(status) {
            // Update badge UI
            $('#filter-all, #filter-active, #filter-inactive').removeClass('selected');
            if (status === 'active') {
                $('#filter-active').addClass('selected');
                table.column(8).search('active').draw();
            } else if (status === 'inactive') {
                $('#filter-inactive').addClass('selected');
                table.column(8).search('inactive').draw();
            } else {
                $('#filter-all').addClass('selected');
                table.column(8).search('').draw();
            }
        };
        // Set default badge selected
        $('#filter-all').addClass('selected');

        // Active/Deactive toggle — update button style after change
        $(document).on('click', '.activeBtn', function() {
            var $btn = $(this);
            $.ajax({
                url: 'module/section-active.php',
                type: 'POST',
                data: {
                    id: $btn.data('id'),
                    page: $btn.data('page'),
                    status: $btn.data('status')
                },
                dataType: 'html',
                success: function(result) {
                    var data = jQuery.parseJSON(result);
                    if (data.statusCode == '200') {
                        notify(data.status, data.message);
                        var cur = $btn.attr('data-status');
                        if (cur == '0') {
                            $btn.attr('data-status', '1').data('status', 1);
                            $btn.removeClass('inactive-btn').addClass('active-btn');
                            $btn.html('<i class="la la-check"></i> Active');
                        } else {
                            $btn.attr('data-status', '0').data('status', 0);
                            $btn.removeClass('active-btn').addClass('inactive-btn');
                            $btn.html('<i class="la la-times"></i> Inactive');
                        }
                    } else {
                        notify(data.status, data.message);
                    }
                }
            });
        });

        // Rank Index save with visual feedback
        $(document).on('change', '.admin-index-input', function() {
            var $input = $(this);
            var id = $input.data('id');
            var val = $input.val();
            $input.addClass('saving');
            $.ajax({
                url: 'module/update-index.php',
                type: 'POST',
                data: {
                    id: id,
                    index_val: val
                },
                dataType: 'json',
                success: function(response) {
                    $input.removeClass('saving');
                    if (response.status == 'success') {
                        $input.addClass('saved');
                        notify('success', 'Rank updated!');
                        setTimeout(function() {
                            $input.removeClass('saved');
                        }, 2000);
                    } else {
                        notify('error', 'Error updating rank!');
                    }
                }
            });
        });

        // Delete — remove row without reload
        $(document).on('click', '.removeBtn', function() {
            var $btn = $(this);
            if (!confirm('Are you sure you want to delete this product?')) return;
            $.ajax({
                url: 'module/section-remove.php',
                type: 'POST',
                data: {
                    id: $btn.data('id'),
                    page: $btn.data('page')
                },
                dataType: 'html',
                success: function(result) {
                    var data = jQuery.parseJSON(result);
                    if (data.statusCode == '200') {
                        notify('success', data.message);
                        table.row($btn.closest('tr')).remove().draw(false);
                    } else {
                        notify(data.status, data.message);
                    }
                }
            });
        });
    });
</script>

<?php include('inc/footer.php') ?>

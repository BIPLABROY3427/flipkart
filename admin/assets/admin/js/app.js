'use strict';

$(function(){
  $('#sidebar__menuWrapper').slimScroll({
    height: 'calc(100vh - 86.75px)'
  });
});

$(function(){
  $('.dropdown-menu__body').slimScroll({
    height: '270px'
  });
});

// modal-dialog-scrollable
$(function(){
  $('.modal-dialog-scrollable .modal-body').slimScroll({
    height: '100%'
  });
});

// activity-list 
$(function(){
  $('.activity-list').slimScroll({
    height: '385px'
  });
});

// recent ticket list 
$(function(){
  $('.recent-ticket-list__body').slimScroll({
    height: '295px'
  });
});





$('#navbar-search__field').on('input', function () {
    var search = $(this).val().toLowerCase();


    var search_result_pane = $('.navbar_search_result');
    $(search_result_pane).html('');
    if (search.length == 0) {
        return;
    }

    // search
    var match = $('.sidebar__menu-wrapper .nav-link').filter(function (idx, elem) {
        return $(elem).text().trim().toLowerCase().indexOf(search) >= 0 ? elem : null;
    }).sort();




    // show search result
    // search not found
    if (match.length == 0) {
        $(search_result_pane).append('<li class="text-muted pl-5">No search result found.</li>');
        return;
    }
    // search found
    match.each(function (idx, elem) {
        var item_url = $(elem).attr('href') || $(elem).data('default-url');
        var item_text = $(elem).text().replace(/(\d+)/g, '').trim();
        $(search_result_pane).append(`<li><a href="${item_url}">${item_text}</a></li>`);
    });


});

let img = $('.bg_img');
img.css('background-image', function () {
  let bg = ('url(' + $(this).data('background') + ')');
  return bg;
});

  const navTgg = $('.navbar__expand');
  navTgg.on('click', function(){
    $(this).toggleClass('active');
    $('.sidebar').toggleClass('active');
    $('.navbar-wrapper').toggleClass('active');
    $('.body-wrapper').toggleClass('active');
  });

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

  $('.nice-select').niceSelect();

  // navbar-search 
  $('.navbar-search__btn-open').on('click', function (){
    $('.navbar-search').addClass('active');
  }); 

  $('.navbar-search__close').on('click', function (){
    $('.navbar-search').removeClass('active');
  }); 

  // responsive sidebar expand js 
  $('.res-sidebar-open-btn').on('click', function (){
    $('.sidebar').addClass('open');
  }); 

  $('.res-sidebar-close-btn').on('click', function (){
    $('.sidebar').removeClass('open');
  }); 

/* Get the documentElement (<html>) to display the page in fullscreen */
let elem = document.documentElement;

/* View in fullscreen */
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
  } else if (elem.mozRequestFullScreen) { /* Firefox */
    elem.mozRequestFullScreen();
  } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari and Opera */
    elem.webkitRequestFullscreen();
  } else if (elem.msRequestFullscreen) { /* IE/Edge */
    elem.msRequestFullscreen();
  }
}

/* Close fullscreen */
function closeFullscreen() {
  if (document.exitFullscreen) {
    document.exitFullscreen();
  } else if (document.mozCancelFullScreen) { /* Firefox */
    document.mozCancelFullScreen();
  } else if (document.webkitExitFullscreen) { /* Chrome, Safari and Opera */
    document.webkitExitFullscreen();
  } else if (document.msExitFullscreen) { /* IE/Edge */
    document.msExitFullscreen();
  }
}

$('.fullscreen-btn').on('click', function(){
  $(this).toggleClass('active');
});

$('.sidebar-dropdown > a').on('click', function () {
  if ($(this).parent().find('.sidebar-submenu').length) {
    if ($(this).parent().find('.sidebar-submenu').first().is(':visible')) {
      $(this).find('.side-menu__sub-icon').removeClass('transform rotate-180');
      $(this).removeClass('side-menu--open');
      $(this).parent().find('.sidebar-submenu').first().slideUp({
        done: function done() {
          $(this).removeClass('sidebar-submenu__open');
        }
      });
    } else {
      $(this).find('.side-menu__sub-icon').addClass('transform rotate-180');
      $(this).addClass('side-menu--open');
      $(this).parent().find('.sidebar-submenu').first().slideDown({
        done: function done() {
          $(this).addClass('sidebar-submenu__open');
        }
      });
    }
  }
});

// select-2 init
$('.select2-basic').select2();
$('.select2-multi-select').select2();
$(".select2-auto-tokenize").select2({
  tags: true,
  tokenSeparators: [',']
});
function proPicURL1(input) {
  if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
          var preview = $(input).parents('.thumb').find('.profilePicPreview1');
          $(preview).css('background-image', 'url(' + e.target.result + ')');
          $(preview).addClass('has-image');
          $(preview).hide();
          $(preview).fadeIn(650);
      }
      reader.readAsDataURL(input.files[0]);
  }
}
$(".profilePicUpload1").on('change', function () {
  proPicURL(this);
});

function proPicURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            var preview = $(input).parents('.thumb').find('.profilePicPreview');
            $(preview).css('background-image', 'url(' + e.target.result + ')');
            $(preview).addClass('has-image');
            $(preview).hide();
            $(preview).fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$(".profilePicUpload").on('change', function () {
    proPicURL(this);
});

$(".remove-image").on('click', function () {
    $(this).parents(".profilePicPreview").css('background-image', 'none');
    $(this).parents(".profilePicPreview").removeClass('has-image');
    $(this).parents(".thumb").find('input[type=file]').val('');
});

$("form").on("change", ".file-upload-field", function(){ 
  $(this).parent(".file-upload-wrapper").attr("data-text",$(this).val().replace(/.*(\/|\\)/, '') );
});




//Custom Data Table
$('.custom-data-table').closest('.card').prepend('<div class="card-header" style="border-bottom: none;"><div class="text-right"><div class="form-inline float-sm-right bg--white"><input type="text" name="search_table" class="form-control" placeholder="Search"></div></div></div>');
$('.custom-data-table').closest('.card').find('.card-body').attr('style','padding-top:0px');
var tr_elements = $('.custom-data-table tbody tr');
$(document).on('input','input[name=search_table]',function(){
  var search = $(this).val().toUpperCase();
  var match = tr_elements.filter(function (idx, elem) {
    return $(elem).text().trim().toUpperCase().indexOf(search) >= 0 ? elem : null;
  }).sort();
  var table_content = $('.custom-data-table tbody');
  if (match.length == 0) {
    table_content.html('<tr><td colspan="100%" class="text-center">Data Not Found</td></tr>');
  }else{
    table_content.html(match);
  }
});
$(function() {
  setTimeout(function() { $("#IZIToast").fadeOut(1500); }, 5000)
})
$(document).ready(function(){
  $(".iziToast-close").click(function(){
    $("#IZIToast").fadeOut(1500);
  });
});



/* ========================================================Start Login Area======================================================== */

$(document).ready(function (e) {
  $('#Dashboard-Login').parsley();
  $("#Dashboard-Login").on('submit',(function(e) {
      if($('#Dashboard-Login').parsley().isValid()){
      $("#btn-login").html('<div class="loader1" id="loader12"></div>  Login...');
      $("#btn-login").prop('disabled', true);
      e.preventDefault();
      $.ajax({
          url: "module/login.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                $("#btn-login").html(' Login Successfully <i class="fa fa-check" aria-hidden="true"></i>');
                $("#btn-login").prop('disabled', false);
                $(":input").val('');
                location.href = "dashboard.php";
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                $("#btn-login").html('Login <i class="las la-sign-in-alt"></i>');
                $("#btn-login").prop('disabled', false);
                $(":input").val('');
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

/* ========================================================End Login Area======================================================== */
/* ========================================================Start Logo Area======================================================== */

$(document).ready(function (e) {
  $('#Dashboard-Logo').parsley();
  $("#Dashboard-Logo").on('submit',(function(e) {
      if($('#Dashboard-Logo').parsley().isValid()){
      $("#btn-logo").html('<div class="loader1" id="loader12"></div>  Updating...');
      $("#btn-logo").prop('disabled', true);
      e.preventDefault();
      $.ajax({
          url: "module/logo-fevicon.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                $("#btn-logo").html(' Updated <i class="fa fa-check" aria-hidden="true"></i>');
                $("#btn-logo").prop('disabled', false);
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                $("#btn-logo").html('Update');
                $("#btn-logo").prop('disabled', false);
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

/* ========================================================End Logo Area======================================================== */

/* ========================================================Start Setting Area======================================================== */

$(document).ready(function (e) {
  $('#Dashboard-Setting').parsley();
  $("#Dashboard-Setting").on('submit',(function(e) {
      if($('#Dashboard-Setting').parsley().isValid()){
      $("#btn-Setting").html('<div class="loader1" id="loader12"></div>  Updating...');
      $("#btn-Setting").prop('disabled', true);
      e.preventDefault();
      $.ajax({
          url: "module/General-Setting.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                $("#btn-Setting").html(' Updated <i class="fa fa-check" aria-hidden="true"></i>');
                $("#btn-Setting").prop('disabled', false);
                $("#key").val('');
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                $("#btn-Setting").html('Update');
                $("#btn-Setting").prop('disabled', false);
                $("#key").val('');
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

/* ========================================================End Setting Area======================================================== */

/* ========================================================Start Seo Area======================================================== */

$(document).ready(function (e) {
  $('#Dashboard-seo').parsley();
  $("#Dashboard-seo").on('submit',(function(e) {
      if($('#Dashboard-seo').parsley().isValid()){
      $("#btn-seo").html('<div class="loader1" id="loader12"></div>  Updating...');
      $("#btn-seo").prop('disabled', true);
      e.preventDefault();
      $.ajax({
          url: "module/Manage-SEO.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                $("#btn-seo").html(' Updated <i class="fa fa-check" aria-hidden="true"></i>');
                $("#btn-seo").prop('disabled', false);
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                $("#btn-seo").html('Update');
                $("#btn-seo").prop('disabled', false);
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

/* ========================================================End Seo Area======================================================== */

            $(function () {
            $('input[name=meta_keyword]')
                .on('change', function (event) {
                var $element = $(event.target);
                var $container = $element.closest('.example');

                if (!$element.data('tagsinput')) return;

                var val = $element.val();
                if (val === null) val = 'null';
                var items = $element.tagsinput('items');

                $('code', $('pre.val', $container)).html(
                    $.isArray(val)
                    ? JSON.stringify(val)
                    : '"' + val.replace('"', '\\"') + '"'
                );
                $('code', $('pre.items', $container)).html(
                    JSON.stringify($element.tagsinput('items'))
                );
                })
                .trigger('change');
            });

/* ========================================================Start Profile Area======================================================== */

$(document).ready(function (e) {
  $('#Admin-Profile').parsley();
  $("#Admin-Profile").on('submit',(function(e) {
      if($('#Admin-Profile').parsley().isValid()){
      $("#btn-Profile").html('<div class="loader1" id="loader12"></div>  Updating...');
      $("#btn-Profile").prop('disabled', true);
      e.preventDefault();
      $.ajax({
          url: "module/Manage-Profile.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                $("#btn-Profile").html(' Updated <i class="fa fa-check" aria-hidden="true"></i>');
                $("#btn-Profile").prop('disabled', false);
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                $("#btn-Profile").html('Update');
                $("#btn-Profile").prop('disabled', false);
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

/* ========================================================End Profile Area======================================================== */

/* ========================================================Start Password Area======================================================== */

$(document).ready(function (e) {
  $('#Admin-Password').parsley();
  $("#Admin-Password").on('submit',(function(e) {
      if($('#Admin-Password').parsley().isValid()){
      $("#btn-Password").html('<div class="loader1" id="loader12"></div>  Updating...');
      $("#btn-Password").prop('disabled', true);
      e.preventDefault();
      $.ajax({
          url: "module/Manage-Password.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false, 
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                $("#btn-Password").html(' Updated <i class="fa fa-check" aria-hidden="true"></i>');
                $("#btn-Password").prop('disabled', false);
                $("#old-password").val('');
                $("#new-password").val('');
                $("#cnew-password").val('');
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                $("#btn-Password").html('Update');
                $("#btn-Password").prop('disabled', false);
                $("#old-password").val('');
                $("#new-password").val('');
                $("#cnew-password").val('');
                notify(data.status,data.message);
            }else if(data.statusCode=='202'){
                $("#btn-Password").html('Update');
                $("#btn-Password").prop('disabled', false);
                $("#old-password").val('');
                $("#new-password").val('');
                $("#cnew-password").val('');
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

/* ========================================================End Password Area======================================================== */

/* ========================================================Start Area======================================================== */

$(document).ready(function (e) {
  $('#Form-popup-Section').parsley();
  $("#Form-popup-Section").on('submit',(function(e) {
      if($('#Form-popup-Section').parsley().isValid()){
      $("#btn-popup-Password").html('<div class="loader1" id="loader12"></div>  Saving..');
      e.preventDefault();
      $.ajax({
          url: "module/Section-contect.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
              $("#btn-popup-Password").html('Submit');
              localStorage.setItem('Status',data.status)
              localStorage.setItem('Message', data.message);
               location.reload();	 
            }else if(data.statusCode=='201'){
              $("#btn-popup-Password").html('Submit');
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});


$(document).ready(function (e) {
  $('#Form-popup-Section-Add').parsley();
  $("#Form-popup-Section-Add").on('submit',(function(e) {
      if($('#Form-popup-Section-Add').parsley().isValid()){
      $("#btn-popup-Password").html('<div class="loader1" id="loader12"></div>  Saving..');
      e.preventDefault();
      $.ajax({
          url: "module/Section-contect.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
              $("#btn-popup-Password").html('Submit');
              localStorage.setItem('Status',data.status)
              localStorage.setItem('Message', data.message);
                location.reload();	
            }else if(data.statusCode=='201'){
              $("#btn-popup-Password").html('Submit');
                notify(data.status,data.message);
            }
            
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});
/* ========================================================End  Area======================================================== */
/* ========================================================Start Area======================================================== */

$(function() { 
  $(".removeBtn").on("click", function() {
      $.ajax({
        url: "module/section-remove.php",
        type: "POST",
        data: { "id": $(this).data("id"),"page": $(this).data("page")},
        dataType: "html",
        beforeSend:function(){
          return confirm("Are you sure?");
       },
        success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
              $("#btn-popup-Password").html('Submit');
              localStorage.setItem('Status',data.status)
              localStorage.setItem('Message', data.message);
                location.reload();	
            }else if(data.statusCode=='201'){
              $("#btn-popup-Password").html('Submit');
                notify(data.status,data.message);
            }
          
        },
        error: function(data)
        {
        console.log("error");
        console.log(data);
        }
      });
  });
});
$(function() { 
  $(".removeBtn1").on("click", function() {
      $.ajax({
        url: "module/section-remove1.php",
        type: "POST",
        data: { "id": $(this).data("id"),"page": $(this).data("page")},
        dataType: "html",
        beforeSend:function(){
          return confirm("Are you sure?");
       },
        success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
              $("#btn-popup-Password").html('Submit');
              localStorage.setItem('Status',data.status)
              localStorage.setItem('Message', data.message);
                location.reload();	
            }else if(data.statusCode=='201'){
              $("#btn-popup-Password").html('Submit');
                notify(data.status,data.message);
            }
          
        },
        error: function(data)
        {
        console.log("error");
        console.log(data);
        }
      });
  });
});
/* ========================================================End  Area======================================================== */
$(document).ready(function (e) {
  $('#Form-Section').parsley();
  $("#Form-Section").on('submit',(function(e) {
      if($('#Form-Section').parsley().isValid()){
      e.preventDefault();
      $.ajax({
          url: "module/Section-contect.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          success:function(result){
            var data=jQuery.parseJSON(result);
            if(data.statusCode=='200'){
                notify(data.status,data.message);
            }else if(data.statusCode=='201'){
                notify(data.status,data.message);
            }
            else if(data.statusCode=='20'){
              localStorage.setItem('Status',data.status)
              localStorage.setItem('Message', data.message);
              location.reload();
            }
          },
              error: function(data)
            {
            console.log("error");
            console.log(data);
            }
        });
        }
    }));
});

$(function() {
  $(".newshowBtn").on("click", function() {
    $.ajax({
      url: "module/section-new.php",
      type: "POST",
      data: { "id": $(this).data("id"),"page": $(this).data("page"),"home": $(this).data("home")},
      
      dataType: "html",
      success:function(result){
        var data=jQuery.parseJSON(result);
        if(data.statusCode=='200'){ 
          localStorage.setItem('Status',data.status)
          localStorage.setItem('Message', data.message);
          window.location.reload(); 
        }else if(data.statusCode=='201'){
            notify(data.status,data.message);
        }
        
      },
          error: function(data)
        {
        console.log("error");
        console.log(data);
        }
    });
  });
});
$(function() {
  $(".bestshowBtn").on("click", function() {
    $.ajax({
      url: "module/section-best.php",
      type: "POST",
      data: { "id": $(this).data("id"),"page": $(this).data("page"),"home": $(this).data("home")},
      
      dataType: "html",
      success:function(result){
        var data=jQuery.parseJSON(result);
        if(data.statusCode=='200'){ 
          localStorage.setItem('Status',data.status)
          localStorage.setItem('Message', data.message);
          window.location.reload(); 
        }else if(data.statusCode=='201'){
            notify(data.status,data.message);
        }
        
      },
          error: function(data)
        {
        console.log("error");
        console.log(data);
        }
    });
  });
});
/* ========================================================Start Area======================================================== */
$(function() {
  $(".homeshowBtn").on("click", function() {
    $.ajax({
      url: "module/section-home.php",
      type: "POST",
      data: { "id": $(this).data("id"),"page": $(this).data("page"),"home": $(this).data("home")},
      
      dataType: "html",
      success:function(result){
        var data=jQuery.parseJSON(result);
        if(data.statusCode=='200'){ 
          localStorage.setItem('Status',data.status)
          localStorage.setItem('Message', data.message);
          window.location.reload(); 
        }else if(data.statusCode=='201'){
            notify(data.status,data.message);
        }
        
      },
          error: function(data)
        {
        console.log("error");
        console.log(data);
        }
    });
  });
});
$(function() {
  $(".activeBtn").on("click", function() {
    var $btn = $(this);
    $.ajax({
      url: "module/section-active.php",
      type: "POST",
      data: { "id": $btn.data("id"),"page": $btn.data("page"),"status": $btn.data("status")},
      
      dataType: "html",
      success:function(result){
        var data=jQuery.parseJSON(result);
        if(data.statusCode=='200'){ 
          notify(data.status, data.message);
          var currentStatus = $btn.attr('data-status');
          if (currentStatus == '0') {
              $btn.attr('data-status', '1');
              $btn.data('status', 1);
              $btn.removeClass('btn--success').addClass('btn--danger');
              $btn.text('DEACTIVE');
          } else {
              $btn.attr('data-status', '0');
              $btn.data('status', 0);
              $btn.removeClass('btn--danger').addClass('btn--success');
              $btn.text(' ACTIVE ');
          }
        }else if(data.statusCode=='201'){
            notify(data.status,data.message);
        }
        
      },
          error: function(data)
        {
        console.log("error");
        console.log(data);
        }
    });
  });
});
$(function() {
  $(".activeBtn1").on("click", function() {
    $.ajax({
      url: "module/payment-active.php",
      type: "POST",
      data: { "id": $(this).data("id"),"page": $(this).data("page"),"status": $(this).data("status")},
      
      dataType: "html",
      success:function(result){
        var data=jQuery.parseJSON(result);
        if(data.statusCode=='200'){ 
          localStorage.setItem('Status',data.status)
          localStorage.setItem('Message', data.message);
          window.location.reload(); 
        }else if(data.statusCode=='201'){
            notify(data.status,data.message);
        }
        
      },
          error: function(data)
        {
        console.log("error");
        console.log(data);
        }
    });
  });
});
$(document).ready(function(){
  //get it if Status key found
  if(localStorage.getItem("Status"))
  {
    var status = localStorage.getItem('Status');
    var message = localStorage.getItem('Message');
    notify(status,message);
      localStorage.clear();
  }
});
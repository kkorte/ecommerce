
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });



$("body .product-container").on("click", ".add-to-cart-button", function(e){
   $('body .product-container .add-product').submit();
});


$("body .product-container").on("submit", ".add-product", function(e){
  var $this = $(this);
  e.preventDefault();

    $.post($this.attr('action'), $this.serialize(), function (data) {
        if(data.error) {
            $('#error').dialog('open');
        } else if (data.result == true) {

            $('.cart-count').html(data.producttotal);
            $('.cart-total-inc-price').html(data.total_inc_tax_number_format);
            $('.cart-total-price-ex').html(data.total_ex_tax_number_format);
            $.ajax({
                type: 'GET',
                url: $('.cart-button-ajax').attr('data-url'),
                data: 'format=html'
            }).done(function (html) {

        if($this.hasClass('add-product-mobile')) {
            location.href =  $('.cart-button').attr('href');
        } else {
                $(window).scrollTop(0);
                var dialogUrl = $('.cart-dialog').attr('data-url');
                $.get(dialogUrl, {}, function(data){
                    if(data) {
   
                        $(".cart-dialog").html(data);
                        $(".shopping-cart").fadeIn( "slow");


                    }
                }, 'html');

            }

            });

        } else {
          
        }
    }, 'json');

    e.preventDefault();
});


$("body .product-container").on("change", ".leading-product-combination-select", function(e){
    $(".pulldown").prop('disabled', true);
    $(".add-to-cart-button").prop('disabled', true);

    var amount = $(this).val();
    var url = $(this).attr('data-url') + '/' + amount;
    var name = $(this).attr('name');
    $this = $(this);

    $.ajax({
        url: url,
        type: 'get',
        dataType: 'html',
        success: function (data) {
            $('.product-container').html(data);
                        $('.product-container').html(data).foundation();
            $('body .product-container .photo-container').magnificPopup({
              delegate: 'a', // child items selector, by clicking on it popup will open
              type: 'image',
              gallery:{enabled:true}
              // other options
            }); 
        }
    });
});




$("body .product-container").on("change", ".pulldown", function(e){
    $(".add-to-cart-button").prop('disabled', true);

    var lead = $(".leading-product-combination-select");
    var leadValue = lead.val();

    var value = $(".pulldown").val();
        var amount = $(this).val();

    var url = $(this).attr('data-url') + '/' + amount;

    $.ajax({
        url: url,
        type: 'get',
        dataType: 'html',
        success: function (data) {
            $('.product-container').html(data);
              $('.product-container').html(data).foundation();
            $('body .product-container .photo-container').magnificPopup({
              delegate: 'a', // child items selector, by clicking on it popup will open
              type: 'image',
              gallery:{enabled:true}
              // other options
            });       
        }
    });
});


function updateCart() {

    $.ajax({
        type: 'GET',
        url: $('body .main-cart tfoot.cart-reload').attr('data-url'),
        data: 'format=html',
        global: false
    }).done(function (html) {

        $('.cart-reload').html(html);

    }, 'html');

}


function updateSummaryCart() {
    $.ajax({
        type: 'GET',
        url: $('body .main-cart div.summary-cart-reload').attr('data-url'),
        data: 'format=html',
        global: false
    }).done(function (html) {

        $('.summary-cart-reload').html(html).hide().fadeIn();

    }, 'html');

}


$("body .main-cart").on("click", ".coupon_button", function(e){

    var $this = $( ".coupon_code" );
    
    if($this.val()) {

        var url = $this.attr('data-url') + "/" + $this.val();

        $.get(url, {}, function(data){
            if(data) {
                updateCart();
            }
        }, 'json');
    }

});





$("body .gift-voucher").on("click", ".gift_voucher_button", function(e){

    var $this = $( ".gift_voucher_code" );
    
    if($this.val()) {

        var url = $this.attr('data-url') + "/" + $this.val();

        $.get(url, {}, function(data){
            if(data) {
                updateSummaryCart();
            }
        }, 'json');
    }

});


$("body .main-cart").on("change", ".sending_method_id, .sending_method_country_price_id, .payment_method_id", function(e){

    var $this = $(this);

    var url = $(this).attr('data-url') + "/" + $this.val();

    $.get(url, {}, function(data){
        if(data) {
            updateCart();
        }
    }, 'json');

});

$("body .main-cart").on("click", ".delete-product", function(e){

    e.preventDefault();

    var url = $(this).attr('href');
    $this = $(this);
    
    $.get(url, {

    }, function(data){
        if(data) {  
         
            $($this).parents('.product-row').remove();  
  
            
            if(data.totals) {                
                updateCart();           
            }                
        }else {            
            $('.cart-details').html('<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>Winkelwagen is leeg.</p></div>');
        } 

    }, 'json');  
});


$("body .main-cart").on("keyup change", ".update-amount", function(e){

    e.preventDefault();

    if ($(this).val() == '') {
        return false;
    }

    if (!$.isNumeric($(this).val())) {
        $(this).val(1);
    }

    var amount = $(this).val();
    var url = $(this).attr('data-url') + '/' + amount;
    $this = $(this);

    $.get(url, {

    }, function(data){

        if(data) {

            if(!data.product) {
                $($this).parents('.product-block').remove();   
            }

            $('.total_price_inc_tax_' + data.product_id ).html(data.total_price_inc_tax_number_format);
            $('.total_price_ex_tax_' + data.product_id ).html(data.total_price_ex_tax_number_format); 
             
            if(data.amountNa) {
                $this.val(data.product.quantity);
                var $modal = $('.reveal');
                $modal.html(data.amountNa).foundation('open');
            }

            updateCart();

        } else {
      
            $('.cart-details').html('<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><p>Winkelwagen is leeg.</p></div>');         
        }
    }, 'json');
});


(function(){
 
$('#cart').click(function(e) {
    e.stopPropagation();
    $('.shopping-cart').fadeToggle();
    return false;
});

$(document).click(function() {
    $('.shopping-cart').fadeOut();
});
  
})();



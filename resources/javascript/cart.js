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
            $('.cart-count').html(data.producttotal); 
            
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
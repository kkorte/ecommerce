$("body .product-container").on("click", ".add-to-cart-button", function(e){
    console.log('test');
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
                        $('.cart-dialog .cart-dialog-container').html(data);
                        $('.cart-dialog').show();

                        $('.cart-button-ajax').trigger('click');
                                     

                        $(window).scroll(function() {
                            var timeoutHandle = setTimeout(function() {
                                    $('.small-menu [data-dropdown]').trigger('close');
                            }, 1000); 
                        });

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



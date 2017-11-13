$.ajaxSetup(
{
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }
});



var currentFilter = '';  

   $(window).bind('hashchange', function () {
       
        var data = $('div').data('.category'), url = $('.filter-form').attr('action'), 
            filter = $.bbq.getState('filter') || '';
            
        if (filter == currentFilter) {
            return false;
        }        
            
        $.get(url, {'format': 'json', 'currentFilters': filter, 'fromHash': true}, function (result) {
            $('.category').html(result.html);
            
            setHash = result.setHash;

        });
    });
    
    
    $(window).trigger('hashchange');


    var delay = (function(){
      var timer = 0;
      return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
      };
    })();  





    $("body .category").on("click", ".ajax-page-click", function(e){

        e.preventDefault();
        var page = $(this).attr('data-target');
        var data = $('div').data('.category'), url = $('.filter-form').attr('action'), 
            filter = $.bbq.getState('filter') || '';
            
        if (filter == currentFilter) {
            return false;
        }        
            
        $.get(url, {'format': 'json', 'currentFilters': filter, 'page': page, 'fromHash': true}, function (result) {
            $('.category').html(result.html);
            
            setHash = result.setHash;
            

        });


    }); 




    $(document).delegate('.filters .filter-checkbox', 'click', function (e) {

        delay(function(){  
        setHash = true;
        if (setHash === false) {
            return false;
        }
        var form  = $('.filter-form');
        var serialized = form.serialize(), url = form.attr('action');
        $(".filters .filter-checkbox").attr("disabled", true);
        $.getJSON(url, serialized, function (result) {
            var state = {}, data = $('div').data('products');
            
            currentFilter = result.hash;

            //data.hash = result.hash;
            //data.cache[result.hash] = result.html;

            state['filter'] = result.hash;
            $.bbq.pushState(state);

            $('.category').html(result.html);
        });
        
        return true;
        }, 500 );
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
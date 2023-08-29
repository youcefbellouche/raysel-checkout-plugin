(function ($) {
    $(document).ready(function(){
        var product_type = ""
        if($('input[name=product_type]')[0]){
            product_type = $('input[name=product_type]')[0].value
            var shipping_prices = wpData.shipping
        }
        // Variation Product
        if(product_type == "variable"){
            $(document).on("change", ".variations_form", function (e) {
                var variation_id = $('.variation_id')[0].value
                var wilaya = $('.rwc-wilaya-select')[0].value
                if(wilaya && variation_id ){
                    var shipping = $('.rwc-shipping-select')[0].value
                    if(shipping){
                        $.ajax({
                            url: wpData.ajaxurl,
                            type: 'POST',
                            data: {
                                action: 'get_variation_price',
                                variation_id: variation_id
                            },
                            success: function(response){
                                const quantity = parseInt($(".rwc-quantity")[0].value)
                                if(shipping == "seller"){
                                    const total = parseFloat(response * quantity) 
                                    $('#rwc-total-price')[0].innerHTML = ` ${response * quantity} + 0 =  ${total} دج`
                                }else if(shipping == "selling_point"){
                                    const total = parseFloat(response * quantity) + parseFloat( shipping_prices[wilaya][shipping])
                                    $('#rwc-total-price')[0].innerHTML = ` ${response * quantity} + ${shipping_prices[wilaya][shipping]} =  ${total} دج`
                                    
                                }else if(shipping == "regulare"){
                                    if(! shipping_prices[wilaya][shipping]){
                                        shipping_prices[wilaya][shipping] = 0 
                                    }
                                    const total = parseFloat(response * quantity) + parseFloat( shipping_prices[wilaya][shipping])
                                    $('#rwc-total-price')[0].innerHTML = ` ${response * quantity} + ${shipping_prices[wilaya][shipping]} =  ${total} دج`
                                }else{
                                    $('#rwc-total-price')[0].innerHTML = ""
                                }
                            }
                        })
                    }
                }else{
                    $('#rwc-total-price')[0].innerHTML = ""
                }
            })
        }else{
            // Simple Product
            $(document).on("change",".rwc-order-form",function(e){
                const productPrice = $('#rwc-product-price')[0].value
                var wilaya = $('.rwc-wilaya-select')[0].value
                var shipping = $('.rwc-shipping-select')[0].value
                const quantity = parseInt($(".rwc-quantity")[0].value)
                if(shipping == "seller"){
                    const total = parseFloat(productPrice * quantity) 
                    $('#rwc-total-price')[0].innerHTML = ` ${productPrice * quantity} + 0 =  ${total} دج`
                }else if(shipping == "selling_point"){
                    const total = parseFloat(productPrice * quantity) + parseFloat( shipping_prices[wilaya][shipping])
                    $('#rwc-total-price')[0].innerHTML = ` ${productPrice * quantity} + ${shipping_prices[wilaya][shipping]} =  ${total} دج`
                    
                }else if(shipping == "regulare"){
                    if(! shipping_prices[wilaya][shipping]){
                        shipping_prices[wilaya][shipping] = 0 
                    }
                    const total = parseFloat(productPrice * quantity) + parseFloat( shipping_prices[wilaya][shipping])
                    $('#rwc-total-price')[0].innerHTML = ` ${productPrice * quantity} + ${shipping_prices[wilaya][shipping]} =  ${total} دج`
                }else{
                    $('#rwc-total-price')[0].innerHTML = ""
                }
            })
        }
    })

})(jQuery);
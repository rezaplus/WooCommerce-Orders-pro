function set_price(elm,product_id,productName ,regular_price,sale_price)
{   
        regular_price = prompt(OrdersPro_localize.regular_price,regular_price);
        if(regular_price===null)return;
        sale_price = prompt(OrdersPro_localize.sale_price,sale_price);
        if(sale_price===null)return;
        if(regular_price <= sale_price)
        {
            alert(OrdersPro_localize.sale_price_is_not_true_alert);
            return;
        }
        orderPro_Price_ajax(elm,product_id,regular_price,sale_price);
}

function orderPro_Price_ajax(elm,product_id,regular_price,sale_price){
    jQuery("img",elm).addClass('op_waiting');
    jQuery.ajax({
        data: {action: 'orderPro_Price_new' ,regular_price: regular_price, sale_price : sale_price,product : product_id},type: 'GET',dataType: 'text',url: ajaxurl,success: function(data) {
            jQuery("img",elm).removeClass('op_waiting');
            jQuery("div",elm).replaceWith("<div>" + data + "</div>");
    }   });
}
function orderPro_Stock_quantity_ajax(elm,manage_stock,product_id,stock_quantity){
    if(!manage_stock)return;
    var quantity_val = prompt(OrdersPro_localize.Stock_prompt,stock_quantity);
    if(quantity_val===null)return;
        jQuery("img",elm).addClass('op_waiting');
    jQuery.ajax({
        data: {action: 'OrderPro_Stock_quantity' ,quantity: quantity_val, product : product_id, manage_stock:manage_stock},type: 'GET',dataType: 'text',url: ajaxurl,success: function(data) {
            if(data == 'premium'){location.reload();}
            jQuery("img",elm).removeClass('op_waiting');
            jQuery("p",elm).replaceWith(data);
    }   });
}
function stock_manage_confirm()
{
    if(confirm(OrdersPro_localize.enable_stock_management)){return true;}else{alert(OrdersPro_localize.inactive_manage_stock);return false;}
}
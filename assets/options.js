jQuery(document).ready(function(){
    var urlParams = new URLSearchParams(window.location.search);
    if(!urlParams.has('tab')){
        tab_change('orders_tab');
    }else{
        tab_change(urlParams.get('tab'));
    }
});

//Options Tab
jQuery( "#tabs_buttons li" ).click(function() {
    var button_id = jQuery(this).attr('id');
    tab_change(button_id);
});
function tab_change(id){
    jQuery('#tabs_buttons li').css('color','#0381ec');
    jQuery('#tabs_sections > li').css('display', 'none');
     jQuery('#tabs_sections li.OP_options_section').each(function(){
     if(jQuery(this).attr('name')==id){jQuery(this).css('display', 'block');jQuery('#'+id).css('color','black');}
     if(id=='license'){jQuery('#save_settings_Orders_pro').css('display','none');}else {jQuery('#save_settings_Orders_pro').css('display','block');}
    });
}
//save options ajax
function OrderPro_settings_save(OrderPro_Column,OrderPro_translations,Orders_options){
    jQuery.ajax({
        data: {action: 'OrderPro_settings_save',
        OrderPro_Column: OrderPro_Column,
        OrderPro_translations:OrderPro_translations,
        Orders_options:Orders_options
    },
    type: 'POST', dataType: 'text',url: ajaxurl,  beforeSend: function(){
        jQuery('#save_settings_Orders_pro').prop( "disabled", true );jQuery('.OrderPro_loading').css('display','inline');jQuery('.OrderPro_Done').css('display','none');
        },success:function(data) {jQuery('#save_settings_Orders_pro').prop( "disabled", false );jQuery('.OrderPro_Done').css('display','inline');jQuery('.OrderPro_loading').css('display','none');}
    });

}
//pass data to ajax
jQuery( "#save_settings_Orders_pro").click(function() {
    OrderPro_settings_save(OrderPro_Column_ArrayGenerator(),OrderPro_translations_ArrayGenerator(),OrderPro_Orders_options_ArrayGenerator());
});
//array generator for ajax data
function OrderPro_Column_ArrayGenerator()
{
    var columns = {};
    jQuery(".ordersPro_columns_settings  li").each(function() {
        column  = jQuery(this).attr('id');
        data = jQuery('.visibleicon',this).attr('data');
        columns[column] = data;
    });
    return columns;
}
//array generator for ajax data
function OrderPro_translations_ArrayGenerator()
{
    var translations = {};
    jQuery("#OP_Translations td input[type='text']").each(function() {
        translationID  = jQuery(this).attr('name');
        translationValue = jQuery(this).val();
        translations[translationID] = translationValue;
    });
  return translations;
}
//array generator for ajax data
function OrderPro_Orders_options_ArrayGenerator()
{
    var Orders_options = {};
    jQuery("li[name='orders_tab'] td input").each(function() {
        FieldID  = jQuery(this).attr('name');
        if(jQuery(this).prop("checked")){FieldValue = 'checked';}else{FieldValue = 'unchecked';}
        Orders_options[FieldID] = FieldValue;
    });
  return Orders_options;
}

//sortable order preview columns
jQuery(".ordersPro_columns_settings ul").sortable({
    revert: true,placeholder: "ui-state-highlight",cursor: "move",axis: "y",handle:'.sort',
    update: function (event, ui) {
}
});
//sort order preview columns
jQuery(function() {
    jQuery(".ordersPro_columns_settings li").sort(sort_li).appendTo('.ordersPro_columns_settings ul');
        function sort_li(a, b) {
            return (jQuery(b).data('position')) < (jQuery(a).data('position')) ? 1 : -1;
        }
});
//order preview enable columns
jQuery( ".ordersPro_columns_settings .visibleicon" ).click(function() {
    if(jQuery(this).attr('data')==="true"){jQuery(this).attr('data','false');}
    else{jQuery(this).attr('data','true');}
});

//onMobile checkbox control
jQuery("#OP_Orders input[name='enable_onMobile']").change(function()
{
    if(this.checked) {jQuery( "#OP_Orders .OP_Orders_subset" ).prop( "disabled", false );}
    else {jQuery( "#OP_Orders .OP_Orders_subset" ).prop( "disabled", true );}
});
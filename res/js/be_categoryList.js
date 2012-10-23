$.noConflict();
jQuery(document).ready(function() {
    jQuery('.category_tree li').click(function(){
        var select = jQuery(this).parents('.thumbnails').siblings(':first-child').children('select');
        console.log(select);
    })
});
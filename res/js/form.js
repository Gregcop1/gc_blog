jQuery.noConflict();

jQuery(document).ready(function(){
    jQuery('.tx-gcblog-pi1 a.reply').click(commentFormReply)
    jQuery('.tx-gcblog-pi1 a.cancel').click(commentFormCancelReply)
});

function commentFormReply() {
    var form = jQuery('#commentForm');
    var replyTo = form.find('p.replyTo');
    var replyToField = form.find('input.replyTo');

    replyTo.children('.name').html(jQuery(this).attr('reply-name'))
    replyToField.attr('value',jQuery(this).attr('reply-uid'))
    replyTo.show();
}

function commentFormCancelReply() {
    var form = jQuery('#commentForm');
    var replyTo = form.find('p.replyTo');
    var replyToField = form.find('input.replyTo');

    replyTo.children('.name').html('');
    replyToField.attr('value','');
    replyTo.hide();
}
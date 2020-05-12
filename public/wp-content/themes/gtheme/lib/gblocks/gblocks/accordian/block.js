jQuery(document).ready(function($){

    $('.block-accordian .item-title, .block-accordian .item-container > i.fa').on('click', function(){
        $(this).closest('.item-container').toggleClass('open');
        $(this).closest('.item-container').find('.item-content').animate({
            height: "toggle",
            opacity: "toggle"
        }, 200);
    });
    
    $('.block-accordian .item-container .item-content').css('display', 'block');
	$('.block-accordian .item-container:not(.open) .item-content').hide();

});

/**
 * Created by Dan on 4/27/2016.
 */
$(function() {
    $('.popImage').on('click', function(e) {
        e.preventDefault();
        $('.imagepreview').attr('src', $(this).find('img').attr('src'));
        $('.addToCart').attr('href', "views/added.php?id=" + $(this).closest('div').find('.item-id').text());
        $('.addToCart').attr('href', "views/added.php?id=" + $(this).parent().parent().find('div').filter('.item-id').text()); //MS Edge Override

        $('#imagemodal').modal('show');
    });
});

$(function() {
    var productType;

    $('.popDetails').on('click', function(e) {
        e.preventDefault();
        $('.imagepreview').attr('src', $(this).find('img').attr('src'));
        $('#postTitle').val($(this).parent().next().children().find('a').text());
        console.log($(this).parent().parent().find('div').filter('.item-id').text());
        $('#postDesc').val($(this).parent().next().children().filter('.productDesc').text());
        $('#postPrice').val($(this).parent().next().next().filter('.price').text().substr(1));
        $('#postMinPrice').val($(this).parent().next().next().next().children().filter('.minPrice').text().substr(1));
        $('#postQuantity').val($(this).parent().next().next().next().children().filter('.quantity').text());
        productType = $(this).parent().next().children().filter('.category').find('span').text();
        console.log(productType);
        $('#postType').find('option[value=' + productType + ']').attr('selected',true);
        $('#updateButton').closest('form').attr('action', "views/shop.php?update=true&id=" + $(this).closest('div').find('.item-id').text());
        $('#updateButton').closest('form').attr('action', "views/shop.php?update=true&id=" + $(this).parent().parent().find('div').filter('.item-id').text()); //MS Edge Override

        $('#productmodal').modal('show');
    });

    $('#productmodal').on('hide.bs.modal', function () {
        $('#postType').find('option[value=' + productType + ']').removeAttr('selected');
        console.log($('#postType').find('option[value=' + productType + ']'));
    });
});

$(function(){
    $("table td a.delete").on('click', function (e) {
        e.preventDefault();

        $(this).closest('tr').fadeTo(400, 0, function () {
            //$(this).toggleClass('hidden', true);

        });
        $(this).closest('tr').find('input').val('0');

        toastr.warning("Please press the 'Update Cart' button to save your changes.");
        toastr.options.timeOut = 30; // How long the toast will display without user interaction

        return false;
    });
});

$(function() {
    $('.quickview').hover(function() {
        $('.btn-quickview').show();
        $('.btn-quickview').fadeIn();
        $('.quickview').show();
        $('.quickview').fadeIn();
    }, function() {
        $('.btn-quickview').fadeOut();
    });
});

$(function() {
    $('.remove-product').on('click', function(e) {
        e.preventDefault();
        $('#yes-confirmation').attr('href', "views/shop.php?remove=" + $(this).find('.item-id').text());
        $('#removeProductModal').modal('show');
    });
});

var $body = $(document.body);
var oldWidth = $body.innerWidth();

$('.modal').on('shown.bs.modal', function (e) {
    $('body').css('overflow-y', 'hidden');
    $('body').css("overflow", "hidden");
    $('body').width(oldWidth);
});
$('.modal').on('hidden.bs.modal', function (e) {
    $('body').css('overflow-y', '');
    $('body').css("overflow", "auto");
    $('body').width("auto");
});
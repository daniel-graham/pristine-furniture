/**
 * Created by Dan on 4/16/2016.
 */
function validate()
{
    $('#footer').toggleClass('hidden', true); //hide footer on validate
    $('#postItem').parsley().on('field:validated', function(formInstance) {
            var ok = $('.parsley-error').length === 0;
            //$('#footer').toggleClass('hidden', !ok);
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        })
        .on('form:submit', function() {
            // Display a success toast, with a title
            toastr.success('Thank You! Your product is being posted.');
            return true; // send to server
        });



}

function validateLogin(){
    $('#login').parsley().on('field:validated', function(formInstance) {
            var ok = $('.parsley-error').length === 0;
            //$('#footer').toggleClass('hidden', !ok);
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        })
        .on('form:submit', function() {
            // Display a success toast, with a title
            toastr.success('Logging you in.');
            return true; // send to server
        });
}

function  validateFileUpload(){
    $('#imageUploader').parsley().on('field:validated', function(formInstance) {
            var ok = $('.parsley-error').length === 0;
            //$('#footer').toggleClass('hidden', !ok);
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        })
        .on('form:submit', function() {
            // Display a success toast, with a title
            toastr.success('Thank You! Your file is being uploaded.');
            return true; // send to server
        });
}
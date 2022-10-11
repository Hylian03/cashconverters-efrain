$( document ).ready(function() {
    filterModels();
});

$('#product_brand').on('change', function() {
    filterModels();
});

$('#product_ean').on('keyup', function() {
    validateField($(this), 'ean', 'The value is not valid EAN');
});

$('#product_imei').on('keyup', function() {
    validateField($(this), 'imei', 'The value is not valid IMEI');
});

function filterModels() {

    let brandId = parseInt($('#product_brand option:selected').val());
    let model = $('#product_model');
    let modelOptions = model.find('option[data-brand]');

    model.prop('selectedIndex',0);
    modelOptions.addClass('d-none');
    modelOptions.attr('disabled', true);

    modelOptions.each(function( index ) {
        if($(this).data('brand') == brandId) {
            $(this).removeClass('d-none');
            $(this).attr('disabled', false);
        }
    });

};

function validateField(field, validateType, errorMsg) {
    let submitButton = $('#product_submit');
    let parent = field.closest('div');
    let errorLabel = parent.find('.error');

    let isValid = false;
    switch (validateType) {
        case 'ean':
            isValid = isValidEAN(field.val());
            break;
        case 'imei':
            isValid = isValidIMEI(field.val());
            break;
        default:
            throw 'Invalid validateType';
    }

    if(!isValid && field.val().length > 0) {
        submitButton.attr('disabled',true);
        if(errorLabel.length === 0){
            parent.append(`
                <label id="fullname-error" class="error col-sm-9 offset-sm-3" for="fullname">${errorMsg}.</label>
            `);
        }
    } else {
        submitButton.attr('disabled',false);
        errorLabel.remove();
    }
}
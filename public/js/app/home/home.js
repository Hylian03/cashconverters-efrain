document.addEventListener("DOMContentLoaded", function(event) {

    // Categories

    $.ajax({
        type: 'GET',
        url: 'http://127.0.0.1:8000/api/v1/category',
        dataType: 'json',
        success: function(data) {

            var datatableCategories = $('#datatable-categories');

            datatableCategories.closest('.card-body').removeClass('d-none');
            datatableCategories.closest('section').find('.card-body.mb-5').addClass('d-none');

            for (let category of data) {
                let createdAtFormat = formatDate(getDateByString(category.createdat));
                let updatedAtFormat = formatDate(getDateByString(category.updatedat));
                datatableCategories.find('tbody').append(`
                    <tr>
                        <td class="text-center"><a href="/category/${category.id}/features" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a></td>
                        <td>${category.name}</td>
                        <td>${category.description}</td>
                        <td class="${category.status.classname}">${category.status.name}</td>
                        <td>${createdAtFormat}</td>
                        <td>${updatedAtFormat}</td>
                        <td>${category.products.length}</td>
                    </tr>
                `);
            }
            datatableCategories.DataTable();
        },
        error: function (data) {
            console.log('Error');
        }
    });

    // Products

    $.ajax({
        type: 'GET',
        url: 'http://127.0.0.1:8000/api/v1/product',
        dataType: 'json',
        success: function(data) {

            var datatableProducts = $('#datatable-products');

            datatableProducts.closest('.card-body').removeClass('d-none');
            datatableProducts.closest('section').find('.card-body.mb-5').addClass('d-none');

            for (let product of data) {
                let createdAtFormat = formatDate(getDateByString(product.createdat));
                let updatedAtFormat = formatDate(getDateByString(product.updatedat));
                datatableProducts.find('tbody').append(`
                    <tr>
                        <td>${product.brand ? product.brand.name  : ''}</td>
                        <td>${product.model ? product.model.name  : ''}</td>
                        <td>${product.title}</td>
                        <td>${product.platform ? product.platform.name  : ''}</td>
                        <td>${product.ean ? product.ean  : ''}</td>
                        <td>${product.imei ? product.imei  : ''}</td>
                        <td>${product.category.name}</td>
                        <td class="${product.status.classname}">${product.status.name}</td>
                        <td>${createdAtFormat}</td>
                        <td>${updatedAtFormat}</td>
                    </tr>
                `);
            }
            datatableProducts.DataTable();
        },
        error: function (data) {
            console.log('Error');
        }
    });

});

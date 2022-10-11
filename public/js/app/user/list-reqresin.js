document.addEventListener("DOMContentLoaded", function(event) {

    // Users repres.in

    let numberOfPagesPublic = 2;
    let fullUsers = [];
    let finishedPages = 0;

    for (let cont=1; cont <= numberOfPagesPublic; cont++) {
        $.ajax({
            type: 'GET',
            url: 'https://reqres.in/api/users?page='+cont,
            dataType: 'json',
            success: function(data) {
                fullUsers = fullUsers.concat(data.data);
                finishedPages++;
                if(finishedPages == numberOfPagesPublic) {
                    renderUsers(fullUsers);
                }
            },
            error: function (data) {
                console.log('Error');
            }
        });
    }

});

function renderUsers(users)
{
    let datatableCategories = $('#datatable-users-reqresin');

    datatableCategories.closest('.card-body').removeClass('d-none');
    datatableCategories.closest('section').find('.card-body.mb-5').addClass('d-none');

    for (let user of users) {
        let createdAtFormat = formatDate(getDateByString(user.createdat));
        let updatedAtFormat = formatDate(getDateByString(user.updatedat));
        datatableCategories.find('tbody').append(`
            <tr>
                <td>${user.id}</td>
                <td>${user.email}</td>
                <td>${user.first_name}</td>
                <td>${user.last_name}</td>
                <td><a href="${user.avatar}" target="_blank"><img class="avatar" src="${user.avatar}" title=" Avatar of ${user.first_name}"></img></a></td>
            </tr>
        `);
    }
    datatableCategories.DataTable();
}
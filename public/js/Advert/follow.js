
function follow(id, csrfToken)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': csrfToken
        },
        url: '/advert/' + id + '/follow',
        type: "PUT",
        data: '',
        success: function ()
        {
            window.location.reload();
        },
    });
}

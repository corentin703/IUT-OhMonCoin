
function follow(id, csrfToken)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': csrfToken
        },
        url: '/adverts/' + id + '/follow',
        type: "POST",
        data: '',
        success: function ()
        {
            window.location.reload();
        },
    });
}


function follow(id, csrfToken)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': csrfToken
        },
        url: '/advert/follow',
        type: "PUT",
        data: 'id=' + id,
        success: function ()
        {
            window.location.reload();
        },
    });
}

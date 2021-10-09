
function pictureDelete(id, csrfToken)
{
    $.ajax({
        headers:
        {
            'X-CSRF-TOKEN': csrfToken
        },
        url: '/pictures/' + id,
        type: "DELETE",
        data: 'id=' + id,
        success: function ()
        {
            window.location.reload();
        },
    });
}

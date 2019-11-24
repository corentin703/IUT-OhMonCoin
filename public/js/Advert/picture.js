
function pictureDelete(id, csrf)
{
    $.ajax({
        headers:
            {
                'X-CSRF-TOKEN': csrf
            },
        url: '/picture/' + id,
        async: false,
        type: "DELETE",
        data: 'id' + id,
        success: function ()
        {
            window.location.reload();
        },
    });
}


const renderHtmlInComponent = (url) => {
    $.ajax({
        async: false,
        type: 'GET',
        url: url,
        success: function(data) {
            $('.modal-body').html(data);
        }
   });
}

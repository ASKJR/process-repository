
const renderHtmlInComponent = (url, modalBodyId) => {
    $.ajax({
        async: false,
        type: 'GET',
        url: url,
        success: function(data) {
            $('#'+ modalBodyId).html(data);
        }
   });
}


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


//file logic
$(document).on("click", ".browse", function() {
  var file = $(this)
    .parent()
    .parent()
    .parent()
    .find(".file");
  file.trigger("click");
});
$(document).on("change", ".file", function() {
  $(this)
    .parent()
    .find(".form-control")
    .val(
      $(this)
        .val()
        .replace(/C:\\fakepath\\/i, "")
    );
});


function doLoad(id) {
    url = '/api.php?action=code&id=' + id;
    getCode(url);
}

function getCode(url) {
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        success: function(data){
            showCode(data);
        }
    });
}

function showCode(data) {
    console.log(data);
    $('#code').text(data.code);
}
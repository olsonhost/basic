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
    $('.save').removeClass('disabled');
    $('.leftside').html('<h3>' + data.To + '</h3><ul><li>New Function</li><li>New Library</li><li><ol><li>Main</li></ol></li></ul>')
}

$('.save').on('click', function() {
    $('.bottomside').html('Program Saved');
    // Save the contents of #code back into the database



});
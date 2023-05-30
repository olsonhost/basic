var codeId=false;
var codeTo=false;

function doLoad(id) {
    var url = '/api.php?action=code&id=' + id;
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
    codeId = data.id;
    codeTo = data.To;
    $('#code').text(data.code);
    $('.save').removeClass('disabled');
    $('.run').removeClass('disabled').attr('href', '/basic.php?To=' + data.To + '&From=' + data.To);
    $('.leftside').html('<h3>' + data.To + '</h3><ul><li>New Function</li><li>New Library</li><li><ol><li>Main</li></ol></li></ul>');
    $('.topside').html('Set your Webhook URL to <u>https://evodialer.com/basic.php</u> and dial ' + data.To);
}

$('.save').on('click', function() {
    var url = '/api.php?action=code';
    var code = document.getElementById('code').innerText;
    var data = {'id': codeId, 'To': codeTo, 'code': code};
    storeCode(url, data);
});

function storeCode(url, data) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: url,
        data: data,
        success: function(data){
            $('.bottomside').html('Program Saved'); // make this a scrolling log where we can also post call status updates!
        },
        error: function(a, b, c) {
            console.log(a);
            console.log(b);
            console.log(c);
            $('.bottomside').html('ERROR SAVING PROGRAM!');
        }
    });
}
// hàm xử lý ảnh khi update book lưu lại các id ảnh và sẽ đưa lên input hidden 
// xử lý ảnh bên bookController
//áp dụng với file sửa
function removeGalleryImg(el, galleryId = 0) {
    $(el).parent().parent().remove();
    if (galleryId !== 0) {
        let removeIds = $(`[name="removeGalleryIds"]`).val();
        removeIds += `${galleryId}|`
        $(`[name="removeGalleryIds"]`).val(removeIds);
    }
}
//hàm dùng để upload ảnh lên sẽ hiện thì ảnh ngay dưới dạng base64
//hàm này áp dụng vào file sửa
function loadFiles(event, el_rowId) {
    var reader = new FileReader();
    var output = document.querySelector(`img[row_id="${el_rowId}"]`);
    reader.onload = function() {
        output.src = reader.result;
    };
    if (event.target.files[0] === undefined) {
        output.src = "";
        return false;
    } else {
        reader.readAsDataURL(event.target.files[0]);
    }
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        document.getElementById("cc").style.display = 'block';


        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

//hàm dùng để xóa ảnh upload lên 
//áp dụng với file add
function removeImg(el) {
    $(el).parent().parent().remove();
}
//hàm dùng để xóa dữ liệu của 1 bảng bằng ajax
//áp dụng với file index
function deleteData(id) {

    if (confirm('Bạn có chắc chắn muốn xóa mục này ?')) {
        $.ajax({
            url: $('#deleteUrl' + id).data('url'),
            type: 'DELETE',
            data: {
                _token: $("input[name=_token]").val()
            },
            success: function(data) {
                if (data.empty) {
                    $('div.alert-success').html('<span class="text-success">' + data.success);
                } else {
                    $('div.alert-success').html('<span class="text-success">' + data.success + ' <a href="javascript:void(0);" id="undoIndex" data-id="' + id + '">Hoàn tác</a></span>');
                }
                $('div.alert-success').css('display', 'block');
                $('#' + id).remove();
            },
        });
    }
}
//khôi phục dữ liệu của 1 bảng 
function restoreData(id) {
    if (confirm('Bạn có chắc chắn muốn khôi phục mục này ?')) {
        $.ajax({
            url: $('#restoreUrl' + id).data('url'),
            type: 'GET',
            data: {
                _token: $("input[name=_token]").val()
            },
            success: function(data) {
                if (data.empty) {
                    $('div.alert-success').html('<span class="text-success">' + data.success);
                } else {
                    $('div.alert-success').html('<span class="text-success">' + data.success + ' <a href="javascript:void(0);" id="undoTrashed" data-id="' + id + '">Hoàn tác</a></span>');
                }
                $('div.alert-success').css('display', 'block');
                $('#' + id).remove();
            },
        });
    }
}
//check input checkbox
$('#checkAll').click(function() {
    $('.checkPro').prop('checked', $(this).prop('checked'));
});

// delete column data multiple table index
function deleteMul(route, allId) {
    $.ajax({
        url: route,
        type: 'DELETE',
        data: {
            _token: $("input[name=_token]").val(),
            allId: allId
        },
        success: function(data) {
            $('div.alert-success').text(data.success);
            $('div.alert-success').css('display', 'block');
            $.each(allId, function(key, val) {
                $('#' + val).remove();
            })
        },
    });
}

// restore column data multiple table trash
function restoreMul(route, allId) {
    $.ajax({
        url: route,
        type: 'get',
        data: {
            _token: $("input[name=_token]").val(),
            allId: allId
        },
        success: function(data) {
            $('div.alert-success').text(data.success);
            $('div.alert-success').css('display', 'block');
            $.each(allId, function(key, val) {
                $('#' + val).remove();
            })
        },
    });
}

// remove column data multiple table trash and index
function removeMul(route, allId) {
    $.ajax({
        url: route,
        type: 'delete',
        data: {
            _token: $("input[name=_token]").val(),
            allId: allId
        },
        success: function(data) {
            $('div.alert-success').text(data.success);
            $('div.alert-success').css('display', 'block');
            $.each(allId, function(key, val) {
                $('#' + val).remove();
            })
        },
    });
}

//remove forever data table trash

function removeForever(id) {
    if (confirm('Bạn có chắc chắn muốn xóa mục này ?')) {
        $.ajax({
            url: $('#deleteUrl' + id).data('url'),
            type: 'delete',
            data: {
                _token: $("input[name=_token]").val(),
                id: id
            },
            success: function(data) {
                $('div.alert-success').html(data.success);
                $('div.alert-success').css('display', 'block');
                $('#' + id).remove();
            },
        });
    }
}
//undo trash data table
function undoTrash(route, id) {
    $.ajax({
        url: route,
        type: 'DELETE',
        method: 'DELETE',
        data: {
            _token: $("input[name=_token]").val()
        },
        success: function(data) {
            $('div.alert-success').text(data.undo);
            $('div.alert-success').css('display', 'block');
            $('#' + id).remove();
        },
    });
}
//undo index data table
function undoIndex(route, id) {
    console.log(route);
    $.ajax({
        url: route,
        type: 'GET',
        data: {
            _token: $("input[name=_token]").val()
        },
        success: function(data) {
            $('div.alert-success').text(data.success);
            $('div.alert-success').css('display', 'block');
            $('#' + id).remove();
        },
    });
}

function load(e) {
    setTimeout(function() {
        e.ajax.reload();
    }, 500);
}
// datetime
function dateTime(time) {
    return time.replace('T', ' ');
}
$(document).ready(function () {

    $('.article_summernote').summernote({
        height: 230,
        direction: 'rtl',
        lang: 'fa-IR',
        toolbar: [
            //[groupname, [button list]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['color', ['color']],
            ['insert', ['link', 'picture', 'hr']],
            ['view', ['fullscreen', 'codeview']],
        ],
        callbacks: {
            onImageUpload:function(files,editor,welEditable){
                uploadArticleFile(files[0],editor,welEditable);
            },
            onMediaDelete:function(files,editor,editable){
                console.log(files[0].src);
                deleteArticleFile(files[0],editor,editable);
            }
        }


    });
    $('#tags_select').select2({
        tags: "true",
        placeholder: "کلمات کلیدی",
        dir:'rtl',
        minimumResultsForSearch: Infinity,
        language:'fa'
    });
});
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
/**
 * Created By Dara on 5/2/2016
 * upload image(summernote)
 */
function uploadArticleFile(file, editor, welEditable) {
    data = new FormData();
    data.append('file', file);
    data.append('_token', $("input[name='_token']").val());
    $.ajax({
        data: data,
        type: 'POST',
        url: '/admin/article/upload',
        cache: false,
        contentType: false,
        processData: false,
        success: function (url) {
            $('.article_summernote').summernote('editor.insertImage', url);
        }
    })
}

/**
 * Created By Dara on 6/2/2016
 * delete image(summernote)
 */
function deleteArticleFile(file,editor,editable){
    $.ajax({
        data:{
            src:file.src,
            _token:$('input[name="_token"]').val(),
            _method:'delete'
        },
        type:'POST',
        url:'/admin/article/delete',
        success:function(){

        }

    })
}
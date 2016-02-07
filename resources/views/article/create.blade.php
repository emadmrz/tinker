@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    مقاله جدید
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {!! Form::open(['route'=>'admin.article.store','method'=>'post', 'enctype'=>'multipart/form-data']) !!}
                            <div class="form-group">
                                <label for="title">عنوان</label>
                                <input id="title" name="title" class="form-control"
                                       placeholder="عنوان را وارد نمایید ...">
                            </div>
                            <div class="form-group">
                                <label for="image">درج تصویر</label>
                                <input class="form-control" id="image" name="image" type="file">
                            </div>
                            {{--summernote--}}
                            {!! Form::textarea('content', null, ['class'=>'form-control article_summernote', 'rows'=>'10']) !!}
                            <div class="form-group">
                                <label>وضعیت انتشار</label>
                                {!! Form::select('published', [1=>'منتشر شود', 0=>'منتشر نشود'], 1, ['class'=>'form-control select-status', 'placeholder'=>'']) !!}
                            </div>
                            <div class="form-group">
                                <label>برچسب ها</label>
                                {!! Form::select('tags[]', [], null, ['id'=>'tags_select','class'=>'form-control','multiple', 'placeholder'=>'']) !!}
                            </div>
                            <button type="submit" class="btn btn-success">ارسال</button>

                            </form>
                        </div>

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection
@section('script')
    <script>
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
                url: 'upload',
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
                url:'delete',
                success:function(){

                }

            })
        }
    </script>
@endsection
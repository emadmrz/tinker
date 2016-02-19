@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    ویرایش
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-6">
                            {!! Form::model($course,['route'=>['admin.course.update',$course->id],'method'=>'post', 'enctype'=>'multipart/form-data']) !!}
                            <div class="form-group">
                                <label for="name">عنوان</label>
                                {!! Form::text('name',null,['class'=>'form-control','id'=>'name']) !!}
                            </div>
                            <div class="form-group">
                                <label for="image">درج تصویر</label>
                                <input class="form-control" id="image" name="image" type="file">
                                <img style="max-width: 50%;" src="{{asset('images/files/'.$course->image)}}" alt="">
                            </div>
                            <div class="form-group">
                                <label>دسته بندی اصلی</label>
                                {!! Form::select('category',$main, $selectedMainCategory, ['class'=>'form-control select-status','id'=>'mainCategory']) !!}
                            </div>
                            <div class="form-group">
                                <label>دسته بندی فرعی</label>
                                {!! Form::select('sub_category_id', $subCategories, $selectedSubCategory, ['class'=>'form-control select-status','id'=>'subCategory']) !!}
                            </div>
                            <div class="form-group">
                                <label>توضیحات</label>
                                {!! Form::textarea('description', null, ['class'=>'form-control', 'rows'=>'10']) !!}
                            </div>
                            <div class="form-group">
                                <label for="price">هزینه دوره</label>
                                {!! Form::text('price',null,['class'=>'form-control','id'=>'price']) !!}
                            </div>
                            <div class="form-group">
                                <label>وضعیت</label>
                                {!! Form::select('active', [1=>'فعال', 0=>'غیرفعال'], null, ['class'=>'form-control select-status', 'placeholder'=>'']) !!}
                            </div>
                            <div class="form-group">
                                <label>برچسب ها</label>
                                {!! Form::select('tags[]', $tags, $selectedTag, ['id'=>'tags_select','class'=>'form-control','multiple', 'placeholder'=>'']) !!}
                            </div>
                            <button type="submit" class="btn btn-success">ویرایش</button>

                            {!! Form::close() !!}
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
@endsection
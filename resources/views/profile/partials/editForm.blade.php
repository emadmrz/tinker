<div class="panel panel-default">
    <div class="panel-heading">
        <div class="title">
            ویرایش حساب کاربری
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                {!! Form::model($user,['route'=>'profile.store','class'=>'form-horizontal','files'=>true]) !!}
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="first_name" class="col-md-2 col-sm-3 control-label">نام</label>
                        <div class="col-md-6 col-sm-9">
                            {!! Form::text('first_name',null,['class'=>'form-control','id'=>'first_name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-md-2 col-sm-3 control-label">نام خانوادگی</label>
                        <div class="col-md-6 col-sm-9">
                            {!! Form::text('last_name',null,['class'=>'form-control','id'=>'last_name']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-md-2 col-sm-3 control-label">ایمیل</label>
                        <div class="col-md-6 col-sm-9">
                            <p class="form-control-static">{{$user->email}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="col-md-2 col-sm-3 control-label">تصویر پروفایل</label>
                        <div class="col-md-6 col-sm-9">
                            <input name="image" id="image" type="file" class="form-control">
                        </div>
                    </div>

                        <button type="submit" class="btn btn-md btn-success">
                            <i class="fa fa-save"></i>
                            ذخیره تغییرات
                        </button>
                {!! Form::close() !!}
            </div>

        </div>
    </div>
</div>
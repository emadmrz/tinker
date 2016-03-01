<div class="panel panel-default">
    <div class="panel-heading">
        <div class="title">
            وضعیت کاربر
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="first_name" class="col-md-2 col-sm-3 control-label">تاریخ عضویت</label>

                        <div class="col-md-6 col-sm-9">
                            <p>{{$user->shamsi_created_at}}</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-md-2 col-sm-3 control-label">تایید ایمیل</label>

                        <div class="col-md-6 col-sm-9">
                            @if($user->confirmed)
                                <label class="label label-success">تایید شده</label>
                            @else
                                <p>
                                    کاربر گرامی در حال حاضر آدرس ایمیل شما تایید نشده است. شما برای مدت محدودی می توانید
                                    با این شرایط در سایت فعالیت داشته باشد.
                                    ما پیشنهاد می کنیم تا تنها با چند کلیک آدرس ایمیل خود را فعال کنید. تنها کافی است به
                                    آدرس ایمیلی که با آن در سایت عضو شده اید مراجعه کرده
                                    و بر روی لینک فعال سازی آدرس ایمیل که از طرف ما برای شما ارسال شده است کلیک نمایید.
                                    در صورتی که که قصد دریافت مجدد ایمیل فعال سازی را دارید بر روی دکمه زیر کلیک نمایید.
                                </p>
                                {!! Form::open(['url'=>'/email', 'method'=>'post']) !!}
                                {!! Form::submit('ارسال مجدد ایمیل فعال سازی', ['class'=>'btn btn-learn']) !!}
                                {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
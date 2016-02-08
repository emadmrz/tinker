$(document).ready(function(){

    /**
     * Created By Dara on 8/2/2016
     *
     */
    $('form[data-remote]').submit(function(e){
        e.preventDefault();
        var $this=$(this);
        var data=$this.serialize();
        var action=$this.attr('action');
        var method=$this.attr('method');
        if($this.find('input[name="_method"]').length>0){
            method = $this.find('input[name="_method"]').val();
        }
        var current_text=$this.find('button[type=submit]').html();
        $.ajax({
            data:data,
            type:method,
            dataType:'json',
            url:action,
            beforeSend:function(){
                $this.find('button[type="submit"]').find('i').attr('class', '').addClass('fa fa-spinner fa-spin');
            },
            complete:function(){
                if($this.find('button[type="submit"]').find('i').hasClass('fa fa-spinner fa-spin')){
                    $this.find('button[type="submit"]').html(current_text);
                }
            },
            success:function(data){
                if(data.hasCallback){
                    window[data.callback](data.returns);
                }
                if(data.hasMsg){
                    var type = 'success';
                    if(data.msgType){
                        type = data.msgType;
                    }
                    $.notify(data.msg, {type:type});
                }
            },
            error:function(xhr){
                alert("An error occured: " + xhr.status + " " + xhr.statusText);
            }
        });

    })
});

/*Setup Ajax Request*/
$.ajaxSetup({
   'headers':{
       'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
   }
});

/*functions*/
function article_comment(data){
    $('.comment-list').find('ul.media-list').prepend(data.new_comment);
    $('.comment-list').find('ul.media-list').scrollTop(0);
    $('.comment-list').find('textarea[name="content"]').val('');
}

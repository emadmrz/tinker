<li class="media comment-form">
    <div class="media-right">
        <a href="#">
            <img class="media-object" src="images/person1.jpg" alt="">
        </a>
    </div>
    <div class="media-body">
        <form method="post" class="form-horizontal" data-remote="true"
              action="{{route('article.comment.store',$article->id)}}">
                                                        <textarea class="form-control"
                                                                  placeholder="لطفا نظر خود را وارد نمایید ..."
                                                                  name="content" id=""></textarea>
            <button type="submit" class="btn btn-learn">
                <i class="fa fa-paper-plane-o"></i>
                ارسال نظر
            </button>
        </form>
    </div>
</li>
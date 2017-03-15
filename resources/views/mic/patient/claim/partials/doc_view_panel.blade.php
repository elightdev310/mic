<div class="row">
  <div class="col-sm-8">
    <div class="doc-view-section" style="line-height: 0px; height:600px;">
      <iframe src="http://docs.google.com/gview?url={{ $file->path() }}&embedded=true" style="width:100%; height:100%;" frameborder="0"></iframe>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="doc-comment-section" data-reload-url="{{ route('claim.doc.comment.list',[$doc->id]) }}">
      <!-- Comment Post Form -->
      <div class="comment-card-w-hint">
        <form action="{{ route('claim.doc.comment.post', [$doc->id, 0]) }}" class="comment-form" data-doc="{{$doc->id}}">
        <div class="comment-card">
          <div class="comment-field">
            <div class="comment-box">
              <div class="commenter-photo">
                {!! MICUILayoutHelper::avatarImage($currentUser, 32) !!}
              </div>
              <div class="mentions-container">
                <div class="mentions-input">
                  <textarea onkeyup="textAreaAdjust(this)" class="comment-input-text" row="1" placeholder="Write a comment"></textarea>
                </div>
              </div>
              <div class="post-area clearfix">
                <div class="button-container pull-right">
                  <a class="btn btn-primary btn-sm comment-post">Post</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>

      <div class="comment-list-section">
        <!-- Comment Thread -->
      </div>
    </div>
  </div>
</div>

<div class="comment-card-w-hint">
  <form action="{{ route('claim.doc.comment.post', [$doc->id, $thread->id]) }}" class="comment-form" data-doc="{{ $doc->id }}">
  <div class="comment-card">
    <div class="threaded-comment-list" id="doc-comment-thread-{{$thread->id}}">
      <div class="thread-comment-list">
        @foreach ($th_comments as $comment)
        <div class="comment-activity">
          <div class="comment">
            <div class="commenter-photo">
              {!! MICUILayoutHelper::avatarImage($comment->author, 32) !!}
            </div>
            <div class="comment-body">
              <div class="comment-top-bar">
                <div class="commenter-name">{{ $comment->author->name }}</div>
                <div class="comment-when">
                  <div class="activity-time-ago">{{ MICUILayoutHelper::agoTime($comment->created_at, ' ago') }} </div>
                </div>
              </div>
              <div class="comment-text">{{ $comment->comment }}</div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="comment-reply-section">
        <a href="#" class="comment-reply">Reply</a>
      </div>
      <div class="comment-field comment-field--reply">
        <div class="comment-box">
          <div class="commenter-photo">
            {!! MICUILayoutHelper::avatarImage($user, 80) !!}
          </div>
          <div class="mentions-container">
            <div class="mentions-input">
              <textarea onkeyup="textAreaAdjust(this)" class="comment-input-text" row="1" placeholder="Reply"></textarea>
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
  </div>
  </form>
</div>

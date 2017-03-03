@if (!empty($ca_feeds) && $ca_feeds->count())
@foreach ($ca_feeds as $feed)
  <div class="ca-feed-item" data-activity="{{ $feed->id }}">
    <div class="user-avatar">
      <img src="http://www.gravatar.com/avatar/cf7bfe2df7006928124a56f1fe8a148d.jpg?s=80&amp;d=mm&amp;r=g" class="img-circle" alt="User Image">
    </div>
    <div class="feed-body">
      <div class="feed-user">
        <span class="user-name">{{ $feed->author->name }}</span>
        <div class="activity-time pull-right">
          {{ MICUILayoutHelper::agoTime($feed->created_at, ' ago') }}
        </div>
      </div>
      <div class="activity-text">{!! $feed->content !!}</div>
    </div>
  </div>
@endforeach
@else
<div class="no-activity">No Activity</div>
@endif

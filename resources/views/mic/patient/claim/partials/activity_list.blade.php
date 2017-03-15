@if (!empty($ca_feeds) && $ca_feeds->count())
@foreach ($ca_feeds as $feed)
  <div class="ca-feed-item" data-activity="{{ $feed->id }}">
    <div class="user-avatar">
      {!! MICUILayoutHelper::avatarImage($feed->author, 48) !!}
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

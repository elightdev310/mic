<ul class="menu">
  @if (count($notify_list))
    @foreach ($notify_list as $noti)
    <li class="@if (!$noti->read) unread @endif"><!-- start notification -->
      <a href="#">
        {{ $noti->message }}
      </a>
    </li><!-- end notification -->
    @endforeach
  @else
    <li class="text-center"><a href="#">No notification</a></li>
  @endif
</ul>

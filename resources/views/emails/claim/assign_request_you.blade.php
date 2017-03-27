Dear {{ $sendTo->name }},<br><br>

You received a request of <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

Dear {{ $sendTo->name }},<br><br>

Sorry, you are not allowed to <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

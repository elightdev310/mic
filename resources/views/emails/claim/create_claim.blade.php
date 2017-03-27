Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} created <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

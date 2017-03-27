Dear {{ $sendTo->name }},<br><br>

{{ $partner->name }} rejected <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

Dear {{ $sendTo->name }},<br><br>

{{ $partner->name }} is assigned to <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

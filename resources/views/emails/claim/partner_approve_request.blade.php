Dear {{ $sendTo->name }},<br><br>

{{ $partner->name }} approved to be assigned to <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

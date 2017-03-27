Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} updated Incident of Injury Information in <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

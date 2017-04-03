Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} updated Incident of Injury Information in <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

Dear {{ $sendTo->name }},<br><br>

{{ $claim->patientUser->name }} allowed {{ $partner->name }} to <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

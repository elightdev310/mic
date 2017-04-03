Dear {{ $sendTo->name }},<br><br>

{{ $claim->patientUser->name }} rejected {{ $partner->name }} from <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

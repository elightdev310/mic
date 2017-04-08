Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} uploaded document ({{ $doc->file->name }}) to <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

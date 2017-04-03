Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} posted comment to document ({{ $doc->file->name }}) in <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

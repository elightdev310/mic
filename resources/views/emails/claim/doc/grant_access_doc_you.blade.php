Dear {{ $sendTo->name }},<br><br>

You get an access to document ({{ $doc->file->name }}) of <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

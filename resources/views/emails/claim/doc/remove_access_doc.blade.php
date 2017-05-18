Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} lost an access to document ({{ $doc->file->name }}) of <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} deleted photo ({{ $photo->file->name }}) to <a href="{{ route($url_as_prefix."claim.page", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

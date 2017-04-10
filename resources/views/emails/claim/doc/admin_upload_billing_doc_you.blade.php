Dear {{ $sendTo->name }},<br><br>

{{ $user->name }} sent you document({{ $doc->file->name }}) as reply to document({{ $reply_to_doc->file->name }}) in <a href="{{ route($url_as_prefix."claim.view", [$claim->id]) }}">claim #{{ $claim->id }}</a>
<br/><br/>

Best Regards,

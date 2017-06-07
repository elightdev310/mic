Dear {{ $sendTo->name }},<br><br>

@if ($doc->isHL7Message())
{{ $user->name }} deleted message from claim #{{ $claim->id }}
@else
{{ $user->name }} deleted document from claim #{{ $claim->id }}
@endif
<br/><br/>

Best Regards,

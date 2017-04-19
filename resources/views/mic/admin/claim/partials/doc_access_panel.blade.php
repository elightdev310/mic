<form id="cda_frm" action="{{ route('micadmin.claim.doc.set_access', [$claim->id, $doc->id]) }}" >
<table class="table table-striped table-hover">
  <thead>
    <th></th>
    <th>Accesss</th>
  </thead>
  <tbody>
    @foreach ($cda as $uid=>$item)
    <tr class="cda-item @if (!MICHelper::isActiveUser($uid)) disabled @endif">
      <td>
        {!! MICUILayoutHelper::avatarImage($uid, 24) !!}
        {{ MICHelper::getUserTitle($uid) }}
        @if ($doc->creator_uid == $uid)
        &nbsp;<strong>[Author]</strong>
        @endif
      </td>
      <td>
        @if ($doc->creator_uid == $uid || $item == 'patient')
        <input type="checkbox" class="minimal checkbox" checked='checked' disabled>
        @else
        <input type="checkbox" class="minimal checkbox" name="cda[{{$uid}}]" @if($item) checked='checked'@endif >
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</form>

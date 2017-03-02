@if (isset($docs) && count($docs))
<table class="table table-striped table-hover table-border">
  <thead>
    <th class="doc-name">Document</th>
    <th class="doc-creator">Author</th>
    <th class="doc-uploaded-at">Uploaded At</th>
    <th class="row-action">Action</th>
  </thead>
  <tbody>
    @foreach ($docs as $doc)
    <tr data-doc-id="{{ $doc->id }}" class="claim-doc-item">
      <td class="doc-name">
        <a href="#" data-url="{{ route('claim.doc.view_panel', [$claim->id, $doc->id]) }}" data-path="{{$doc->file->path()}}" class="view-doc-link">
          {{ $doc->file->name }}
        </a>
      </td>
      <td class="doc-creator">{{ MICHelper::getUserTitle($doc->creator_uid) }}</td>
      <td class="doc-uploaded-at">{{ MICUILayoutHelper::strTime($doc->created_at, "M d, Y H:i") }}</td>
      <td class="row-action">
        <a href="#" data-url="{{ route('claim.doc.view_panel', [$claim->id, $doc->id]) }}" class="action-link view-doc-link"><i class="fa fa-eye"></i></a>
        <a href="{{ $doc->file->path() }}?download" class="action-link download-doc-link"><i class="fa fa-download"></i></a>

        @if ($user->can(config('mic.permission.micadmin_panel')))
        <a href="#" class="action-link access-doc-link" 
            data-url="{{ route('micadmin.claim.doc.access_panel', [$claim->id, $doc->id]) }}"><i class="fa fa-key"></i></a>
        @endif

        @if ($user->id == $doc->creator_uid)
        <a href="#" class="action-link delete-doc-link" 
            data-url="{{ route('claim.delete.doc', [$claim->id, $doc->id]) }}" data-path="{{$doc->file->path()}}">
          <i class="fa fa-trash"></i>
        </a>
        @endif
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@else
<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>
@endif

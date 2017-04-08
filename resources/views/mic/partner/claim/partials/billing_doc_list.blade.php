@if (isset($billing_docs) && count($billing_docs))
<table class="table table-striped table-hover table-border">
  <tbody>
    @foreach ($billing_docs as $doc)
    <tr data-doc-id="{{ $doc['doc']->id }}" class="claim-billing-doc-item">

      <td class="doc-name">
        {!! MICUILayoutHelper::avatarImage($doc['doc']->creator, 24) !!} &nbsp;
        {{ $doc['doc']->file->name }}
      </td>
      <td class="doc-uploaded-at text-right">{{ MICUILayoutHelper::strTime($doc['doc']->created_at, "M d, Y H:i") }}</td>
      <td class="row-action text-right">
        
        <a href="{{ $doc['doc']->file->path() }}?download" title="download" class="action-link download-doc-link"><i class="fa fa-download"></i></a>
      </td>

    </tr>
    @endforeach
  </tbody>
</table>
@else
<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>
@endif

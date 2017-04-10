@if (isset($billing_docs) && count($billing_docs))
<table class="table table-striped table-hover table-border">
  <tbody>
    @foreach ($billing_docs as $doc)
    <tr data-doc-id="{{ $doc['doc']->id }}" class="claim-billing-doc-item">

      <td class="doc-name">
        {!! MICUILayoutHelper::avatarImage($doc['doc']->creator, 24) !!} {{ $doc['doc']->creator->name }} : 
        {{ $doc['doc']->file->name }}
      </td>
      <td class="doc-uploaded-at text-right">{{ MICUILayoutHelper::strTime($doc['doc']->created_at, "M d, Y H:i") }}</td>
      <td class="row-action text-right">
        @if (isset($reply_docs_action))
        <a href="#" class="action-link reply-doc-link" data-url="{{ route('micadmin.claim.upload.billing_doc', [$claim->id, $doc['doc']->id]) }}">Send file to</a> | 
        @endif
        <a href="{{ $doc['doc']->file->path() }}?download" class="action-link download-doc-link"><i class="fa fa-download"></i></a>
      </td>

    </tr>
    @foreach($doc['replies'] as $reply_doc)

    <tr data-doc-id="{{ $reply_doc->id }}" class="claim-billing-doc-item billing-reply-doc">

      <td class="doc-name">
        {!! MICUILayoutHelper::avatarImage($reply_doc->creator, 24) !!} {{ $reply_doc->creator->name }} : 
        {{ $reply_doc->file->name }}
      </td>
      <td class="doc-uploaded-at text-right">{{ MICUILayoutHelper::strTime($reply_doc->created_at, "M d, Y H:i") }}</td>
      <td class="row-action text-right">
        <a href="{{ $reply_doc->file->path() }}?download" class="action-link download-doc-link"><i class="fa fa-download"></i></a>
      </td>

    </tr>

    @endforeach
    @endforeach
  </tbody>
</table>
@else
<div class='text-center text-danger' style='margin-top:40px;'>No Files</div>
@endif

<div class="table-responsive">
  <table class="table table-hover table-border mic-table">
    <thead>
      <tr>
        <th class="field-desc">Field Description</th>
        <th class="field-content">Field</th>
      </tr>
    </thead>
    <tbody>
      @foreach($hl7->fieldData[$segment->segmentId] as $field)
        <tr>
          <td class="field-desc">
            {{ $field->fieldNum }}.&nbsp;{{ $field->fieldDescription }}
          </td>
          <td class="field-content">
            {{ $field->fieldContents }}
            @if ( $field->fieldPanel )
            <div class='field-panel'>
              {!! $field->fieldPanel !!}
            </div>
            @endif
          </td>
        </tr>

      @endforeach
    </tbody>
  </table>
</div>

<div class="summary-panel box box-primary">
  <div class="box-header">
    Claim Summary
  </div>
  <div class="box-body">
    <div class="claim-summary-section">
      {!! Form::open(['route' => ['micadmin.claim.summary.post', $claim->id], 
                'method'=>'post']) !!}
        <div class="form-group">
          <div class="col-md-12">
            {!! Form::textarea('summary', $claim->summary, ['class'=>'form-control', 'rows'=>3]) !!}
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-12">
            {!! Form::submit('Save', ['class'=>'btn btn-primary']) !!}
          </div>
        </div>
        
      {!! Form::close() !!}
    </div>
  </div>
</div>


@extends('mic.layouts.modal')

@section('htmlheader_title') Learning Center @endsection
@section('contentheader_title')Purchase Video @endsection
@section('page_id')learning-center-page @endsection
@section('page_classes')learning-center @endsection

@section('content')
<div class="row m0">

  <div class="col-sm-5">
    <div class="learning-center-videos video-list">
    <div class="video-item">
      <div class="video-thumbnail">
        <img src="{{ $video->video->snippet->thumbnails->high->url }}" />
        <div class="video-duration">{{ MICUILayoutHelper::duration($video->video->contentDetails->duration) }}</div>
      </div>
      <div class="video-info">
        <div class="video-title">
          {{ $video->video->snippet->title }}
        </div>
        <div class="video-channel">
          {{ $video->video->snippet->channelTitle }}
        </div>
        <div class="video-review">
          <span>{{ $video->video->statistics->viewCount }} views</span> - 
          <span>{{ MICUILayoutHelper::agoTime($video->video->snippet->publishedAt, ' ago') }}</span>
        </div>
        @if ($va->price)
        <div class="video-purchase">
          <h3 class="video-price">
            Price: ${{ number_format($va->price, 2) }}
          </h3>
        </div>
        @endif
      </div><!-- /.video-info -->
    </div><!-- /.video-item -->
    </div>
  </div>

  <div class="col-sm-7">
    <div class="panel">
    {!! Form::open(['route' =>['learning_center.video.purchase', $va->id], 
                    'method'=>'post', 
                    'class' =>'materials-form']) !!}
      <input type="hidden" name="_action" value="savePaymentSettings" />

      <div class="form-group">
        {!! Form::label('payment_type', 'Payment Type :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! 
            Form::select('payment_type', 
                          config('mic.payment_type'),
                          $payment_info->payment_type, 
                          ['class' => 'form-control', 'placeholder'=>'Please select payment type']) 
          !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('name_card', 'Name on Card :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('name_card', $payment_info->name_card, ['class' => 'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('cc_number', 'Credit Card Number :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('cc_number', $payment_info->cc_number, ['class' => 'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('exp', 'Exp :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {{-- {!! Form::text('exp', $payment_info->exp, ['class' => 'form-control']) !!} --}}
          {{--*/ 
            $months= [];
            $years = [];
            $_year=date('Y');
            for ($index = 1; $index<=12; $index++) {
              $_month = ($index<10)? '0'.$index : $index;
              $months[$_month] = $_month;
            }
            $index = 0;
            while($index<5) { $years[$_year%100] = $_year; $index++; $_year++; } 
           /*--}}
          <div class="row m0">
            <div class="form-material col-xs-5 pl0 pr10">
              {!! 
                Form::select('exp_month', 
                              $months,
                              $exp_month, 
                              ['class' => 'form-control']) 
              !!}
            </div>
            <div class="form-material col-xs-7 p0">
              {!! 
                Form::select('exp_year', 
                              $years,
                              $exp_year, 
                              ['class' => 'form-control']) 
              !!}
            </div>
          </div>
        </div></div>
      </div>
      <div class="form-group">
        {!! Form::label('cid', 'CID :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('cid', $payment_info->cid, ['class' => 'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        {!! Form::label('address', 'Address :', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('address', $payment_info->address, ['class'=>'form-control']) !!}
        </div></div>
      </div>
      <div class="form-group">
        {!! Form::label('address2', 'Address 2:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('address2', $payment_info->address2, ['class'=>'form-control']) !!}
        </div></div>
      </div>
      <div class="form-group">
        {!! Form::label('city', 'City:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('city', $payment_info->city, ['class'=>'form-control']) !!}
        </div></div>
      </div>
      <div class="form-group">
        {!! Form::label('state', 'State:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('state', $payment_info->state, ['class'=>'form-control']) !!}
        </div></div>
      </div>
      <div class="form-group">
            {!! Form::label('zip', 'Zip Code:', ['class' => 'control-label col-md-4 col-lg-2']); !!}
        <div class="col-md-8 col-lg-4"><div class="form-material">
          {!! Form::text('zip', $payment_info->zip, ['class'=>'form-control']) !!}
        </div></div>
      </div>

      <div class="form-group">
        <div class="col-md-12">
          {!! Form::submit('Purchase', ['class'=>'btn btn-primary']) !!}
        </div>
      </div>

    {!! Form::close() !!}
    </div>
  </div>

</div>



@endsection

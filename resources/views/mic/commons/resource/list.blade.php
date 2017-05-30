
@extends('mic.layouts.'.$layout)

@section('htmlheader_title') Resources @endsection
@section('contentheader_title')@endsection

@section('content')
<!-- Main content -->
  <div class="">
    <div class="resource-list">
      <div class="row pl30 pr30 pb30">
      
        @foreach ($resources as $resource)
        <div class="col-md-3 col-sm-6 resource-item mb10">
          <div class="content-box pb10 pl20 pr20">
            <h3><a href="{{ route('resource.view', [$resource->id] )}}">
              {{ $resource->title }}
              </a></h3>
            <div class="resource-summary">
              {{ MICUILayoutHelper::teaserString($resource->body) }}
            </div>  
          </div>
        </div>
        @endforeach

      </div>
    </div>
  </div>


@endsection

@push('scripts')
<script type="text/javascript">
  $(function () {
    
  });
</script>
@endpush



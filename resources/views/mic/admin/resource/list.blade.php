@extends('mic.layouts.admin')

@section('htmlheader_title')Resource Pages @endsection
@section('contentheader_title')Resource Pages @endsection

@section('main-content')
<!-- Main content -->
  <div class="row">
    <section class="col-md-12">

      <div class="resources-box box box-success">
        {!! Form::open(['route'=>'micadmin.resource.sort.post', 'method'=>'post']) !!}
        <div class="box-header">
          <div class="pull-left">
            <p class="description">Please drag & drop to rearrange resource pages in group.</p>
          </div>
          <div class="pull-right">
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#resource-template-modal">Add Resource Page</a>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">

          <div class="group-resources">
            @foreach ($group_resources as $group=>$g_resources)
            <div class="group-resource-section">
              <div class="group-title">For {{ $groups[$group] }}</div>
              @if (!empty($g_resources))
                <ul class="resource-list todo-list">
                  @foreach ($g_resources as $resource)
                  <li id="ra-{{$resource->ra->id}}">
                    <span class="handle">
                      <i class="fa fa-ellipsis-v"></i>
                      <i class="fa fa-ellipsis-v"></i>
                    </span>

                    <!-- todo text -->
                    <span class="text">
                      <a href="{{ route('micadmin.resource.edit', [$resource->id]) }}">
                        {{ $resource->title}}
                      </a>
                    </span>

                    {!! Form::input("hidden", "ra_weight[{$resource->ra->id}]", $resource->ra->weight, 
                                    ['class'=>'ra-weight']) !!}
                    
                    <div class="tools">
                      <a href="{{ route('micadmin.resource.edit', [$resource->id]) }}" class="resource-edit">
                        <i class="fa fa-edit"></i></a>
                      <a href="#" class="resource-delete" data-url="{{ route('micadmin.resource.delete', [$resource->ra->id]) }}">
                        <i class="fa fa-trash-o"></i></a>
                    </div>
                  </li>
                  @endforeach
                </ul>
              @else
              <p class="text-center p10">No Resource</p>
              @endif
            </div>
            @endforeach
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
          <div class="paginator pull-right">
            {!! Form::submit('Save Order Changes', ['class'=>'btn btn-success']) !!}
          </div>
        </div>

        {!! Form::close() !!}
      </div><!-- /.box -->

    </section>
  </div>

  <!-- Choose Template Modal -->
  {!! Form::open(['route'=>'micadmin.resource.add', 'method'=>'get']) !!}
  <div id="resource-template-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Resource Template</h4>
        </div>
        <div class="modal-body">
          <div class="p10">Please select template</div>
          <div class="p10">
            {!! Form::select('template', config('mic.resource.template'), NULL, 
                             ['class'=>'form-control']) !!}
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" >Choose</button>
        </div>
      </div>

    </div>
  </div>
  {!! Form::close() !!}
@endsection

@push('scripts')
<script>
(function ($) {
  $(document).ready(function() {
    $('.resource-list').sortable({
      placeholder: "sort-highlight",
      handle: ".handle",
      forcePlaceholderSize: true,
      zIndex: 99999, 
      update: function(event, ui) {
        $sort = $(this).sortable('toArray');
        for ($i in $sort) {
          var $li = $('#'+$sort[$i]);
          $li.find('.ra-weight').val($i);
        }
      }
    });

    $('.resource-delete').on('click', function() {
      var url = $(this).data('url');
      bootbox.confirm({
        title: "Delete Resource Page", 
        message: "<p>Are you sure to delete resource page`?</p>", 
        callback: function (result) {
          if (result) {
            window.location.href = url;
          }
        }
      });
    });
  });
})(jQuery);
</script>
@endpush

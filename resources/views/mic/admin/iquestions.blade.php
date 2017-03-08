@extends('mic.layouts.admin')

@section('htmlheader_title')Injury Questions @endsection
@section('contentheader_title')Injury Questions @endsection

@section('main-content')
<!-- Main content -->
<section class="content">
  <div class="row">
    <section class="col-md-12">

      @include('mic.admin.partials.success_error')

      <div class="users-box box box-success">
        {!! Form::open(['route'=>'micadmin.iquiz.sort.post', 'method'=>'post']) !!}
        <div class="box-header">
          <div class="pull-left">
            <p class="description">Please drag & drop to rearrange questions.</p>
          </div>
          <div class="pull-right">
            <a href="{{ route('micadmin.iquiz.add') }}" class="btn btn-success">Add Question</a>
          </div>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <ul class="quiz-list todo-list">
            @foreach ($questions as $quiz)
            <li id="quiz-{{$quiz->id}}">
              <!-- drag handle -->
              <span class="handle pull-left">
                <i class="fa fa-ellipsis-v"></i>
                <i class="fa fa-ellipsis-v"></i>
              </span>

                {{ $quiz->quiz }}
                &nbsp;
                @if ($quiz->show_creating)
                <span class="text-primary"><i>[Show in Creating]</i></span>
                @endif

              {!! Form::input("hidden", "q_weight[$quiz->id]", $quiz->weight, 
                              ['class'=>'q-weight']) !!}
              
              <div class="tools">
                <a href="{{ route('micadmin.iquiz.edit.post', [$quiz->id]) }}" class="quiz-edit">
                  <i class="fa fa-edit"></i></a>
                <a href="#" class="quiz-delete" data-url="{{ route('micadmin.iquiz.delete', [$quiz->id]) }}">
                  <i class="fa fa-trash-o"></i></a>
              </div>
            </li>
            @endforeach
          </ul>

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
</section><!-- /.content -->
@endsection

@push('scripts')

<script>
(function ($) {
  $(document).ready(function() {
    $('.quiz-list').sortable({
      placeholder: "sort-highlight",
      handle: ".handle",
      forcePlaceholderSize: true,
      zIndex: 99999, 
      update: function(event, ui) {
        $sort = $(this).sortable('toArray');
        for ($i in $sort) {
          var $li = $('#'+$sort[$i]);
          $li.find('.q-weight').val($i);
        }
      }
    });

    $('.quiz-delete').on('click', function() {
      var url = $(this).data('url');
      bootbox.confirm({
        title: "Delete Question", 
        message: "<p>Are you sure to delete question?</p>", 
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

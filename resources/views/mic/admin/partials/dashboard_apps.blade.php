<div class="application-box box box-primary">
  <div class="box-header">
    <i class="ion ion-clipboard"></i>
    <h3 class="box-title">Partner Applications</h3>
    <div class="box-tools pull-right">
      
    </div>
  </div><!-- /.box-header -->
  <div class="box-body">
    <ul class="application-list todo-list">
      @foreach ($apps as $app)
      <li>
        <!-- drag handle -->
        <span class="handle">
          <i class="fa fa-ellipsis-v"></i>
          <i class="fa fa-ellipsis-v"></i>
        </span>

        <!-- todo text -->
        <span class="text">
          <a href="{{ url(route('micadmin.app.view', [$app->id])) }}">
          {{ $app->first_name.' '.$app->last_name.' '.'('.$app->email.')'}}
          </a>
        </span>
        <!-- Emphasis label -->
        <small class="label label-primary"><i class="fa fa-clock-o"></i>
          {{ MICUILayoutHelper::agoTime($app->created_at) }} ago
        </small>
        
      </li>
      @endforeach
    </ul>
  </div><!-- /.box-body -->
  <div class="box-footer clearfix no-border">
    <a href="{{ url(route('micadmin.apps.list', ['pending'])) }}" class="btn btn-default pull-right">
      View All&nbsp;&nbsp;
      <i class="fa fa-angle-double-right"></i>
    </a>
  </div>
</div><!-- /.box -->

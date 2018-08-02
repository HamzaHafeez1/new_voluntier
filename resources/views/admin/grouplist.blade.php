@include('admin.include.admin_header')

@include('admin.include.admin_head_nav')
<!-- Left side column. contains the logo and sidebar -->
@include('admin.include.admin_side_nav')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Grouplist
           <!--  <small>advanced tables</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li  class="active">Groups</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
					 @if(Session::has('success'))
						<div class="alert alert-success">{{Session::get('success')}}</div>
					@endif
                    <div class="box-header">
                        <h2 class="box-title text-success">Manage Groups</h2>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table  ">
                            <thead>
								<td>Id</td>
                                <td>Group Name</td>
                                <td>Admin Name</td>
                                <td>Admin Email</td>
                                <td>Date Created</td>
                                <td>Group Status</td>
                                <td>Group Type</td>
                                <td width="100">Action</td>
                            </thead>
                            <tbody>
                                @if($list->count()>0)
                                @foreach($list as $each)
                                <tr>
									<td>{{$loop->iteration}}</td>
                                    <td>{{$each->name}}</td>
                                    <td>{{$each->contact_name}}</td>
                                    <td>{{$each->contact_email}}</td>
                                    <td>{{$each->created_at}}
									</td>
                                    <td>
                                        @if($each->is_deleted==0)
											Active 
                                        @endif
                                        @if($each->is_deleted==1)
											Deleted
                                        @endif
                                    </td>
                                    <td>
                                        @if($each->is_public==0)
                                            Private 
                                        @else
                                            Public
                                        @endif
                                    </td>
                                    <td>
                                        @if($each->is_deleted!=1)
                                           <a href="javascript:void(0);" data-id="{{$each->id}}" data-name="{{$each->name}}" class="open_volentire_modal actnbtn"><i class="fa fa-users"></i></a>
                                           <a href="javascript:void(0);" data-id="{{$each->id}}"  class="open_modal actnbtn"><i class="fa fa-edit"></i></a>
                                           <a href="{{url('/admin/group-delete')}}/{{$each->id}}" onclick="return confirm('Are you sure you want to change group status?');" class="actnbtn"><i class="fa fa-trash"></i></a>
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <!-- Modal Edit table -->
    <!-- Large modal -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Group</h4>
                </div>
				<div class="modal-body" id="modalBody">
                    <!-- Ajax loaded data renders here -->
                </div>
				<div class="model-footer">
				</div>
		</div>
  </div>
</div>
@include('admin.include.admin_footer')
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var url = "{{url('/admin/group-editing')}}";
            $(document).on('click','.open_modal',function(){
                var user_id = $(this).data("id");
                
                $.get(url + '/' + user_id, function (data) {
                    $("#modalBody").html(data);
                    $('#myModal').modal('show');
                }) 
            });
			var url_add = "{{url('/admin/group_add_vol')}}";
            $(document).on('click','.open_volentire_modal',function(){
                $('#myModalLabel').html($(this).data('name'));
                $("input[name='grp_save']").val('Invite Selected Users to '+$(this).data('name'));
                var user_id = $(this).data("id");
				
                $.get(url_add + '/' + user_id, function (data) {
					$("#modalBody").html(data);
                    $('#myModal').modal('show');
                }) 
            });
			$('#myModal').on('shown.bs.modal', function() {
				$('.date_created').datepicker({
					format: "yyyy-mm-dd",
					todayBtn: "linked",
					changeMonth: true,
                    changeYear: true,
					autoclose: false,
					todayHighlight: true,
					zIndexOffset: 10,
					container: '#myModal modal-body'
				});
			});	
		});
    </script>
</body>
</html>
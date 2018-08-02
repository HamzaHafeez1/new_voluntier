@include('admin.include.admin_header')

@include('admin.include.admin_head_nav')
<!-- Left side column. contains the logo and sidebar -->
@include('admin.include.admin_side_nav')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Bulk Account Creation
           <!--  <small>advanced tables</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            
            <li class="active">User List</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                <p>Uploaded file: {{base64_decode(Request::segment(3))}}</p>
                    @if(Session::has('success'))
                        <div class="alert alert-success">{{Session::get('success')}}</div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif

                    <div class="box-header">
                        <h2 class="box-title text-success">Manage Temporary Userlist</h2>
                        
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        
                        <table id="example3" class="table">
                            <thead>
                                <td>Sl No.</td>
                                <td>Type</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>User name</td>
                                <td>Zipcode</td>
                                <td>Status</td>
                                <td>Contact Number</td>
                            </thead>
                            <tbody>
                                @if($list->count()>0)
                                @foreach($list as $each)
                                <tr>
                                    
                                     
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$each->user_role}}</td>
                                    <td>
                                        @if($each->user_role=='volunteer') {{$each->first_name .' '.$each->last_name }}@endif
                                        @if($each->user_role=='organization') {{$each->org_name}}@endif
                                    </td>
                                    <td>{{$each->email}}</td>
                                    <td>{{$each->user_name}}</td>
                                    <td>{{$each->zipcode}}</td>
                                    <td>
                                        @if($each->is_deleted==0)
                                        @if ($each->confirm_code!=1) 
                                        Inactive 
                                        @endif

                                        @if ($each->confirm_code==1)
                                        Active
                                        @endif 
                                        @endif
                                        @if($each->is_deleted==1)
                                        Deleted
                                        @endif
                                    </td>
                                    <td>
                                        {{$each->contact_number}}
                                    </td>
                                    
                                    @endforeach
                                    @endif
                                </tbody>
                            </table>
                            <form action="{{url('/admin/showusertemdatapost')}}" method="post">
                                {!! csrf_field() !!}
                                <p><input type="checkbox" name="group" value="1"> Invite all new accounts to an existing group <h3 class="text-success selectAny" >Select Group</h3></p>
                                <p>
                                    <select name="select_group" id="select_group" style="display:none;" class="form-control">
                                        <option value="">--Select--</option>
                                        @if($grouplist)
                                            @foreach($grouplist as $row)
                                                <option value="{{$row->id}}">{{$row->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </p>
                                <input type="submit" class="btn btn-success" value="Create these accouts">
                                <a href="{{url('/admin/user-list')}}" class="text-success">Cancel</a>
                            </form>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    

    @include('admin.include.admin_footer')
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">
        jQuery(document).ready(function($) {
            var url = "{{url('/admin/user-editing')}}";
            $(document).on('click','.open_modal',function(){
                var user_id = $(this).data("id");
                $.get(url + '/' + user_id, function (data) {
                    $("#modalBody").html(data);
                    $('#myModal').modal('show');
                   // $('#edit_user_id').val(user_id);
                }) 
            });

            $('#myModal').on('shown.bs.modal', function() {
                $('.birth_date').datepicker({
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
            $('.first').removeClass('sorting_asc');
            //$('.first').removeClass('sorting_desc');
            $('input[name="check_all"]').change(function() {
                if($(this).prop('checked')){
                    $('.select_all').prop('checked',true);

                }else{
                    $('.select_all').prop('checked',false);
                }
                 $('.first').removeClass('sorting_asc');
                 $('.first').removeClass('sorting_desc');
            });
            $('.deleteuser').click(function(){
                var ids = new Array();
                $('input[name="check_all_id[]"]:checked').each(function() {
                   ids.push(this.value);
                 });
                if(ids.length <=0)  
                {  
                     alert("Please select row.");  
                }else{                    
                    var check = confirm("Are you sure you want to delete this row?");  
                        if(check == true){ 
                            $('.delete_ids').val(ids);
                            $('#frmuserID').submit();
                        }
                    }
            });
            $('.selectAny').click(function() {
                $('#select_group').show();
            })
        });
    </script>
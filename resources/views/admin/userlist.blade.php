@include('admin.include.admin_header')

@include('admin.include.admin_head_nav')
<!-- Left side column. contains the logo and sidebar -->
@include('admin.include.admin_side_nav')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Accounts
           <!--  <small>advanced tables</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            
            <li class="active">List</li>
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
                    @if(Session::has('error'))
                        <div class="alert alert-danger">{{Session::get('error')}}</div>
                    @endif

                    <div class="box-header">
                        <h2 class="box-title text-success">Manage Accounts</h2>
                        <a class="btn btn-success" style="float: right" href="{{url('admin/import-export-csv-excel')}}">Bulk Account Creation</a>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form id="frmuserID" action="{{url('admin/multipleDelete')}}" method="post">
                           <p class="text-success">Bulk Action: <span class="deleteuser" style="cursor: pointer; color: red; display: none; ">Delete All Account</span></p>
                           <input type="hidden" name="ids" class="delete_ids" >
                           {!! csrf_field() !!}
                        </form>
                        <table id="example4" class="table">
                            <thead>
                                <td class="first"><input type="checkbox" name="check_all"></td>
                                <td>Sl No.</td>
                                <td>Type</td>
                                <td>Name</td>
                                <td>Email</td>
                                <td>User name</td>
                                <td>Zipcode</td>
                                <td>Status</td>
                                <td>Contact Number</td>
                                <td>Approval</td>
                                <td width="100">Action</td>
                            </thead>
                            <tbody>
                                @if($list->count()>0)
                                @foreach($list as $each)
                                <tr>
                                    
                                     <td> @if($each->is_deleted!=1)<input type="checkbox" name="check_all_id[]" class="select_all" value="{{$each->id}}">@endif</td>

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
                                    <td>
                                        @if($each->approval=='PENDING') 
                                            <b>PENDING</b>
                                        @else

                                        @endif
                                    </td>
                                    <td>
                                        @if($each->is_deleted!=1)                                       
                                            <a href="javascript:void(0);" data-id="{{$each->id}}" class="open_modal actnbtn"><i class="fa fa-edit"></i></a>
                                            <a onclick="return confirm('Are you sure to delete ?')" href="{{url('/admin/user-delete')}}/{{$each->id}}" data-id="{{$each->id}}" class="actnbtn"><i class="fa fa-trash"></i></a>                                           
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

    <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myModalLabel">Edit</h4>
                </div>
                <div class="modal-body" id="modalBody">
                    <!-- Ajax loaded data renders here -->
                </div>
               
            </div>
        </div>
    </div>


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
                    format: "mm/dd/yyyy",
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
            $("input[name='check_all_id[]']").change(function(){
                if($("input[name='check_all_id[]']:checked").length > 0)
                {
                    $('.deleteuser').html("Delete Selected Accounts");
                    $('.deleteuser').show();
                }
                else
                {
                    $('.deleteuser').html("");
                    $('.deleteuser').hide();
                }
            })
            

            $('input[name="check_all"]').change(function() {
                if($(this).prop('checked')){
                    $('.deleteuser').html("Delete All Account");
                    $('.select_all').prop('checked',true);
                    $('.deleteuser').show();
                }else{
                    $('.deleteuser').html("");
                    $('.select_all').prop('checked',false);
                    $('.deleteuser').hide();
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

        });
    </script>
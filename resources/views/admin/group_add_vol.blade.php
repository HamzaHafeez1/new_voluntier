			<div>Invite user</div>
			<table id="grouptovol" class="table">
                            <thead>
								<td class="first"><input type="checkbox" name="check_all"></td>
								<td>First name</td>
                                <td>last Name</td>
                                <td>Email</td>
                                <td>D.O.B</td>
                                <td>Primary Location</td>
                               
                              
                            </thead>
                            <tbody>
                                @if($list->count()>0)
                                @foreach($list as $each)
                                <tr>
									<td><input type="checkbox" name="check_all_id[]" class="select_all" value="{{$each->id}}"></td>
                                    <td>{{$each->first_name}}</td>
                                    <td>{{$each->last_name}}</td>
                                    <td>{{$each->email}}</td>
                                    <td>{{$each->birth_date}}</td>
                                    <td>{{$each->location}}</td>
                                </tr>
								 @endforeach
                                    @endif
                                </tbody>
            </table>
			 <div class="form-group">
                <div class="col-sm-9 text-right">
				<form id="frmuserID" action="{{url('/admin/group_add_vol_post')}}" method="post">
                          <input type="button" class="btn btn-primary btn-success" id="grp_save" name="grp_save" value="Invite Selected Users to {{$groupDetails->name}}">
						<input type="hidden" id="group_id" name="group_id" value="{{$group_id}}">
                           <input type="hidden" name="vol_ids" class="vol_ids" >
                           {!! csrf_field() !!}
                </form>
                </div>
				<div>&nbsp;</div>
            </div>
	<script type="text/javascript">
    jQuery(document).ready(function(){
        $('#grouptovol').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
    }); 
	 jQuery(document).ready(function($) {
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
			 $('#grp_save').click(function(){
                var ids = new Array();
                $('input[name="check_all_id[]"]:checked').each(function() {
                   ids.push(this.value);
                 });
                if(ids.length <=0)  
                {  
                     alert("Please select row.");  
                }else{                    
                    var check = confirm("Are you sure you want to Add this row?");  
                        if(check == true){ 
                            $('.vol_ids').val(ids);
                            $('#frmuserID').submit();
                        }
                    }
            });

	});
    </script>
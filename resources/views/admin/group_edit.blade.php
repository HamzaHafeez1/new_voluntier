<form id="frmUsers" name="frmUsers" class="form-horizontal" method="post" novalidate="" action="{{url('admin/groupeditPost')}}" enctype="multipart/form-data">
    <div class="row">

        <div class="col-sm-9">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Group Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="grp_name" name="grp_name" placeholder="Group Name" value="{{$userdetails->name}}">
                </div>
            </div>
			<div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Admin Name</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="Admin Name" value="{{$userdetails->contact_name}}">
                </div>
            </div>
			<div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Admin Email</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="admin_email" name="admin_email" placeholder="Admin Email" value="{{$userdetails->contact_email}}">
                </div>
            </div>
			<div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Date Created</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control date_created" id="date_created" name="date_created" placeholder="YYYY-MM-DD" value="{{$userdetails->created_at}}">
                </div>
            </div>
			<div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Logo</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" id="logo_img" name="logo_img">
                </div>
            </div>
			<div class="form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Description</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="description">{{$userdetails->description}}</textarea>
                </div>
            </div>
        </div>
        
            <div class="form-group">
                <div class="col-sm-9 text-right">
                    <input type="hidden" id="edit_group_id" name="edit_group_id" value="{{$userdetails->id}}">
                     <input type="submit" class="btn btn-primary btn-success" id="grp_save" name="grp_save" value="Save changes">
                </div>
            </div>

        </div>
    </div>
    {!! csrf_field() !!}
</form>
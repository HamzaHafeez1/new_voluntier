@include('admin.include.admin_header')

@include('admin.include.admin_head_nav')
<!-- Left side column. contains the logo and sidebar -->
@include('admin.include.admin_side_nav')

 <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>

        <section class="content">
        <div class="row">
                        <a href="{{url('/admin/user-list')}}">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="info-box">
                              <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                              <div class="info-box-content">
                                <span class="info-box-text">Total Accounts</span>
                                <span class="info-box-number">{{count($userLists)}}</span>
                              </div>
                            </div>
                        </div>
                        </a>
                        <a href="{{url('/admin/group-list')}}">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          
                          <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                              <span class="info-box-text">Total Groups</span>
                              <span class="info-box-number">{{count($groupLists)}}</span>
                            </div>
                          </div>
                        </div>
                      </a>
            </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@include('admin.include.admin_footer')
   
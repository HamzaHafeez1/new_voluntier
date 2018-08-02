<!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          {{-- <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p>Alexander Pierce</p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form> --}}
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Dashboard</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">               
                <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-circle-o"></i> Dashboard</a>     
              </li>
            </ul>
          </li>
                       
            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Accounts</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">               
                <li><a href="{{url('/admin/user-list')}}"><i class="fa fa-circle-o"></i> Accounts</a></li>
              </ul>
            </li>
            <!-- <li>
              <a href="{{url('/admin/user-list')}}">
                <i class="fa fa-table"></i> <span>User Management</span>
                
              </a>
            </li> -->
			      <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Groups</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">               
                <li><a href="{{url('/admin/group-list')}}"><i class="fa fa-circle-o"></i> Groups</a></li>
              </ul>
            </li>

            <li class="treeview">
              <a href="#">
                <i class="fa fa-table"></i> <span>Pending</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">               
                <li><a href="{{url('/admin/pending')}}"><i class="fa fa-circle-o"></i> Groups</a></li>
              </ul>
            </li>
            
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
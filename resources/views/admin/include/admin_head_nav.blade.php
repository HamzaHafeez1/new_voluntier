<header class="main-header">
        <!-- Logo -->
        <a href="../../index2.html" class="logo">
         <span class="logo-mini"><b>tier</b></span>
         <span class="logo-lg">MyVolun<b>tier</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
           <div class="navbar_cutom_left">
               <ul class="nav navbar-nav">
			     @if(Request::segment(2)== 'dashboard')
					<li class="active">                   
				 @else
					  <li>
				 @endif
            <a href="{{url('/admin/dashboard')}}">Dashboard</a>
                 </li> 
				 @if(Request::segment(2)== 'user-list')
					<li class="active">                   
				 @else
					  <li>
				 @endif
                     <a href="{{url('/admin/user-list')}}"> Accounts</a>
                 </li>        
				 @if(Request::segment(2)== 'group-list')
					 <li class="active">
				 @else
					  <li>
				 @endif
                    <a href="{{url('/admin/group-list')}}">Groups</a>
                 </li>
				 
               </ul>    
           </div>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- Notifications: style can be found in dropdown.less -->
             
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-user"></i>                  
                </a>
                <ul class="dropdown-menu">                 
                
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="{{url('/admin/admin-logout')}}" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>
        </nav>
      </header>
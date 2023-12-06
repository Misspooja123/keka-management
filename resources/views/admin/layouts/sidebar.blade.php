<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('admin/dashboard') }}" class="brand-link" style="text-align: center;">
        {{-- <img src="{{ asset('/theme/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
  <img src="{{ asset('theme/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
</div> --}}
            <div class="info">
                <a href="#" class="d-block" align="center">Alexander Pierce</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt fa-sm nav-icon"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/attendance') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>
                        <p>
                            Attendance
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/leave') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>

                        <p>
                            Leaves
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/department') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>

                        <p>
                            Departments
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/employee') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>

                        <p>
                            Employees
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/marksheet') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>

                        <p>
                            Marksheet
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/role') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>

                        <p>
                            Role
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('admin/marksheet') }}" class="nav-link">
                        <i class="fa-solid fa-user fa-sm nav-icon"></i>

                        <p>
                            AdminUser
                        </p>
                    </a>
                </li>

            </ul>
        </nav>


        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

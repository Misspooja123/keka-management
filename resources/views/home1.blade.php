<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="container">
                        <div class="row">
                            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                                <ul class="navbar-nav">

                                    <li class="nav-item d-none d-sm-inline-block">
                                        <a href="{{ url('home') }}" class="nav-link">Dashboard</a>
                                    </li>

                                    <li class="nav-item d-none d-sm-inline-block">
                                        <a href="{{ url('attendance') }}" class="nav-link">Attendance</a>
                                    </li>

                                    <li class="nav-item d-none d-sm-inline-block">
                                        <a href="{{ url('leave') }}" class="nav-link">Leave</a>
                                    </li>

                                    <li class="nav-item d-none d-sm-inline-block">
                                        <a href="{{ url('employee') }}" class="nav-link">Employees</a>
                                    </li>

                                    <li class="nav-item d-none d-sm-inline-block">
                                        <a href="{{ url('marksheet') }}" class="nav-link">Marksheet</a>
                                    </li>

                                    {{-- <li class="nav-item d-none d-sm-inline-block">
                                        <a href="{{ url('upload') }}" class="nav-link">Imageupload</a>
                                    </li> --}}
                                </ul>
                            </nav>
                        </div>
                    </div>

                </div>

                <div class="card-body">
                    <main class="py-4">

                        @yield('content')
                    </main>

                </div>
            </div>
        </div>
    </div>
</div>


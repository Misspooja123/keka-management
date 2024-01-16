<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('admin/dashboard') }}" class="nav-link">Dashboard</a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('admin/logout') }}" class="nav-link">Logout</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                <i class="fas fa-search"></i>
            </a>
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>

        <style>
            .drop_msg {
                width: 5cm;

            }
        </style>
        <script>
            // Function to toggle the visibility of the dropdown
            function toggleDropdown() {
                var dropdown = document.querySelector('.dropdown-menu');
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
            }
        </script>

        <!-- Notifications Dropdown Menu -->
        <div id="message_field">
            <li class="nav-item dropdown">
                @php
                    $userCount = App\Models\User::where('is_read', 1)->count();
                @endphp
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell" onclick="toggleDropdown()"></i>
                    <span class="badge badge-warning navbar-badge" style="right: -1px; top: 2px; padding: 3px"
                        id="userCount">{{ $userCount }}</span>
                </a>
                @php
                    $userCount = App\Models\User::where('is_read', 1)->count();
                @endphp

                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header" id="notificationCount">{{ $userCount }}
                        Notifications</span>
                    <div class="dropdown-divider"></div>
                    @php
                        $user = App\Models\User::all();
                    @endphp
                    <div class="drop_msg p-2">
                        @foreach ($user as $data)
                            <div class="update_status @if ($data->is_read) text-secondary @else text-success @endif"
                                style="border: none; cursor: pointer; display:flex;"
                                data-notification-id="{{ $data->id }}" onclick="markAsRead(this);">
                                <span>{{ $data->name }} is registered</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>

            </li>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script>
            function markAsRead(element) {
                var notificationId = element.getAttribute('data-notification-id');

                if (!element.classList.contains('text-secondary')) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{ route('notification.update', ['id' => ':id']) }}".replace(':id', notificationId),
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            element.classList.remove('text-success');
                            element.classList.add('text-secondary');
                            var userCountElement = document.getElementById('userCount');
                            userCountElement.textContent = parseInt(userCountElement.textContent) - 1;

                            var userCountElement = document.getElementById('notificationCount');
                            userCountElement.textContent = (parseInt(userCountElement.textContent) - 1) +
                                ' Notifications';
                        },
                        error: function(error) {
                            Swal.fire('Error', 'Could not mark as read', 'error');
                        }
                    });
                }
            }
        </script>

        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        <li class="nav-item d-none d-sm-inline-block">
            @php
                $user = Auth::guard('admin')->user()->name;
            @endphp
            <span class="nav-link">{{ $user }}</span>
        </li>
        {{-- <li class="nav-item">
            @php
                $user = Auth::guard('admin')->name;
            @endphp
            <h3> {{ $user }} </h3>
        </li> --}}
    </ul>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ URL('/') }}"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>
</nav>

<!-- /.navbar -->

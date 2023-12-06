@extends('admin.layouts.layouts')

@section('content')
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Admin</b></a>
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    <form action="{{ url('admin/login') }}" method="post" class="login-user">
                        @csrf
                        @if ($errors->any())
                            <div class="alert alert-danger home">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (Session::has('error_message'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error :</strong> {{ Session::get('error_message') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ old('email') }}" placeholder="Email">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>

                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggle-password">
                                    <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                </span>
                            </div>
                            <script src="https://code.jquery.com/jquery-3.5.1.min.js"
                                integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
                            <script>
                                $(document).ready(function() {
                                    const passwordField = $('#password');
                                    const togglePassword = $('#toggle-password');

                                    // Toggle password visibility
                                    togglePassword.click(function() {
                                        const fieldType = passwordField.attr('type');
                                        if (fieldType === 'password') {
                                            passwordField.attr('type', 'text');
                                            togglePassword.html('<i class="fa fa-eye" aria-hidden="true"></i>');
                                        } else {
                                            passwordField.attr('type', 'password');
                                            togglePassword.html('<i class="fa fa-eye-slash" aria-hidden="true"></i>');
                                        }
                                    });
                                });
                            </script>


                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block" style="text-align: center;"
                                id="form_submit">Sign
                                In</button>
                        </div>
                        <br />
                    </form>

                    <p class="mb-1" align="center">
                        <a href="#">I forgot my password</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- @push('script')
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
    <script>
        window.addEventListener('load', function() {
            $(".login-user").validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address"
                    },
                    password: {
                        required: "Password is required",
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.input-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush --}}

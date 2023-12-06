@extends('layouts.app1')

@section('content')
    <div class="container">
        @if ($marks != null)
            <a class="btn btn-primary btn-sm " style="margin-left:1150px"
                href="{{ route('user.downloadmarks', ['id' => $marks->id]) }}" target="_blank">
                <i class="fa fa-download"></i> Download
            </a>
        @endif

        <h1>Mark Sheet</h1>
        <div id="post-container">
            <div class="row">
                <div class="col-md-6">
                    <form id="marksheet-form" class="border p-3">
                        @csrf
                        <input type="hidden" name="id" id="editUserId">
                        <div class="form-group row">
                            <label for="bio" class="col-sm-4 col-form-label">Biology:</label>
                            <div class="col-sm-8">
                                <input type="number" name="bio" id="bio" class="form-control"
                                    @if ($marks != null) value="{{ $marks->bio }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('bio'))
                                    <span class="text-danger">{{ $errors->first('bio') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="mathematics" class="col-sm-4 col-form-label">Mathematics:</label>
                            <div class="col-sm-8">
                                <input type="number" name="mathematics" id="mathematics" class="form-control"
                                    @if ($marks != null) value="{{ $marks->mathematics }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('mathematics'))
                                    <span class="text-danger">{{ $errors->first('mathematics') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="science" class="col-sm-4 col-form-label">Science:</label>
                            <div class="col-sm-8">
                                <input type="number" name="science" id="science" class="form-control"
                                    @if ($marks != null) value="{{ $marks->science }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('science'))
                                    <span class="text-danger">{{ $errors->first('science') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="socialscience" class="col-sm-4 col-form-label">Social Science:</label>
                            <div class="col-sm-8">
                                <input type="number" name="socialscience" id="socialscience" class="form-control"
                                    @if ($marks != null) value="{{ $marks->socialscience }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('socialscience'))
                                    <span class="text-danger">{{ $errors->first('socialscience') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="english" class="col-sm-4 col-form-label">English:</label>
                            <div class="col-sm-8">
                                <input type="number" name="english" id="english" class="form-control"
                                    @if ($marks != null) value="{{ $marks->english }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('english'))
                                    <span class="text-danger">{{ $errors->first('english') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gujarati" class="col-sm-4 col-form-label">Gujarati:</label>
                            <div class="col-sm-8">
                                <input type="number" name="gujarati" id="gujarati" class="form-control"
                                    @if ($marks != null) value="{{ $marks->gujarati }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('gujarati'))
                                    <span class="text-danger">{{ $errors->first('gujarati') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hindi" class="col-sm-4 col-form-label">Hindi:</label>
                            <div class="col-sm-8">
                                <input type="number" name="hindi" id="hindi" class="form-control"
                                    @if ($marks != null) value="{{ $marks->hindi }}" @endif>
                                <div class="error-message text-danger"></div>
                                @if ($errors->has('hindi'))
                                    <span class="text-danger">{{ $errors->first('hindi') }}</span>
                                @endif
                            </div>
                        </div>
                        @if ($marks != null)
                            <button type="submit" class="btn btn-primary" id="update_marks">Update</button>
                        @else
                            <button type="submit" class="btn btn-primary">Submit</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

    <script type="text/javascript">
        $(function() {
            $('#marksheet-form').validate({
                errorPlacement: function(error, element) {
                    error.appendTo(element.parent().find('.error-message'));
                },
                rules: {
                    bio: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },
                    mathematics: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },
                    science: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },
                    socialscience: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },
                    english: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },
                    gujarati: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },
                    hindi: {
                        required: true,
                        number: true,
                        range: [0, 100]
                    },

                },
                messages: {
                    bio: {
                        required: "Biology marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },
                    mathematics: {
                        required: "Mathematics marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },
                    science: {
                        required: "Science marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },
                    socialscience: {
                        required: "Social Science marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },
                    english: {
                        required: "English marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },
                    gujarati: {
                        required: "Gujarati marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },
                    hindi: {
                        required: "Hindi marks are required.",
                        number: "Please enter a valid number.",
                        range: "Please enter a value between 0 and 100."
                    },

                },
                submitHandler: function(form) {
                    var formData = new FormData(form);

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('marksheet.update') }}',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire('Success',
                                'Marks submitted successfully...',
                                'success');
                            // $(form)[0].reset();
                            $('#post-container').load(document.URL +
                                ' #post-container');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error',
                                'Marksheet not submitted.',
                                'error');
                        }
                    });
                }
            });



        });
    </script>
@endpush

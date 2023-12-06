@extends('layouts.app1')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-left" style="color: rgb(3, 64, 133)">
                    <div class="card-header">
                        Post
                    </div>
                    <form id="post-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <!-- Text content input -->
                            <div id="header">
                                <textarea id="text_content" class="col-md-12" name="text" placeholder="Write your post here" style="border: none;"></textarea>
                            </div>
                            <!-- Image file input --></br>
                            <div id="img_post" style="display: none;">
                                <label for="imageInput" class="custom-file-upload">
                                    <i class="fa-solid fa-image fa-xl ml-4"></i>
                                </label>
                                <input type="file" id="imageInput" name="image" style="display: none;">
                            </div>
                        </div>
                        <div class="card-footer text-muted text-right" id="footer_div" style="display: none;">
                            <button type="button" class="btn btn-secondary" id="cancel_btn">Cancel</button>
                            <button class="btn btn-primary" type="submit" id="post-button">Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div></br>


    <div id="post-container">
        <!-- Display posts here -->
        @php
            $userpost = App\Models\Post::with('user')->orderBy('id', 'desc')->get();
        @endphp

        @foreach ($userpost as $data)
            <div id="refresh_page">
                <div class="col-md-6 p-2">
                    <div class="card text-center">
                        <div class="card-header">
                            <h5 class="text-left">{{ $data->user->name }} <span style="font-size: 15px">created a
                                    post</span>
                            </h5>
                        </div>
                        <div class="card-body p-3">
                            @if ($data->text != null)
                                <p class="text-left">{{ $data->text }}</p>
                            @endif
                            @if ($data->image != null)
                                <img src="{{ asset('assets/Post/' . $data->image) }}" alt="Image"
                                    style="height: 200px; width:200px">
                            @endif
                        </div>

                        <div class="card-footer text-muted text-left" id="footer_div">
                            @php

                                $like_post = App\Models\Like::where('post_id', $data->id)
                                    ->where('user_id', Auth::user()->id)
                                    ->first();
                            @endphp
                            @if ($like_post == null)
                                <button id="like-button-{{ $data->id }}" data-post-id="{{ $data->id }}"
                                    data-liked="{{ $data->liked ? 'true' : 'false' }}"
                                    onclick="toggleLike({{ $data->id }})" type="submit" style="border: none">
                                    <i class="far fa-thumbs-up fa-lg"></i>
                                </button>
                                <span>Like</span>
                            @else
                                <button id="like-button-{{ $data->id }}" data-post-id="{{ $data->id }}"
                                    data-liked="{{ $data->liked ? 'true' : 'false' }}"
                                    onclick="toggleLike({{ $data->id }})" type="submit" style="border: none">
                                    <i class="fas fa-thumbs-up fa-lg"></i>
                                </button>
                                <span>Like</span>
                                {{-- <button style="border: none"><i class="far fa-comment-alt fa-lg"></i></button>
                            <span>Comment</span> --}}
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function() {

                // $("#post-button").click(function() {
                //     $('#post-container').load(document.URL +  ' #post-container');
                // });

                $("#cancel_btn").click(function() {
                    $("#footer_div").hide();
                    $("#img_post").hide();
                });

                $('#text_content').click(function() {
                    $("#footer_div").show();
                    $("#img_post").show();
                });

                $('#post-form').submit(function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);

                    if ($('#text_content').val() === '') {
                        // Display a Toastr error message
                        toastr.error('Please enter text for your post.');
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('posts.store') }}',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            Swal.fire('Success',
                                'Post submitted successfully...',
                                'success');
                            $('#post-form')[0].reset();
                            $('#post-container').load(document.URL +
                            ' #post-container');
                        },
                        error: function(xhr, status, error) {
                            Swal.fire('Error', 'Failed to submit post.',
                                'error');
                        }
                    });
                });
            });
        });


        function toggleLike(postId) {
            var likeButton = $('#like-button-' + postId);
            var isLiked = likeButton.attr('data-liked') === 'true';
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                type: 'POST',
                url: '{{ route('posts.toggle-like') }}',
                data: {
                    post_id: postId,
                    is_liked: isLiked
                },
                success: function(data) {
                    if (data.is_liked) {

                        likeButton.attr('data-liked', 'true');
                        likeButton.find('i').addClass('fas').removeClass(
                            'far');
                    } else {
                        likeButton.attr('data-liked', 'false');
                        likeButton.find('i').addClass('far').removeClass(
                            'fas');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                }
            });
        }
    </script>
@endpush

@extends('layouts.app1')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card text-left">
                    <div class="card-header">
                        Post
                    </div>
                    <div class="card-body">
                        <div _ngcontent-cah-c49="" quill-editor-element="" class="ng-star-inserted ql-container ql-snow"
                            style="height: auto; min-height: 100px; font-family: &quot;Proxima Nova&quot;; position: relative;">
                            <div class="ql-editor ql-blank" data-gramm="false" contenteditable="true"
                                aria-owns="quill-mention-list" data-placeholder="Write your post here">
                                <div><br></div>
                            </div>
                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                        </div>

                    </div>
                    <div class="card-footer text-muted text-right">
                        <a href="#" class="btn btn-secondary">Cancel</a>
                        <a href="#" class="btn btn-primary">Post</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
@endpush

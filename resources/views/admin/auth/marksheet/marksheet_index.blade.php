@extends('admin.layouts.master')

@section('content')
    <style>
        .table-container {
            max-width: 100%;
            overflow-x: auto;
        }
    </style>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Manage Marksheet
            </div>
            <div class="card-body">
                <div class="table-container">
                    <table class="data-table">
                        {!! $dataTable->table(['class' => 'table table-bordered dt-responsive nowrap']) !!}
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>

    $(document).ready(function() {
        $('.download-button').on('click', function() {
            var id = $(this).data('id');

            $.ajax({
                url: '/admin/download-pdf/' + id,
                method: 'GET',
                success: function(pdfData) {
                    // Download the received PDF data as a file.
                    var blob = new Blob([pdfData], { type: 'application/pdf' });
                    var link = document.createElement('a');
                    link.href = window.URL.createObjectURL(blob);
                    link.download = 'downloaded.pdf';
                    link.click();
                },
                error: function() {
                    alert('Failed to download the PDF.');
                }
            });
        });
    });
</script>


@endpush

@extends('common.layouts.master')
@section('title', 'Error Logs')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                {{-- end vide --}}
                <div class="card card-solid mt-2">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h3>Description</h3>
                                        @if ($errorLog->ticketStatus == 'Pending')
                                            <span
                                                class="badge badge-pill badge-warning px-3 py-1">{{ $errorLog->ticketStatus }}</span>
                                        @elseif ($errorLog->ticketStatus == 'Resolved')
                                            <span
                                                class="badge badge-pill badge-success px-3 py-1">{{ $errorLog->ticketStatus }}</span>
                                        @elseif ($errorLog->ticketStatus == 'Other')
                                            <span
                                                class="badge badge-pill badge-dark px-3 py-1">{{ $errorLog->ticketStatus }}</span>
                                        @endif
                                    </div>
                                    <div class="col-md-4 text-right">
                                        @if ($errorLog->ticketStatus == 'Pending')
                                            <button class="btn btn-primary btn-sm"
                                                onclick="actionOnTicket({{ $errorLog->id }},'Resolved')"><i
                                                    class="nav-icon fa fa-check-circle"></i> Resolve</button>
                                            <button class="btn btn-secondary btn-sm"
                                                onclick="actionOnTicket({{ $errorLog->id }},'Other')"><i
                                                    class="nav-icon fa fa-th-large"></i> Other</button>
                                        @endif
                                    </div>
                                </div>
                                <p></p>

                                <hr>
                                <div class="row">
                                    <div class="col-md-9">
                                        <h4>Error Log Information</h4>
                                    </div>
                                    <div class="col-md-3">
                                        <h5>Date: <span class="text-secondary errorLogDate"></span></h5>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <div class="">
                                        <b>Ticket No:</b> {{ $errorLog->id }}
                                    </div>
                                    <div class="">
                                        <b>File Path:</b> {{ $errorLog->filePath }}
                                    </div>
                                    <div class="">
                                        <b>Line No:</b> {{ $errorLog->lineNo }}
                                    </div>
                                    <div class="">
                                        <b>Status Code:</b> {{ $errorLog->statusCode }}
                                    </div>
                                    <div class="">
                                        <b>Message:</b> {{ $errorLog->errorMessage }}
                                    </div>


                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                @if ($errorLog->developerComment != null)
                    <div class="card card-solid">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="row my-3">
                                        <div class="col-md-10">
                                            <h3>Developer Comment </h3>
                                            <h6>Date: <span class="text-secondary developerCommentDate"></span></h6>
                                        </div>
                                        <div class="col-md-2 text-right">
                                            @if ($errorLog->ticketStatus != 'Pending')
                                                <button class="btn btn-primary"
                                                    onclick="updateDeveloperComment({{ $errorLog->id }},'{{ $errorLog->ticketStatus }}')">Edit</button>
                                            @endif
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="mt-4">
                                        {{ $errorLog->developerComment }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                @endif
            </div>
            @include('admin.partialPages.sidebar.errorLog.modal.addComment')
        </section>
    </div>
@endsection


@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function actionOnTicket(id, type) {
            $("#ticketCommentModal").modal('show')
            $("#ticketId").val(id)
            $("#ticketStatus").val(type)
        }

        function updateDeveloperComment(id, type) {
            $("#ticketCommentModal").modal('show')
            $("#ticketId").val(id)
            $("#ticketStatus").val(type)
            $("#developerComment").val(`{{ $errorLog->developerComment }}`)
        }

        $("#submitCommentForm").submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                success: function(resonse) {
                    if (resonse.status == true) {
                        $("#ticketCommentModal").modal('hide')
                        location.reload();
                    }
                }
            }).done(function(data) {
                console.log(data);
            });

        });

        $(".errorLogDate").text(new Date('{{ $errorLog->createdAt }} UTC').toLocaleString("en-us", {
            hour12: true,
            weekday: "short",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            month: "long",
            year: "numeric",
        }));

        $(".developerCommentDate").text(new Date('{{ $errorLog->updatedAt }} UTC').toLocaleString("en-us", {
            hour12: true,
            weekday: "short",
            day: "2-digit",
            hour: "2-digit",
            minute: "2-digit",
            month: "long",
            year: "numeric",
        }));
    </script>
@stop

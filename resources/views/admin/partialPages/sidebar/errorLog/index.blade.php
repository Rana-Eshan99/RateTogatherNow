@extends('common.layouts.master')
@section('title', 'Error Logs')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.2.2/css/fixedColumns.dataTables.min.css">
    <style>
        .custom-cls {
            display: inline;
            width: 180px;
            margin-left: 25px;
        }

        th,
        td {
            white-space: nowrap;
        }

        div.dataTables_wrapper {
            margin: 0 auto;
        }

        div.container {
            width: 100%;
        }
        table.dataTable thead>tr>th.sorting_asc:before,
        table.dataTable thead>tr>th.sorting_asc:after{
            display: none;
        }
        table.dataTable thead tr>.dtfc-fixed-left{
            background-color: #f4f6f9;
        }
        table.dataTable thead .sorting_asc {
            background-image: none;
        }
    </style>
@stop

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <label>Error Logs</label>
                <div style="padding:20px" class="container">
                    <select name="ticketStatus" id="ticketStatusFilter" class="form-control mx-1 custom-cls">
                        <option value="" selected>Ticket Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Resolved">Resolved</option>
                        <option value="Other">Other</option>
                    </select>

                    <table class="table table-bordered data-table-error stripe row-border order-column" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Ticket No</th>
                                <th>Message</th>
                                <th>Ticket Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <!-- /.row -->
            </div>
            <!--/. container-fluid -->
        </section>

        @include('admin.partialPages.sidebar.errorLog.modal.addComment')
    </div>
@endsection

@section('script')
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/fixedcolumns/4.2.2/js/dataTables.fixedColumns.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('.data-table-error').DataTable({
            lengthMenu: [
                [10, 50, 100, 250, 500, 100, 0 - 1],
                [10, 50, 100, 250, 500, 1000, "All"]
            ],
            pageLength: 10,
            processing: true,
            stateSave: true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                "emptyTable": "No data available "
            },
            serverSide: true,
            searching: true,
            ordering: true,
            ajax: {
                url: "{{ url('error-logs') }}",
                type: "GET",
                data: function(d) {
                    d.ticketStatus = $("#ticketStatusFilter").val()
                    return d;
                },
            },
            columnDefs: [{
                targets: [0,1,2,3],
                orderable: false
            }],
            scrollCollapse: true,
            scrollX: true,
            fixedColumns: true,
            columns: [{
                    data: 'id'
                },
                {
                    data: 'errorMessage'
                },
                {
                    data: 'ticketStatus'
                },
                {
                    data: 'action'
                },
            ],
        });


        $("#DataTables_Table_0_filter.dataTables_filter").append($("#ticketStatusFilter"));

        //When you change event for the Gender Filter dropdown to redraw the datatable
        $("#ticketStatusFilter").change(function(e) {
            table.draw();
        });
    </script>

    <script type="text/javascript">
        function actionOnTicket(id, type) {
            $("#ticketCommentModal").modal('show')
            $("#ticketId").val(id)
            $("#ticketStatus").val(type)
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
    </script>
@stop

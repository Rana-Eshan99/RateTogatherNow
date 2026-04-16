@extends('common.layouts.master')
@section('title', 'Organization - Add')
@section('headerHeading', 'Organization Add')
@section('style')
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">

            <br>
            <!-- Default box -->
            <div class="card customBorderRadius">
                <div class="card-header">
                    <h3 class="card-title">Rate Together Now </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <p>Welcome to the Rate Together Now  section! Here, you can provide constructive feedback to your peers and
                        help each other grow professionally.</p>

                    <p>Sharing feedback is an essential part of personal and professional development. Make sure your
                        feedback is:</p>
                    <ul>
                        <li><strong>Constructive:</strong> Offer suggestions for improvement.</li>
                        <li><strong>Specific:</strong> Focus on particular aspects of performance.</li>
                        <li><strong>Respectful:</strong> Maintain a positive and respectful tone.</li>
                    </ul>

                </div>
            </div>
            <!-- /.card -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('script')

@endsection

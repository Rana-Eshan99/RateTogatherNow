@extends('common.layouts.master')
@section('title', 'Home')
@section('headerHeading') Home @endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('css/user/customBorder.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Home</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

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
                    <p class="">Welcome to the Rate Together Now  section! Here, you can provide constructive feedback to
                        your peers and
                        help each other grow professionally.</p>

                    <p class="">Sharing feedback is an essential part of personal and professional development.
                        Make sure your
                        feedback is:</p>
                    <ul>
                        <li><strong>Constructive:</strong> Offer suggestions for improvement.</li>
                        <li><strong>Specific:</strong> Focus on particular aspects of performance.</li>
                        <li><strong>Respectful:</strong> Maintain a positive and respectful tone.</li>
                    </ul>

                    <h4>Feedback Categories</h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-lightbulb"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Creativity</span>
                                    <span class="info-box-number">Rate the creativity and innovation.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Productivity</span>
                                    <span class="info-box-number">Evaluate productivity and efficiency.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Teamwork</span>
                                    <span class="info-box-number">Assess teamwork and collaboration.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="">We believe in continuous improvement. By providing thoughtful and constructive
                        feedback, you can make
                        a positive impact on your peers' professional journeys. Let's help each other grow!</p>
                </div>
            </div>
            <!-- /.card -->


        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

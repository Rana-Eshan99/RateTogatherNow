@extends('common.layouts.master')
@section('title', 'Configuration Variables')

@section('style')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 80px;
            height: 24px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div style="padding-top: 43px" class="container">
                    <div class="row">
                        <div class="col-6">
                            <h4>
                                <b>Configuration Variables</b>
                            </h4>
                        </div>
                        <div class="col-6">
                            @if (count($configs) > 0)
                                <a class="btn btn-primary" href="{{ url('configuration-variable-edit') }}">Edit Configuration
                                    Variables</a>
                            @endif
                        </div>
                    </div>

                    <!-- Info boxes -->
                    <div class="mt-5">


                        <div class="row">
                            <div class="col-md-4" style="border-bottom: 1px solid black;">
                                <h6><b> Variables</b></h6>
                            </div>
                            <div class="col-md-2" style="border-bottom: 1px solid black;">
                                <h6><b> Values</b></h6>
                            </div>
                            <div class="col-md-6" style="border-bottom: 1px solid black;">
                                <h6><b> Comments</b></h6>
                            </div>
                        </div>
                        @if (count($configs) > 0)
                            @foreach ($configs as $config)
                                <div class="form-row mt-2">
                                    <div class="form-group col-md-4">
                                        {{ $config->configName }}

                                    </div>
                                    <div class="form-group col-md-2">
                                        @if ($config->type == 'ConfigBoolean')
                                            @if ($config->value == true)
                                                <span class="badge badge-pill switch"
                                                    style="background-color: #2ab934; color:white;padding-top: 5px;">TRUE</span>
                                            @else
                                                <span class="badge badge-pill badge-danger switch"
                                                    style="padding-top: 5px;">FALSE</span>
                                            @endif
                                        @elseif($config->type == 'ConfigNumber')
                                            {{ $config->value }}
                                        @else
                                            {{ $config->value }}
                                        @endif
                                    </div>
                                    <div class="form-group col-md-6">
                                        {{ $config->comment }}
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    No record found.
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

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

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ca2222;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 3px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2ab934;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(55px);
        }

        /*------ ADDED CSS ---------*/
        .slider:after {
            content: 'FALSE';
            color: white;
            display: block;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            font-size: 10px;
            font-family: Verdana, sans-serif;
        }

        input:checked+.slider:after {
            content: 'TRUE';
        }

        /*--------- END --------*/
    </style>
@endsection

@section('content')
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div style="padding-top: 43px" class="container">
                    <h4>
                        <b>Configuration Variables</b>
                    </h4>
                    <!-- Info boxes -->
                    <div class="mt-5">
                        <form action="{{ url('configuration-variable-update') }}" method="POST">
                            @csrf
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
                            @foreach ($configs as $config)
                                <div class="form-row mt-3">
                                    <div class="col-md-4">
                                        {{ $config->configName }}
                                    </div>
                                    <div class="col-md-2">
                                        @if ($config->type == 'ConfigBoolean')
                                            <div class="checkbox switcher">
                                                <label class="switch">
                                                    <input type="checkbox" name="{{ 'name' . $config->id }}"
                                                        {{ $config->value == true ? 'checked' : '' }}>
                                                    <div class="slider round"></div>
                                                </label>
                                            </div>
                                        @elseif($config->type == 'ConfigNumber')
                                            @if ($config->name == 'STRIPE_PERCENTAGE_SERVICE_FEE' or $config->name == 'STRIPE_FLAT_SERVICE_FEE')
                                                <input type="number" class="form-control" name="{{ 'name' . $config->id }}"
                                                    value="{{ $config->value }}" placeholder="Value Number" disabled>
                                            @else
                                                <input type="number" class="form-control" name="{{ 'name' . $config->id }}"
                                                    value="{{ $config->value }}" placeholder="Value Number" required>
                                            @endif
                                        @else
                                            <input type="text" class="form-control" name="{{ 'name' . $config->id }}"
                                                value="{{ $config->value }}" placeholder="Value String" required>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="{{ 'comment' . $config->id }}"
                                            value="{{ $config->comment }}" placeholder="Comment">
                                    </div>
                                </div>
                            @endforeach

                            <button class="btn btn-primary" type="submit">Save Configuration</button>

                        </form>
                    </div>
                </div>
                <!-- /.row -->
            </div><!--/. container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection

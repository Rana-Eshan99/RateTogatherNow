@extends('common.layouts.master')
@section('title', 'Feedbacks')
@section('headerHeading')  @endsection

@section('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="{{asset('css/components/table.css')}}">

<link rel="stylesheet" href="{{asset('css/components/general.css')}}">
<link rel="stylesheet" href="{{asset('css/appFeedback/feedbackTable.css')}}">
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header mb-0 pb-0">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-12">
                        <h1 class="h1">Feedbacks</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12 col-md-12 col-12">
                        <div class="card" style="border-radius: 10px;">
                            <div class="card-body p-0 pb-3 meeting table-responsive">
                                {{ $dataTable->table(['class' => 'table ']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @include('dashboard.feedback.modal.feelingModal')
    </div>
@endsection

@push('scripts')
<script src="{{asset('js/appFeedback/feedback.js')}}"></script>
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush

@extends('common.layouts.master')
@section('title', 'Terms & Condition')
@section('headerHeading')  @endsection

@section('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
<link href="{{ asset('css/dashboard/termsCondition.css') }}" rel="stylesheet">

@endsection

@section('content')
<div class="content-wrapper" style="background: rgb(252, 252, 252)">
    <section class="content">
        <div class="container-fluid">
            <div class="row condition-view-content justify-content-center align-items-center">
                <div class="col-12 col-lg-8 col-xl-8 col-md-8">
                    <div class="header-row">
                        <div class="heading-title">
                            <span class="condition-view-heading">{{ $termsCondition->title ?? null }}</span>
                        </div>
                        <div class="ml-auto col-4 col-lg-5 col-xl-5 col-md-5">
                            <a class="btn btn-outline-primary edit-button"
                                href="{{ route('term-condition.index', ['id' => $termsCondition->id]) }}">Edit</a>
                        </div>
                    </div>
                    <p class="condition-description">{!! $termsCondition->description !!}</p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/dashboard/termsCondition.js') }}"></script>
@endpush

@extends('common.layouts.master')
@section('title', 'Privacy Policy')
@section('headerHeading')  @endsection

@section('style')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">
<link href="{{ asset('css/dashboard/privacyPolicy.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/inputStyle.css') }}">

@endsection

@section('content')
<div class="content-wrapper" style="background: rgb(252, 252, 252)">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3 class="policy-title">Privacy Policy</h3>
                </div>
                <div class="col-sm-6"></div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid privacy-policy-content">
            <div class="row g-2 justify-content-center align-items-center">
                <div class="col-12 col-lg-6 col-xl-6 col-md-6">
                    <form id="createPrivacyPolicy">
                        @csrf
                        <div class="form-group">
                            <h4 class="input-label">Title</h4>
                            <input name="title" id="title" placeholder="Add title" class="inputBorder form-input form-control title" required value="{{ $privacyPolicy ? $privacyPolicy->title : '' }}">
                            <label id="title-error" class="error input-error-label" for="title"></label>
                        </div>
                        <div class="form-group mt-5 mb-5">
                            <h4 class="input-label">Description</h4>
                            <textarea id="description" name="description" class="inputBorder form-control description" rows="10" required>
                                {{ $privacyPolicy ? $privacyPolicy->description : '' }}
                            </textarea>
                        </div>
                        <div class="row no-gutters mt-4">
                            <div class="col-6 pr-1">
                                <a class="btn btn-outline-secondary view-button" href="{{ route('privacy-policy.view') }}" >View</a>
                            </div>
                            <div class="col-6 pl-1">
                                <button class="btn btn-block btn-primary w-100 save-button" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{asset('js/dashboard/privacyPolicy.js')}}"></script>
<script src="{{ asset('summernote/summernote-bs4.min.js') }}"></script>

<script>
      $('.description').summernote({
          height: 200,
          toolbar: [
                ['style', ['bold']],
                ['style', ['italic']],
                ['style', ['underline']],
                ['align', ['paragraph', 'center', 'right', 'justify']],
                ['para', ['ul']],
                ['para', ['ol']],
                ['color', ['color']],
                ['height', ['height']],
            ]
        });
</script>
@endpush

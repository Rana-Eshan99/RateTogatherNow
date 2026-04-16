@extends('common.layouts.master')
@section('title','Home')

@push('style')
    <link href="{{ asset('css/dashboard/dashboard.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 style="font-weight: bold;">Dashboard</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-2">
                        <div class="small-box shadow-none border-pink">
                            <div class="inner">
                                <h3> 6567</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="users-icon">
                                <svg width="42" height="42" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M35.0601 15.54C34.9201 15.52 34.7801 15.52 34.6401 15.54C31.5401 15.44 29.0801 12.9 29.0801 9.78C29.0801 6.6 31.6601 4 34.8601 4C38.0401 4 40.6401 6.58 40.6401 9.78C40.6201 12.9 38.1601 15.44 35.0601 15.54Z"
                                        fill="#4D61A8" />
                                    <path
                                        d="M41.58 29.4C39.34 30.9 36.1999 31.46 33.2999 31.08C34.0599 29.44 34.4599 27.62 34.4799 25.7C34.4799 23.7 34.04 21.8 33.2 20.14C36.16 19.74 39.3 20.3 41.56 21.8C44.72 23.88 44.72 27.3 41.58 29.4Z"
                                        fill="#4D61A8" />
                                    <path
                                        d="M12.8801 15.54C13.0201 15.52 13.1601 15.52 13.3001 15.54C16.4001 15.44 18.8601 12.9 18.8601 9.78C18.8601 6.58 16.2801 4 13.0801 4C9.90007 4 7.32007 6.58 7.32007 9.78C7.32007 12.9 9.78007 15.44 12.8801 15.54Z"
                                        fill="#4D61A8" />
                                    <path
                                        d="M13.1 25.7C13.1 27.64 13.52 29.48 14.28 31.14C11.46 31.44 8.51999 30.84 6.35999 29.42C3.19999 27.32 3.19999 23.9 6.35999 21.8C8.49999 20.36 11.52 19.78 14.36 20.1C13.54 21.78 13.1 23.68 13.1 25.7Z"
                                        fill="#4D61A8" />
                                    <path
                                        d="M24.2401 31.74C24.0801 31.72 23.9001 31.72 23.7201 31.74C20.0401 31.62 17.1001 28.6 17.1001 24.88C17.1201 21.08 20.1801 18 24.0001 18C27.8001 18 30.8801 21.08 30.8801 24.88C30.8601 28.6 27.9401 31.62 24.2401 31.74Z"
                                        fill="#4D61A8" />
                                    <path
                                        d="M17.7401 35.88C14.7201 37.9 14.7201 41.22 17.7401 43.22C21.1801 45.52 26.8201 45.52 30.2601 43.22C33.2801 41.2 33.2801 37.88 30.2601 35.88C26.8401 33.58 21.2001 33.58 17.7401 35.88Z"
                                        fill="#4D61A8" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-2">
                        <div class="small-box shadow-none border-pink">
                            <div class="inner died-user-inner">
                                <h3>23</h3>
                                <p>Died Users</p>
                            </div>
                            <div class="died-users-icon">
                                <svg width="42" height="42" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M18 4C12.76 4 8.5 8.26 8.5 13.5C8.5 18.64 12.52 22.8 17.76 22.98C17.92 22.96 18.08 22.96 18.2 22.98C18.24 22.98 18.26 22.98 18.3 22.98C18.32 22.98 18.32 22.98 18.34 22.98C23.46 22.8 27.48 18.64 27.5 13.5C27.5 8.26 23.24 4 18 4Z"
                                        fill="#E01E5A" />
                                    <path
                                        d="M28.1599 28.3C22.5799 24.58 13.4799 24.58 7.85992 28.3C5.31992 30 3.91992 32.3 3.91992 34.76C3.91992 37.22 5.31992 39.5 7.83992 41.18C10.6399 43.06 14.3199 44 17.9999 44C21.6799 44 25.3599 43.06 28.1599 41.18C30.6799 39.48 32.0799 37.2 32.0799 34.72C32.0599 32.26 30.6799 29.98 28.1599 28.3Z"
                                        fill="#E01E5A" />
                                    <path
                                        d="M39.98 14.68C40.3 18.56 37.54 21.96 33.72 22.42C33.7 22.42 33.7 22.42 33.68 22.42H33.62C33.5 22.42 33.38 22.42 33.28 22.46C31.34 22.56 29.56 21.94 28.22 20.8C30.28 18.96 31.46 16.2 31.22 13.2C31.08 11.58 30.52 10.1 29.68 8.84C30.44 8.46 31.32 8.22 32.22 8.14C36.14 7.8 39.64 10.72 39.98 14.68Z"
                                        fill="#E01E5A" />
                                    <path
                                        d="M43.98 33.18C43.82 35.12 42.58 36.8 40.5 37.94C38.5 39.04 35.98 39.56 33.48 39.5C34.92 38.2 35.76 36.58 35.92 34.86C36.12 32.38 34.94 30 32.58 28.1C31.24 27.04 29.68 26.2 27.98 25.58C32.4 24.3 37.96 25.16 41.38 27.92C43.22 29.4 44.16 31.26 43.98 33.18Z"
                                        fill="#E01E5A" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 pb-2">
                        <div class="small-box shadow-none border-pink">
                            <div class="inner posts-inner">
                                <h3> 24343</h3>
                                <p>Total Posts</p>
                            </div>
                            <div class="posts-icon">
                                <svg width="42" height="42" viewBox="0 0 48 48" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M31.5999 4.42C30.7799 3.6 29.3599 4.16 29.3599 5.3V12.28C29.3599 15.2 31.8399 17.62 34.8599 17.62C36.7599 17.64 39.3999 17.64 41.6599 17.64C42.7999 17.64 43.3999 16.3 42.5999 15.5C39.7199 12.6 34.5599 7.38 31.5999 4.42Z"
                                        fill="#2E3A64" />
                                    <path
                                        d="M41 20.38H35.22C30.48 20.38 26.62 16.52 26.62 11.78V6C26.62 4.9 25.72 4 24.62 4H16.14C9.98 4 5 8 5 15.14V32.86C5 40 9.98 44 16.14 44H31.86C38.02 44 43 40 43 32.86V22.38C43 21.28 42.1 20.38 41 20.38ZM23 35.5H15C14.18 35.5 13.5 34.82 13.5 34C13.5 33.18 14.18 32.5 15 32.5H23C23.82 32.5 24.5 33.18 24.5 34C24.5 34.82 23.82 35.5 23 35.5ZM27 27.5H15C14.18 27.5 13.5 26.82 13.5 26C13.5 25.18 14.18 24.5 15 24.5H27C27.82 24.5 28.5 25.18 28.5 26C28.5 26.82 27.82 27.5 27 27.5Z"
                                        fill="#2E3A64" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card dashboard-card-border chart-card shadow-none border-pink">
                            <div class="card-content-chart">

                                <canvas id="barChart" style="height: 100%; width:100vw"></canvas>

                                <select class="form-control border-pink" id="yearlyDropDown"
                                    data-route="{{ route('dashboard') }}">
                                    <option value="2021">2021</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option class="selected" value="2024" selected>2024</option>
                                </select>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/Dashboard/dashboard.js') }}"></script>
@endpush

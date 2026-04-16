<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>RateMyPeers | Terms & Conditions</title>
    <link rel="icon" href="{{ asset('img/officialLogo.png') }}" type="image/png">
    <link href="{{ asset('css/dashboard/privacyPolicy.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body style="font-family: poppins; background: rgb(252, 252, 252)">
    <div class="container-fluid container-custom">
        <div class="content-wrapper" style="margin-left: 0px">
            <section class="content">
                <div class="container-fluid">
                    <div class="row policy-view-content justify-content-center align-items-center">
                        <div class="col-md-8">
                            <div class="header-row-content">
                                <div class="icon-button">

                                </div>
                                <div class="heading-title" style="margin-left: 0px">
                                    <span class="policy-view-heading">Terms & Conditions</span>
                                </div>
                            </div>
                            <p class="policy-description">{!! $description !!}</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="{{asset('js/dashboard/termsCondition.js')}}"></script>
</body>

</html>

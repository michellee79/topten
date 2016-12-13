@extends('layouts.page_master')

@section('head')

    <style type="text/css">
        .validation
        {
            color: #B03535;
            font-size: 10px;
        }
        .stackValidation
        {
            color: #B03535;
            font-size: 10px;
            position: relative;
            top: 5px;
            right: 500px;
            float: right;
        }
        .watermark
        {            
            color: #999 !important;                     
        }
    </style>

@endsection

@section('content')

@include('common.sidetab')

<div class="mainContentContainer content">
    <div class="pgMainContainer">
        <div class="pgContainer">
            @if ($success)
                <div class="titleText" style="text-align:center;">
                    Congratulations!<br/>
                    Your account has been activated.
                </div>
                <div style="text-align:center; padding-top:100px; padding-bottom:100px;">
                    <a href="/" class="btn btn-warning btn-large">Go To Home</a>
                </div>
            @else
                <div class="titleText" style="text-align:center; padding-bottom:100px;">
                    Sorry! <br/>
                    We are not able to activate your account. <br/>
                    Please contact the support team<br/>
                    <a href="mailto:info@toptenpercent.com">info@toptenpercent.com</a>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="mobile-only">
    <div class="mobileContentPane">
        <div class="mobileContent">
            @if ($success)
                <div class="titleText" style="text-align:center;">
                    Congratulations!<br/>
                    Your account has been activated.
                </div>
                <div style="text-align:center; padding-top:100px; padding-bottom:100px;">
                    <a href="/" class="btn btn-warning btn-large">Go To Home</a>
                </div>
            @else
                <div class="titleText" style="text-align:center; padding-bottom:100px;">
                    Sorry! <br/>
                    We are not able to activate your account. <br/>
                    Please contact the support team<br/>
                    <a href="mailto:info@toptenpercent.com">info@toptenpercent.com</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
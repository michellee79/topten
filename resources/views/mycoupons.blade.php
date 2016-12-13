@extends('layouts.businesses_master')

@section('head')

	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

    <link href="/scripts/toastMessage/css/jquery.toastmessage.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>

    <script src="/js/account.js" type="text/javascript"></script>

    <script type="text/javascript">

        function showLoading() {
            $('.pgContainer').showLoading();
        }

        function hideLoading() {
            $('.pgContainer').hideLoading();
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this coupon?')) {
                showLoading();
            }
            else {
                event.preventDefault();
                return false;
                event.returnValue = false;
            }
        }
    
    </script>

    <style type="text/css">
        .borderDashedBottom{
            border-bottom:dashed 2px #333333;
        }
        .paddingTop10{
            padding-top: 10px;
        }
        .paddingBottom10{
            padding-bottom: 10px;
        }
        .profile{
            font-size: 10pt;
            color: #ffffff;
            line-height: 2;
        }
        .required{
            font-weight: bold;
            font-size: 8pt;
            color: #B03535;                            
        }
    </style>

@endsection

@section('content')
<div class="content">
@include('common.sidetab')
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <div>
                    <div id="UserCoupons" style="padding-left:25px; padding-right:25px;">
                        <div class="titleText borderDashedBottom">
                            My Coupons
                        </div>
                        <div id="MyCoupons">
                            @include('components.mycoupons')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-only" style="padding-bottom:30px;">
    <div class="mobileContentPane">
        <div class="mobileContent">
            <div id="MyCouponsMobile">
                @include('components.mycoupons_mobile')
            </div>
        </div>
    </div>
    
    @include('common.footer_mobile_widget')
</div>

@endsection
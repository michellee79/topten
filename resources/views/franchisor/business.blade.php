@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/js/franchisor/businesses.js" type="text/javascript"></script>

<style type="text/css">
    .verticalStitchDivider {
        background: url('/Images/img_vertStitching.png') no-repeat;
        width: 1px;
        height: 330px;
        float: left;
        margin: 0px 0 0 0;
    }

    .pagingContainer ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .pagingContainer li{
        display: inline;
        margin-left: 5px;
        font-size: 12px;
    }

    .pagingContainer li a{
        color: #999;
    }

</style>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">

            <div id="pnlUpdate">
                <div class="titleText">
                    Business List 
                </div>
                <div style="text-align: right; padding-bottom: 10px;">
                    <a id="lbAddNewBusiness" class="mini-gold" href="/franchise_add_business">
                        Add New Business
                    </a>
                </div>
                <br/>
                {!! filter_form($filters, $hasFilter) !!}
                <div>
                    <div id="businesses">
                        @include('components.franchisor.businesses')
                    </div>
                </div>
            </div>

            </div>
            
        </div>
    </div>
</div>

@endsection
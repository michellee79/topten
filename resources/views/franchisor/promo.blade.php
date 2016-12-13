@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<style type="text/css">
    .verticalStitchDivider {
        background: url('../Images/img_vertStitching.png') no-repeat;
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

    .Promo{
        color: white;
    }

    .Promo:hover{
        color:white;
    }

    .promoEditor{
        box-sizing: border-box;
        -webkit-box-sizing:border-box;
        -moz-box-sizing: border-box;
        background: #111;
        border-color: #111;
        color: white;
        margin: 0;
    }

</style>

<script type="text/javascript" src="/js/franchisor/promo.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            
            <div class="grid">
                <p class="titleText">
                    Manage Promo Codes</p>
                <div style="text-align: right; padding-bottom: 10px;">
                    <a id="AddNewPromo" class="btn btn-warning" style="font-weight: bold; cursor: pointer;" href="javascript:showFields();">
                        Add New Promo Code
                    </a>
                </div>

                {!! filter_form($filters, $hasFilter) !!}

                <div id="promos">
                    @include('components.franchisor.promos')
                </div>
                <hr>
                <div style="padding:10px; padding-bottom:20px;">
                    <div style="float:left; color:#C19B41; font-size:15pt;">
                        Number of users signed up = <span id="lblTotalSignedUp">{{$totalSignedUp}}</span>
                    </div>
                    <div style="float:right; color:#C19B41; font-size:15pt;">
                        Number of active accounts = <span id="lblTotalActiveAccounts">{{$totalActivated}}</span>
                    </div>
                </div>
                <div class="clear"></div>
                <hr>
            </div>

            <div class="fields" style="display:none;">
                <p class="titleText" style="padding-bottom: 5px;">
                    <span id="AddOrEdit">Add New</span> Promo Code</p>
                <p class="subTitleText" style="padding-bottom: 10px;">
                    In order to track signed up users under your generated promocodes, promo code needs to start with your franchise code<br>
                    e.g. if your franchise code is 100, then promo code is <strong>100</strong>01<br>
                    Only promocodes that start with your franchise code will be displayed in the list below.
                </p>

                <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
                    <tbody><tr>
                        <td style="width: 100px;">
                            Promo Code:
                        </td>
                        <td>
                            <input name="txtCode" type="text" id="txtCode">&nbsp;<span id="rqrdCode" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Assign To:
                        </td>
                        <td>
                            <input name="txtAssignedTo" type="text" id="txtAssignedTo">&nbsp;<span id="rqrdAssignedTo" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>                                    
                        </td>
                        <td>
                            <input id="cbxRequireActivationEmail" type="checkbox" name="cbxRequireActivationEmail">&nbsp;Require Activation Email
                        </td>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td style="padding-top:10px;">
                            <a id="btnCancel" class="btn btn-danger" style="font-weight: bold; cursor: pointer;" onclick="hideFields();">Cancel</a>
                            &nbsp;&nbsp;
                            <a id="btnAddPromo" onclick="submitCreate();"  id="btnAddPromo" class="btn btn-warning" style="font-weight:bold;">Save Promo Code</a>
                        </td>
                    </tr>
                </tbody></table>
            </div>

        </div>
    </div>
</div>

@endsection
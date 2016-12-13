@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

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

<script type="text/javascript" src="/js/admin/promo.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            
            <div class="grid">
                <p class="titleText">
                    Manage Promo Codes</p>
                <div style="text-align: right; padding-bottom: 10px;">
                    <a id="AddNewPromo" class="btn btn-warning" style="font-weight: bold; cursor: pointer;" onclick="showFields();">
                        Add New Promo Code
                    </a>
                    <br><br>
                    <select name="ddlFranchiseCode" onchange="viewByFranchise();" id="ddlFranchiseCode" style="width:300px;">
                        <option value="">View Promo Codes Under All Franchises</option>
                        @foreach($franchisees as $franchisee)
                        <option value="{{$franchisee->code}}"
                        @if ($franchisee->code == $sel)
                        selected="selected"
                        @endif
                        >{{$franchisee->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div id="promos">
                    @include('components.admin.promos')
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
                    Add New Promo Code</p>
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
                            <input type="button" ="btnCancel" class="btn btn-danger" style="font-weight: bold; cursor: pointer;" onclick="hideFields();" value="Cancel" />
                            &nbsp;&nbsp;
                            <input type="button" name="btnAddPromo" value="Save Promo Code" onclick="submitCreate();" id="btnAddPromo" class="btn-warning btn" style="font-weight:bold;" />
                        </td>
                    </tr>
                </tbody></table>
            </div>

        </div>
    </div>
</div>

@endsection
@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

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

<script type="text/javascript" src="/js/admin/report.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div class="titleText" style="padding-top:15px;">
                FRANCHISE REPORT - ADMIN
            </div>

            <hr>
            <div>
                <table class="subTitleText" style="line-height:1;">
                    <tbody>
                        <tr>
                            <td>
                                Start Date:&nbsp;
                            </td>
                            <td>
                                <input name="startDate" type="text" id="txtStartDate" class="datepicker">
                                <span id="startDateRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                End Date:&nbsp;
                            </td>
                            <td>
                                <input name="endDate" type="text" id="txtEndDate" class="datepicker">
                                <span id="endDateRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                        </tr>
                        
                        <tr>
                            <td>
                                Franchise Code:&nbsp;
                            </td>
                            <td>
                                <input name="franchiseCode" type="text" id="txtFranchiseCode">
                            </td>
                            <td></td>
                            <td style="position:relative; top:-7px;" align="right">
                                &nbsp;&nbsp;&nbsp;&nbsp;                    
                                <a id="lbFilter" class="mini-gold" href='javascript:filterF()' style="font-size:10pt;">Filter</a>
                                &nbsp;&nbsp;
                                <a id="lbReset" class="mini-gold" href="javascript:resetF();" style="font-size:10pt;">Reset</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">
                <div id="pnlUpdate">
                @include ('components.admin.report')                    
                </div>
                <hr>
                <hr>                    
            </div>
            
        </div>
    </div>
</div>

@endsection
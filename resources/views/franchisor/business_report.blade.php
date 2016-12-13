@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/js/franchisor/report.js"></script>

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

<script type="text/javascript">
    bId = {{$business->id}};
</script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div class="titleText" style="padding-top:15px;">
                Report - {{$business->name}}
            </div>
            <div class="fRight">
                <a id="linkToBusinessProfile" class="mini-gold" href="/franchise_edit_business/{{$business->id}}">Business Profile</a>
                <a id="linkToBusinessProfile" class="mini-red" href="/franchise_businesses" style="margin-left:10px;">Business List</a>
            </div>
            <div class="clear"></div>
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
                            </td>
                            <td>
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                End Date:&nbsp;
                            </td>
                            <td>
                                <input name="endDate" type="text" id="txtEndDate" class="datepicker">                                        
                            </td>
                            <td style="position:relative; top:-7px;">
                                &nbsp;&nbsp;&nbsp;&nbsp;                    
                                <a id="lbFilter" class="mini-gold" href='javascript:filterB()' style="font-size:10pt;">Filter</a>
                                &nbsp;&nbsp;
                                <a id="lbReset" class="mini-gold" href="javascript:reset();" style="font-size:10pt;">Reset</a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <span id="startDateRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                            <td></td>
                            <td>
                                <span id="endDateRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                            <td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="color: #999999; padding-top:0px; padding-bottom:100px;">
                <div id="pnlUpdate">

                    <div style="padding:10px;">

                        <hr>
                        <div class="subTitleText">
                            <span>
                                # of Page Visits: <span id="lblVisits"></span><br>
                            </span>
                        </div>
                        <hr>
                        <div class="subTitleText">
                            <span>
                                Special Discount for Top Ten Percent Members<br>
                            </span>                                
                            # of Downloads: <span id="lblDownloads"></span>
                        </div>

                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</div>

@endsection
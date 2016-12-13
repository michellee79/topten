@extends('layouts.franchisor_master')

@section('head')

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/js/franchisor/coupon.js" type="text/javascript"></script>

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

    .ActiveStatus:hover{
    	color: #999;
    	text-decoration: none;
    }
    .ActiveStatus{
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
            <div class="grid" style="color: #999999; padding-top:0px; padding-bottom:100px;">

                <div id="pnlUpdate">
                    <div class="titleText">
                        Coupons List
                    </div>
                    <div class="fRight">
    			        <a id="linkToBusinessProfile" class="mini-grey" href="/franchise_edit_business/{{$business->id}}">Business Profile</a>
    			        <a id="linkToBusinessProfile" class="mini-red" href="javascript:showCreate();" style="margin-left:10px;">Add</a>
    			    </div>
    			    <div class="clear"></div>
                    <div style="margin-top:15px;" id="coupons">
                    	@include ('components.franchisor.coupons')
    				</div>
                </div>

            </div>

        	<div class="fields" style="display: none;">
                <div style="float:left;">
                    <p class="titleText" style="padding-bottom: 10px;">
                        <span id="lblAddOrEdit">Add</span>&nbsp;Coupon
                    </p>
                </div>
                <div style="float:right;">
                    <input type="submit" name="btnCancelTop" value=" Cancel " onclick="hideFields();" id="btnCancelTop" class="mini-red" style="font-weight:bold;">
                    &nbsp;&nbsp;
                    <input type="submit" name="btnSaveTop" value="   Save   " onclick="submit()" id="btnSaveTop" class="mini-gold" style="font-weight:bold;">
                </div>
                <div class="clear"></div>

                <div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
                        <tbody>
                        <tr>
                            <td style="width: 150px;">
                                Coupon Title:    
                            </td>
                            <td>
                                <input name="title" type="text" id="txtTitle" style="width:300px;" class="required param">&nbsp;
                                <span id="titleRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Coupon Description:
                            </td>
                            <td>
                                <textarea name="description" rows="5" cols="20" id="txtDescription" style="width:300px;" class="required param"></textarea>&nbsp;
                                <span id="descriptionRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                        </tr>                                    
                        
                        <tr>
                            <td>
                                Discount Percent:
                            </td>
                            <td>
                                <input name="discount" type="text" id="txtPercent" style="width:50px;" class="param">&nbsp;%
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Average Value:
                            </td>
                            <td>
                                <input name="averageValue" type="text" id="txtAverageValue" style="width:50px;" class="required param">&nbsp;USD&nbsp;
                                <span id="averageValueRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Disclaimer:
                            </td>
                            <td>
                                <textarea name="disclaimer" rows="3" cols="20" id="txtDisclaimer" style="width:300px;" class="required param">Not to be combined with any other offer.  One coupon per visit.  No cash redemption value. State and local laws may require sales tax to be charged on the pre-discounted price if the product is subject to sales tax.</textarea>&nbsp;
                                <span id="disclaimerRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div style="float:right;">
                    <input type="submit" name="btnCancel" value=" Cancel " onclick="hideFields();" id="ContentPlaceHolder1_btnCancel" class="mini-red" style="font-weight:bold;">
                    &nbsp;&nbsp;
                    <input type="submit" name="btnSaveBusiness" value="   Save   " onclick="submit();" id="ContentPlaceHolder1_btnSaveBusiness" class="mini-gold" style="font-weight:bold;">
                </div>
                <div class="clear"></div>

            </div>
            
        </div>
    </div>
</div>

@endsection
@extends('layouts.businesses_master')

@section('head')

	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

    <script src="/scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

    <script type="text/javascript">
                
        function showLoading() {
            $('.pgContainer').showLoading();
        }

        function hideLoading() {
            $('.pgContainer').hideLoading();
        }

        function showGrid() {
            $('.pgContainer').hideLoading();
            $('.repeater').slideDown();
            $('.fields').fadeOut();
        }

        function showFields() {
            $('.repeater').slideUp();
            $('.fields').fadeIn();
        }

        function showGridMobile() {
            $('.repeaterMobile').slideDown();
            $('.fieldsMobile').fadeOut();
        }

        function showFieldsMobile() {
            $('.repeaterMobile').slideUp();
            $('.fieldsMobile').fadeIn();
        }

        businessId = {{$business->id}};

        @if ($renew)
        $(document).ready(function(){
            showFields();
            showFieldsMobile();
        })
        @endif
    
    </script>

    <style type="text/css">
        .filter{
            padding-right: 10px;
        }
        .fields
        {
            display: none;
        }
        .fieldsMobile
        {
            display: none;
        }
        .noMargin
        {
            margin: 0px;
        }
        .noPadding
        {
            padding: 0px;
        }
        .smallPadding
        {
            padding: 2px;
        }
        .watermark
        {
            color: #999 !important;
            font-style:italic;
        }
    </style>

    <script src="/js/rating.js" type="text/javascript"></script>

@endsection

@section('content')

@include('common.sidetab')
<div class="content">
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="color:#999999;">
                    <tbody>
                        <tr>
                            <td align="left" style="padding-bottom:10px; padding-left:100px;" class="titleText">
                                <a title="Click here to view business profile" class="titleText" href="/business/{{$business->id}}" style="font-weight:normal;">
                                    {{ $business->name }}
                                </a>
                            </td>
                            <td align="right" style="padding-bottom:10px; padding-right:30px;">
                                <a title="Click here to view other businesses in your area" class="mini-grey" href="/businesses#business_box_{{$business->id}}">Other Businesses</a>
                                &nbsp;&nbsp;
                                @if (!Auth::guest())
                                <a onclick="showFields();" title="Click here to add a review for this business" class="mini-gold" style="cursor:pointer;">Add a Review</a>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                    </table>

                    <div class="repeater">
                        @include ('components.ratings')
                    </div>

                    <div class="fields">
                        <form onsubmit="return false;">
                            <div class="couponContainer" style="width:100%; padding-top:30px;" align="center">
                                <div style="width: 792px; min-height: 200px; border: dotted 3px;">
                                    <div class="titleText" style="text-align:left;">Add a Review</div>
                                    <table width="100%" cellpadding="10" cellspacing="0" style="color: #999999;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 50px;">Comment:</td>
                                            <td align="left">
                                                <textarea name="txtComment" rows="5" cols="20" id="txtComment" style="width:600px;"></textarea>&nbsp;
                                                <span style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Ratings:</td>
                                            <td align="left">
                                                <div style="float:left;">                            
                                                    <table style="width:200px;">
                                                    <tbody>
                                                        <tr>

                                                            @if (!$renew)
                                                            <td>
                                                                <input id="rblRatings_1" type="radio" name="rblRatings" value="1">
                                                                <label for="rblRatings_1">1</label>
                                                            </td>
                                                            <td>
                                                                <input id="rblRatings_2" type="radio" name="rblRatings" value="2">
                                                                <label for="rblRatings_2">2</label>
                                                            </td>
                                                            @endif

                                                            <td>
                                                                <input id="rblRatings_3" type="radio" name="rblRatings" value="3">
                                                                <label for="rblRatings_3">3</label>
                                                            </td>
                                                            <td>
                                                                <input id="rblRatings_4" type="radio" name="rblRatings" value="4">
                                                                <label for="rblRatings_4">4</label>
                                                            </td>
                                                            <td>
                                                                <input id="rblRatings_5" type="radio" name="rblRatings" value="5">
                                                                <label for="rblRatings_5">5</label>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    </table>
                                                </div>
                                                <div style="float:left;">
                                                    <span style="font-style:italic; font-size:8pt;">
                                                        (1 being the lowest and 5 being the highest)
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="center" colspan="2">
                                                <input type="button" value=" Cancel " onclick="showGrid();" id="btnCancel" class="mini-red" style="font-weight:bold;">
                                                &nbsp;&nbsp;
                                                <input type="submit" value=" Submit Review " onclick="showLoading(); submitRating();" id="ContentPlaceHolder1_btnSaveBusiness" class="mini-gold" style="font-weight:bold;">
                                            </td>
                                        </tr>
                                    </tbody>
                                    </table>     
                                </div>
                           </div>
                       </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-only">
<div>
    <ul>
        <li class="submenu">
            <div class="menuText">
                <a title="View Business Profile" href="/business/{{$business->id}}" style="color:#A6832F;font-size:10pt;font-weight:normal;">
                    &nbsp;&nbsp;Business Profile
                </a>
            </div>
        </li>
    </ul>
    @if (!Auth::guest())
    <ul>
        <li class="submenu">
            <div class="menuText">
                &nbsp;&nbsp;
                <a style="cursor:pointer; font-size:10pt; color:#A6832F; font-weight:normal;" onclick="showFieldsMobile();">Add a Review</a>
            </div>
        </li>
    </ul>
    @endif
    <div class="mobileContentPane" style="padding-bottom:0px;">
        <div class="mobileContent">
            <div class="repeaterMobile">
                @include('components.ratings_mobile')
            </div>
            <div class="fieldsMobile">
                <div>
                    <div style="padding-top:10px; padding-bottom:10px;">
                        Comment:<span style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <textarea name="txtCommentMobile" rows="5" cols="20" id="txtCommentMobile" style="width:95%;"></textarea>
                    </div>
                    <div style="padding-bottom:10px;">
                        Ratings:&nbsp;<span id="ContentPlaceHolder1_RequiredFieldValidator2" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span><br>
                        <span style="font-style:italic; font-size:8pt;">(1 being the lowest and 5 being the highest)</span><br>
                        
                        <select name="ddlRatingsMobile" id="ddlRatingsMobile" style="width:97%;">
                            <option value="">Select Rating</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div style="padding-bottom:10px;">
                        <input type="button" name="btnCancelMobile" value="Cancel" id="btnCancelMobile" onclick="showGridMobile();"  class="mini-red" style="font-size:11pt;font-weight:bold;">
                            &nbsp;&nbsp;
                        <input type="button" name="btnSaveBusinessMobile" value="Submit Review" onclick="submitRatingMobile();" id="btnSaveBusinessMobile" class="mini-gold" style="font-size:12pt;font-weight:bold;">
                            &nbsp;
                            <div class="submitReviewLoading" style="display:none; padding-bottom:8px; color:#A6832F;">
                                Submitting...&nbsp;<img src="../Images/ttpLoading.gif">
                            </div>
                    </div>
                    <div style="padding-bottom:10px;">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('common.footer_mobile_widget')    
</div>

@endsection
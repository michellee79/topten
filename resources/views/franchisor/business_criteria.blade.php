@extends('layouts.franchisor_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />

<script type="text/javascript" src="/scripts/jquery-ui.js"></script>

<script src="/scripts/jquery.touchPunch.js" type="text/javascript"></script>

<script src="/scripts/jquery.tools.min.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<link href="/scripts/slides/css/global.css" rel="stylesheet" />
<link href="/css/criteria.css" rel="stylesheet" />

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

</style>

<script type="text/javascript" src="/js/franchisor/business_criteria.js"></script>
<script type="text/javascript">
    bId = {{$id}};
</script>

@endsection

@section('content')

<div class="Hide tHide">
</div>

<div class="tHide Message">
    <div>
        <div>
            <span class="titleText" id="ttTitle"></span>
        </div>
        <div>
            <span class="subTitleSolidText" id="ttContent"></span>
        </div>
        <div>
            <input type="button" id="close" class="mini-gold" value="Close" />
        </div>
    </div>
</div>

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <h1 style="color: #C19B41;">Top Ten Percent Business Selection Criteria</h1>
            <div class="BizForm">
                <hr>
                <table>
                <tbody>
                    <tr>
                        <td>
                            <span class="subTitleText">Business Name</span><span class="required">*</span>
                        </td>
                        <td>
                            &nbsp;<input name="businessName" type="text" id="tbBusinessName" value="{{$businessName}}" class="param"
                            @if ($id > 0)
                            readonly
                            @endif
                            >
                            <span id="businessNameRequired" class="required" style="visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="subTitleText">Consumer Who Made The Nomination</span><span class="required">*</span>
                        </td>
                        <td>
                            &nbsp;<input name="consumerName" type="text" id="tbConsumerName" value="{{$consumerNominated}}" class="param"
                            @if ($id > 0)
                            readonly
                            @endif
                            >
                            <span id="consumerNameRequired" class="required" style="visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="subTitleText">Contact Name at Business</span><span class="required">*</span>
                        </td>
                        <td>
                            &nbsp;<input name="businessContactName" type="text" id="tbBusinessContactName" value="{{$businessContact}}" class="param"
                            @if ($id > 0)
                            readonly
                            @endif
                            placeholder = "First Name"
                            >&nbsp;
                            <input name="businessContactName2" type="text" id="tbBusinessContactName2" value="{{$businessContact2}}"
                            @if ($id > 0)
                            readonly
                            @endif
                            placeholder="Last Name"
                            >
                            <span id="businessContactNameRequired" class="required" style="visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="subTitleText">Phone Number</span><span class="required">*</span>
                        </td>
                        <td>
                            &nbsp;<input name="businessPhoneNumber" type="text" id="tbBusinessPhoneNumber" value="{{$businessPhone}}" class="param"
                            @if ($id > 0)
                            readonly
                            @endif
                            >
                            <span id="businessPhoneNumberRequired" class="required" style="visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="subTitleText">Zip Code of Physical Location</span><span class="required">*</span>
                        </td>
                        <td>
                            &nbsp;<input name="zipcode" type="text" id="tbZipcode" value="{{$businessZip}}" class="param"
                            @if ($id > 0)
                            readonly
                            @endif
                            >
                            <span id="zipcodeRequired" class="required" style="visibility:hidden;">Required!</span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <span class="subTitleText">Consumer Nomination</span>
                        </td>
                        <td>
                            
                            <span class="fatty">
                                <input id="cbxNomination" type="checkbox" name="cbxNomination" 
                                @if ($id > 0)
                                checked="checked" disabled="disabled"
                                @endif
                                onclick="refreshProceedButton()">
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span class="subTitleText">Liability Insurance</span>
                        </td>
                        <td>
                            <span class="fatty">
                                <input id="cbxInsurance" type="checkbox" name="cbxInsurance" 
                                @if ($id > 0)
                                checked="checked" disabled="disabled"
                                @endif
                                onclick="refreshProceedButton()">
                            </span>
                        </td>
                    </tr>    
                    <tr>
                        <td></td>
                        <td>
                        @if ($id == 0)
                            &nbsp;<input type="submit" name="btnProceed" value="Proceed" id="btnProceed" disabled="disabled" class="mini-gold" style="font-size:12pt;" onclick="proceed();">
                        @endif
                        </td>
                    </tr>
                </tbody>
                </table>
                <hr>

                <div id="pnlFormDetail" 
                @if ($id == 0)
                style="display:none;"
                @endif
                >
                        <table id="FormDetail">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Site Inspection" data-content="The number of points deducted or added for this category is based on the sole judgment of the TTP representative that is doing the assessment.  If it is a non brick and mortar business without a location the business is automatically given 25 points to maintain uniformity with all other non brick and mortars being evaluated for inclusion.">
                                        Site Inspection
                                    </span>
                                </td>
                                <td style="width: 400px;">
                                    <div id="slider_Inspection" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 28.5714%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Inspection" class="subTitleSolidText">{{$s1}}</span>
                                    <input name="inspection" type="hidden" value="{{$s1}}" id="hf_lbl_Inspection" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Interview" data-content="Evaluate the owner/manager attitude, passion and commitment towards his/her business, customers and employees. The number of points deducted or added for this category is based on the sole judgment of the TTP representative that is doing the assessment.  ">
                                        Interview
                                    </span>
                                </td>
                                <td>
                                    <div id="slider_Interview" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                        <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 28.5714%;"></a>
                                    </div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Interview" class="subTitleSolidText">{{$s2}}</span>
                                    <input name="interview" type="hidden" value="{{$s2}}" id="hf_lbl_Interview" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Mission Statement" data-content="Do they have a written Mission Statement?  If yes = 5 points, no 0 points.">Mission Statement</span>
                                </td>
                                <td>
                                    <div id="slider_Mission" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Mission" class="subTitleSolidText">{{$s3}}</span>
                                    <input name="mission" type="hidden" value="{{$s3}}" id="hf_lbl_Mission" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Community Involvement " data-content="No examples of community involvement = 0 Points, One example of community involvement = 5 Points More than one example of community involvement = 10 Points">Community Involvement</span>
                                </td>
                                <td>
                                    <div id="slider_Community" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Community" class="subTitleSolidText">{{$s4}}</span>
                                    <input name="community" type="hidden" value="{{$s4}}" id="hf_lbl_Community" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Achievements" data-content="Has the business received any other awards, nominations or achievements?  If yes = 5 Points, if no = 0 Points">Achievements</span>
                                </td>
                                <td>
                                    <div id="slider_Achievement" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Achievement" class="subTitleSolidText">{{$s5}}</span>
                                    <input name="achievement" type="hidden" value="{{$s5}}" id="hf_lbl_Achievement" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Years in Business" data-content="Less than 1 year = Minus 10 points, 1-5 years = 5 points, More than 5 years = 10 points">
                                        Years in Business
                                    </span>
                                </td>
                                <td>
                                    <div id="slider_Years" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 50%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Years" class="subTitleSolidText">{{$s6}}</span>
                                    <input name="years" type="hidden" value="{{$s6}}" id="hf_lbl_Years" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="BBB Membership" data-content="Does the business have a current BBB Membership? If yes = 5 Points, if no 0 = Points">BBB Membership</span>
                                </td>
                                <td>
                                    <div id="slider_BBB" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_BBB" class="subTitleSolidText">{{$s7}}</span>
                                    <input name="bbb" type="hidden" value="{{$s7}}" id="hf_lbl_BBB" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Online Consumer Reviews" data-content="No Reviews Found = 0 Points More than 20% of reviews found are negative = Minus 10 Points Up to three positive reviews found = 5 Points More than three positive reviews found = 10 Points">Online Consumer Reviews</span>
                                </td>
                                <td>
                                    <div id="slider_Review" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 50%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Review" class="subTitleSolidText">{{$s8}}</span>
                                    <input name="review" type="hidden" value="{{$s8}}" id="hf_lbl_Review" class="param">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span class="subTitleText tt" data-title="Chamber of Commerce" data-content="Do the have an active Chamber of Membership If yes = 5 Points, if no 0 = Points">Chamber of Commerce</span>
                                </td>
                                <td>
                                    <div id="slider_Chamber" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                                    <a class="ui-slider-handle ui-state-default ui-corner-all" href="#" style="left: 0%;"></a></div>
                                </td>
                                <td class="TR">
                                    <span id="lbl_Chamber" class="subTitleSolidText">{{$s9}}</span>
                                    <input name="chamber" type="hidden" value="{{$s9}}" id="hf_lbl_Chamber" class="param">
                                </td>
                            </tr>
                        </tbody>
                        </table>

                        <hr>
                        @if ($id > 0)
                        <div style="text-align: right; padding-right: 140px; padding-bottom: 50px;">
                            <span class="subTitleSolidText" style="font-size:1.5em;">
                                <span id="lblTotalResult">Total {{$val}} points</span>
                            </span>
                        </div>
                        @endif

                        <table>
                            <tbody><tr>
                                <td colspan="3" style="text-align:center;">
                                    <span class="subTitleSolidText" style="font-size:1.5em;">
                                    75 points or more is needed for inclusion into the Top Ten Percent
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:left; padding-top:20px;">
                                    <input type="submit" name="btnSubmit" value="Submit" onclick="submit();" id="btnSubmit" class="mini-gold" style="font-size:1.5em;">
                                        &nbsp;
                                    <a id="linkToReset" class="mini-gold" href="/business-criteria" style="font-size:1.5em;">Reset</a>
                                </td>
                            </tr>
                        </tbody></table>


                    
                    </div>

            </div>

            <div id="scoreModal" style="background-color:#111; width:500px; height:500px; display:none;">
                <table width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td class="modalContent">
                            <div id="pnlResult">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="padding-top:20px; padding-left:20px;">
                                            <div class="titleText">
                                                <span id="lblTitle"></span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:0px; padding-left:20px;">
                                            <br>
                                            <span id="lblDescription"></span>
                            
                                            <hr>
                                            Total score = <span id="lblScore"></span>
                                            <hr>
                            
                                            <span class="subTitleSolidText" style="font-size:0.8em;">75 points or more is needed for inclusion into the Top Ten Percent </span>
                                            <br><br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding-top:10px; padding-left:20px;">
                                            <a onclick="closeScoreModal();" id="lbClose" class="mini-red" href="javascript:" style="font-size:15px;font-weight:bold;">Close</a>
                                            <a onclick="create();" id="lbAdd" class="mini-gold" href="javascript:" style="font-size:15px;font-weight:bold; display:none;">Add Business</a>
                                        </td>
                                    </tr>
                                </tbody>
                                </table>

                            </div>
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
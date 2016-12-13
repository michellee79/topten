@extends('layouts.main_master')

@section('head')
<!-- Show Loading -->
{!! Html::style('scripts/showLoading/css/showLoading.css') !!}
{!! Html::script('scripts/showLoading/js/jquery.showLoading.js') !!}

<!-- Auto Complete -->
{!! Html::script('scripts/typeAhead/jquery.autocomplete.js') !!}
{!! Html::style('scripts/typeAhead/jquery.autocomplete.css') !!}
{!! Html::style('scripts/showLoading/css/showLoading.css') !!}

{!! Html::script('scripts/jquery.tools.min.js') !!}

{!! Html::style('styles/SideTabs.css?v=1.4') !!}

<!-- Watermark -->
{!! Html::script('scripts/jquery.watermark.js') !!}

{!! Html::script('js/home.js') !!}
{!! Html::style('css/home.css') !!}

@endsection

@section('content')
<span style="display:none;">
    <span id="lblTotalSavings">{{$totalSavings}}</span>
    <span id="lblTotalActivatedAccount">{{$totalUsers}}</span>
</span>
<div class="content">
	
    @include('common.sidetab')

    <div class="mainContentContainer">
        <div class="mainContainer">
            <div class="widgetContainer">
                <a href="/businesses" style="text-decoration:none;">
                <div class="widgetHeader">
                    <p class="headerOneLine">
                        CONSUMERS</p>
                </div>
                </a>

                <div class="widgetText">
                    <p class="widText">
                        Buy From The Best For Less
                    </p>
                </div>
                <div class="btnGoldBarContainer">
                    <a class="gold" href="/businesses"></a>
                </div>
            </div>
            <div class="vertStitchDivider">
            </div>
            <div class="widgetContainer">
                <a href="/page/what-is-top-ten-percent" style="text-decoration:none;">
                <div class="widgetHeader">
                    <p class="headerOneLine">
                        WHAT IS TTP?</p>
                </div>
                </a>

                <div class="widgetText">
                    <p class="widText">
                        What is Top Ten Percent?
                    </p>
                </div>
                <div class="btnGoldBarContainer">
                    
                    <a class="gold" href="/page/what-is-top-ten-percent"></a>
                </div>
            </div>
            <div class="vertStitchDivider">
            </div>
            <div class="widgetContainer">
                <a href="/nominate" style="text-decoration:none;">
                <div class="widgetHeader">
                    <p class="headerOneLine">
                        NOMINATE
                    </p>
                </div>
                </a>

                <div class="widgetText">
                    <p class="widText">
                        Nominate Your Favorite Business</p>
                </div>
                <div class="btnGoldBarContainer">
                    <a class="gold" href="/nominate"></a>
                </div>
            </div>
            

            <div class="ipad-only" style="clear: both; text-align: left; padding-left: 25px;">
                <div style="text-align:center;">
                    <a class="mini-gold" href="Page/Consumer%20Sign%20Up%20Options">
                    Sign Up
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="mini-gold" href="Page/FAQ">
                        FAQ
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="mini-gold" href="Page/About%20Us">
                        About Us
                    </a>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <a class="mini-gold" href="http://www.toptenpercentfranchise.com" target="_blank">
                        Franchise
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Dialog Initial -->
<div id="DefineUserLocationModal" style="background-color:#111; width:320px;">
    <div id="pnlDefineUserLocation">
        <table width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td class="modalContent">
                    <form onsubmit="login(); return false;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                    <tbody>
                    	<tr>
                            <td style="padding-left:20px;">
                                <div class="titleText" style="padding-top:10px;">
                                    Member
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-left:20px;">
                                <table cellpadding="1" cellspacing="0" style="border-collapse:collapse;">
                                <tbody>
                                    <tr>
                                        <td>
                                            <table cellpadding="0"><tbody>
                                            	<tr>
                                                    <td>
                                                        <input name="name" type="text" id="UserName" placeholder="Username" style="width:200px;">
                                                        <span id="nameRequired" title="User Name is required." style="color:#B03535;font-size:13px;visibility:hidden;">Required!</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span><input name="password" type="password" id="Password" placeholder="Password" style="width:200px;"></span>
                                                        <span id="passwordRequired" title="Password is required." style="color:#B03535;font-size:13px;visibility:hidden;">Required!</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td align="center" style="color:#B03535; font-size:10px;" class="loginErrorText">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="line-height:1;">
                                                        <table><tbody>
                                                        	<tr>
                                                                <td>
                                                                    <input type="submit" name="LoginButton" value="Log In" id="LoginButton" class="mini-gold" style="font-size:15px;">
                                                                </td>
                                                                <td style="padding-bottom:9px; padding-left:10px;">
                                                                    <a id="lbSignUp" class="mini-gold" href="/page/Consumer Sign Up Options" style="font-size:15px;">Free Enrollment</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <a id="lbForgotPassword" href="/forgot-password" style="color:White;font-size:8pt;">Forgot Password</a>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                        <tr>
                            <td style="border-bottom:dashed 2px #333; padding-top:15px;">
                            </td>
                        </tr>
                    </tbody></table>
                    </form>

                    <form onsubmit="nonMemberLogin(); return false;">
                    <table width="100%" cellpadding="0" cellspacing="0"><tbody>
                    	<tr>
                            <td style="padding-top:20px; padding-left:20px;">
                                <div class="titleText">
                                    Non-Member
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:0px; padding-left:20px;">
                                <input name="txtLocation" type="text" id="txtLocation" class="txtLocation ac_input" placeholder="ENTER Zipcode OR City, State" style="font-size:15px;width:250px;" autocomplete="off">
                                <span id="rqrdLocation" style="color:#B03535;font-size:13px;visibility:hidden;">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-top:10px; padding-left:20px;">
                                <a id="lbSetLocationNonMember" title="Click here if you are a not currently an active member of Top Ten Percent®" class="mini-gold" href='javascript:nonMemberLogin();' style="font-size:15px;font-weight:bold;">Proceed</a>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 8pt; padding-left: 20px; padding-top: 5px;">
                                No access to exclusive member pricing or enroll for free above
                            </td>
                        </tr>
                    </tbody></table>
                    </form>
                </td>
            </tr>
        </tbody></table>
	</div>
</div>

<!-- Mobile -->
<div class="mobile-only">
    <ul>
        <li class="submenu">
            <div class="menuText">
                <a id="hlToConsumerMobile" href="/businesses" style="color:#A6832F;">CONSUMER</a>
            </div>
        </li>
        
        <li class="submenu">
            <div class="menuText">
                <a id="linkToNominateBusinessMobile" href="/nominate" style="color:#A6832F;">NOMINATE BUSINESS</a>
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                <a id="linkToFranchiseMobile" href="http://www.toptenpercentfranchise.com" target="_blank" style="color:#A6832F;">FRANCHISE OPPORTUNITIES</a>
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                <a id="linkToAboutMobile" href="/page/About%20Us" style="color:#A6832F;">ABOUT US</a>
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                <a id="linkToSignUpMobile" href="/page/Consumer%20Sign%20Up%20Options" style="color:#A6832F;">SIGN UP</a>
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                 <a id="linkToFAQMobile" href="/page/FAQ" style="color:#A6832F;">FAQ</a>
            </div>
        </li>
    </ul>
</div>

@endsection
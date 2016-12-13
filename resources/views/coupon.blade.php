@extends('layouts.businesses_master')

@section('head')

	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>


    <script src="/scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

    <script type="text/javascript">

        function showLoading() {
            $('.couponContainer').showLoading();
        }

        function hideLoading() {
            $('.couponContainer').hideLoading();
        }

        $(document).ready(function () {
            $('.moreInfo').click(function () {
                $(this).parent().find('.infoContent').toggle('medium');
                $('.moreInfoText').toggle();
                $('.hideInfoText').toggle();
            });
            @if ($user != NULL && count($user->coupons) == 0)
            showHint();
            @endif
        });

        var couponId = {{ $coupon->id }};
    
    </script>

    <script src="/js/account.js" type="text/javascript"></script>

@endsection

@section('content')

@include('common.sidetab')
<div class="content">
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <table width="100%" cellpadding="0" cellspacing="0" style="color:#999999;">
                <tbody>
                    <tr>
                        <td align="left" style="padding-bottom:10px; padding-left:100px;" class="titleText">                                    
                            <a title="Click here to view business profile" class="titleText" href="/business/{{$business->id}}" style="font-weight:normal;">{{$business->name}}</a>
                        </td>
                        <td align="right" style="padding-bottom:10px; padding-right:30px;">
                            <a class="mini-grey" href="/businesses#business_box_{{$business->id}}">Other Businesses</a>
                        </td>
                    </tr>
                </tbody>
                </table>
                <div class="couponContainer" style="width:100%; padding-top:30px;" align="center">
                    <div>                        
                        <img src="/Images/couponTop.png" style="width:800px;">
                    </div>
                    <div>
                        <div>
                            <div style="width: 792px; min-height: 210px; border-left: dashed; border-right: dashed;">                         
                                
                                @if ($user == NULL)
                                <div id="pnlVisitor">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                                <td align="center" style="width:200px; padding:10px; padding-top:15px; vertical-align:top;">                                            
                                                    <img id="imgBusinessLogo" src="/Images/BusinessProfile/DefaultBusinessImage.png">
                                                    <div style="padding-top:25px;">
                                                        <a id="lbBusinessProfile" class="mini-gold" href="/business/{{$business->id}}">View Business Profile</a>
                                                    </div>
                                                    <br>
                                                </td>
                                                <td align="left" style="vertical-align:top; padding:0px; padding-left:10px;">
                                                <div class="titleText" style="text-align:left; font-size:28pt; padding-top:80px; padding-left:20px;">     
                                                    Member Only!<br>
                                                    Please Login To View Coupon
                                                </div>
                                                </td>
                                            </tr>
                                    </tbody>
                                    </table>
                                </div>
                                @else
                                <div id="pnlLoggedIn">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tbody>
                                        <tr>
                                            <td align="center" style="width:200px; padding:10px; padding-top:15px; vertical-align:top;">                                                                                        
                                                <img id="imgBusinessLogo" src="{{ $business->logo->url }}">                                            
                                                
                                                <div style="padding-top:25px;">
                                                    <a id="lbAddToMyCoupons" class="mini-green nowrap" href="javascript:addToMyCoupon(false);">Add to My Coupons</a>
                                                </div>
                                                <br>
                                            </td>
                                            <td align="left" style="padding:0px; padding-left:10px; vertical-align:top;">
                                                <div style="padding-bottom:20px;">
                                                    <span id="lblCouponTitle" class="titleText" style="font-size:15pt;font-weight:bold;">{{$coupon->title}}</span><br>
                                                    <span id="lblCouponDescription" class="subTitleTextMultiLines" style="font-size:11pt;"><?php echo $coupon->description; ?></span>
                                                </div>                                            
                                                <div class="subTitleText" style="padding-bottom:10px; font-size:13pt;">
                                                    Value: <span id="lblCouponValue" class="subTitleText" style="font-size:17pt;">${{$coupon->averageValue}}</span>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    Exp: <span id="lblExp" class="subTitleText" style="font-size:17pt;">{{date('m')}}/{{date('t')}}</span>
                                                </div>
                                                <div class="subTitleText" style="padding-bottom:10px; padding-right:60px;">
                                                    <span id="lblDisclaimer" class="subTitleText" style="font-size:8pt;font-weight:normal;">{{$coupon->disclaimer}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div>
                        <img id="imgCouponBottom" src="/Images/couponBottom.png" style="width:800px;">
                        <div style="position:relative; top:-128px; left:379px;">
                            <img id="imgCouponCutOut" src="/Images/couponCutOut.png">
                        </div>
                        <div style="position:relative; top:-360px; left:120px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="hint" style="width:500px; background-color:rgba(255,255,255,0.8); height:260px; clear:both; border-radius:8px;display:none;position: absolute;left: 40%;top: 200px;">
        <div style="text-align:right; position:relative; padding-right:20px; padding-top:10px; font-size:28px;">
            <a href="javascript:closeHint()">X</a>
        </div>
        <div style="position:relative; padding:5px 30px; font-size: 16px; line-height:24px;">
            To save coupons in your digital wallet, for quick access to all your favorites, click on the Add to My Coupons button located below left that looks like this:
        </div>
        <div style="float: right; position:relative;margin-right: 20px;display: inline-block;height: 25px;width: 125px;background: black;">
            <a id="lbAddToMyCoupons" class="mini-green nowrap" href="javascript:addToMyCoupon(false);" style="position: relative; top: 7px;left: -2px;">Add to My Coupons</a>
        </div>
        <div style="clear:both;"></div>
        <div style="position:relative;padding: 5px 30px; font-size: 16px; line-height:24px;">
            Then access your digital wallet by clicking on the My Account icon located above right that looks like this:
            <div style="position:relative; display:inline;">
                <img id="imgMyAccount" title="My Account &amp; Wallet" src="/Images/my-account.png">
                <div style="position:relative; display:inline;top: 7px;left: -5px;">
                    <b class="caret"></b>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="mobile-only">
    <div class="mobileContentPane" style="padding-bottom:0px;">
        <div class="mobileContent">
            @if ($user == NULL)
            <div id="pnlVisitorMobile">
                <div style="padding-bottom:15px; font-size:18pt; color:#A6832F;">
                    MEMBER ONLY!                        
                </div>
                <div style="padding-bottom:15px; font-size:18pt; color:#A6832F; line-height:1.5;">
                    PLEASE LOGIN TO VIEW COUPON.
                </div>
            </div>
            @else
            <div id="pnlLoggedInMobile">
                <div>
                    <a href="/business/{{$business->id}}" title="View Business Profile">
                        <img src="{{$business->logo->url}}">
                    </a>
                </div>
                <div style="padding-bottom:15px;">
                    <span id="lblCouponTitleMobile" class="titleText" style="font-size:17pt;font-weight:bold;">{{$coupon->title}}</span>
                </div>
                <div style="padding-bottom:15px;">
                    <span id="lblCouponDescriptionMobile" class="subTitleTextMultiLines" style="font-size:12pt;">{{$coupon->description}}</span>
                </div>
                <div style="padding-bottom:15px; font-size:17pt; color:#A6832F;">
                    Value:&nbsp;<span id="lblCouponValueMobile" class="subTitleText" style="font-size:17pt;">${{$coupon->averageValue}}</span>
                </div>
                <div style="padding-bottom:15px; font-size:17pt; color:#A6832F;">
                    Exp:&nbsp;<span id="lblExpMobile" class="subTitleText" style="font-size:17pt;">{{date('m')}}/{{date('t')}}</span>
                </div>
                <div style="padding-bottom:15px;">
                    <span id="lblDisclaimerMobile" class="subTitleText" style="font-size:8pt;font-weight:normal;">{{$coupon->disclaimer}}</span>
                </div>
                <div style="text-align:right;">
                    <input type="image" name="ibAddToMyCouponsMobile" onclick="addToMyCoupon('mobile');" id="ibAddToMyCouponsMobile" title="Add to My Coupons" src="/Images/addGreen.png">
                </div>
            </div>
            @endif
            <div class="clear">
                <br>
            </div>    
        </div>

        @include('common.footer_mobile_widget')
    </div>
    <div id="hintMobile" style="width: 90%;height: 340px; clear: both; border-radius: 8px; position: absolute;left: 5%; top: 200px; background-color: rgba(255, 255, 255, 0.8); display:none;">
        <div style="text-align:right; position:relative; padding-right:20px; padding-top:10px; font-size:28px;">
            <a href="javascript:closeHint()">X</a>
        </div>
        <div style="position:relative; padding:5px 30px; font-size: 24px; line-height:24px;">
            To save coupons in your digital wallet, for quick access to all your favorites, click on the Add to My Coupons button located below left that looks like this:
        </div>
        <div style="float: right; position:relative;margin-right: 20px;display: inline-block;height: 25px;width: 125px;background: black;">
            <a id="lbAddToMyCoupons" class="mini-green nowrap" href="javascript:addToMyCoupon(false);" style="position: relative; top: 7px;left: -2px;">Add to My Coupons</a>
        </div>
        <div style="clear:both;"></div>
        <div style="position:relative;padding: 5px 30px; font-size: 24px; line-height:24px;">
            Then access your digital wallet by clicking on the My Account icon located above right that looks like this:
            <div style="position:relative; display:inline;">
                <img id="imgMyAccount" title="My Account &amp; Wallet" src="/Images/my-account.png">
                <div style="position:relative; display:inline;top: 7px;left: -5px;">
                    <b class="caret"></b>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
<div id="bottom" style="position: fixed; width: 100%; max-width: 100%; bottom: 0px; text-align: center; background-color: #111; border-top: solid 5px #292929; z-index:6000;">
    <div style="float: left; width: 24%; text-align: center; padding-top: 5px;">
        <a id="linkToMyAccountMobileBottom" href="/myaccount" style="display:inline-block;color:#A6832F;font-size:10pt;width:100%;">
            <img src="/Images/user.png" height="20px"><br>Profile
        </a>
    </div>
    <div style="float: left; border-left: solid 2px #292929; height: 50px; width: 2px;">
    </div>
    <div style="float: left; width: 24%; text-align: center; padding-top: 5px;">
        <a id="linkToMyCouponsMobileBottom" href="/mycoupons" style="display:inline-block;color:#A6832F;font-size:10pt;width:100%;">
            <img src="/Images/coupon_tag.png" height="20px"><br>Coupons
        </a>
    </div>
    <div style="float: left; border-left: solid 2px #292929; height: 50px; width: 2px;">
    </div>
    <div style="float: left; width: 24%; text-align: center; padding-top: 5px;">
        <a id="linkToChangePassword" href="/changepassword" style="display:inline-block;color:#A6832F;font-size:10pt;width:100%;">
            <img src="/Images/lock.png" height="20px"><br>Password
        </a>
    </div>
    <div style="float: left; border-left: solid 2px #292929; height: 50px; width: 2px;">
    </div>
    @if (Auth::guest())
    <div style="float: left; width: 24%; text-align: center; padding-top: 5px;">                
        <a id="linkToLogin" href="/login?redirect=/businesses" style="display:inline-block;color:#A6832F;width:100%;">
            <img src="/Images/logout.png" height="20px"><br><span id="lblLoginTextMobile" style="color:#A6832F;">Login</span>
        </a>
    </div>
    @else
    <div style="float: left; width: 24%; text-align: center; padding-top: 5px;">
        <a id="loginViewMobileBottom_loginStatus" href="javascript:logout();" style="display:inline-block;color:#A6832F;width:100%;">
            <img src="/Images/logout.png" height="20px"><br>
            Logout
        </a>
    </div>
    @endif
</div>
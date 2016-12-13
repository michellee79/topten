<div> 
    <div style="text-align:right;">
        <a id="lbChangeLocation" href="/setlocation" style="color:#999999;font-weight:bold;text-decoration:none;">
            <img id="imgLocationPin" src="/Images/locationPin.png" style="width:20px;">&nbsp;
            <span id="lblCurrentLocation" title="Change Current Location">
                @if ($location == NULL)
                    Set location
                @else
                    {{$location}}
                @endif
            </span>
        </a>
    </div>
    <div style="padding-top:0px;">
        <table id="loginview1_Login1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;">
            <tbody><tr>
                <td>
                    <form onsubmit="login(); return false;">
                    <div style="width:600px; text-align:right; padding-top:10px; height:0px;">
                        <input name="name" type="text" id="UserName" placeholder="UserName" style="width:100px;">
                        <span id="nameRequired" title="User Name is required." style="color:#B03535;font-weight:bold;visibility:hidden;">*</span>
                        <span>
                        <input name="password" type="password" id="Password" placeholder="Password" style="width:100px;">
                        </span>
                        <span id="passwordRequired" title="Password is required." style="color:#B03535;font-weight:bold;visibility:hidden;">*</span>
                        <input type="submit" name="LoginButton" value="Log In" onclick="" id="loginview1_Login1_LoginButton" class="mini-gold">
                                                    
                        &nbsp;&nbsp;
                        
                        <span style="position:relative; top: -4px;">
                            <a id="linkToForgotPassword" class="mini-gold" href="/forgot-password">Forgot Password</a>
                        </span>      
                        
                        &nbsp;&nbsp;

                        <span style="position:relative; top: -4px;">
                            <a id="linkToSignUp" class="mini-gold" href="/page/Consumer%20Sign%20Up%20Options">Free Enrollment</a>
                        </span>

                        <div style="position:relative; top:-10px; z-index:100;">
                            <span style="font-size:8pt; color:#B03535;" class="loginErrorText"></span>
                        </div>
                    </div>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
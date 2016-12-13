<div> 
    <div style="text-align:right;">
        <a id="lbChangeLocation" href='/setlocation' style="color:#999999;font-weight:bold;text-decoration:none;">
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
        
        <div style="text-align:right;">
            <div style="float:left; padding-left:40px;">
                <div class="navbar navContainer" style="margin-bottom:0px;">
                    <ul class="nav">
                        <li class="dropdown" id="item1" style="padding-left:10px;">                                                
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#item1" style="color:#A6832F; font-weight:bold;">
                                <img id="imgMyAccount" title="My Account & Wallet" src="/Images/my-account.png"><b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu" style=" 
                                background: #fefcea; /* Old browsers */
                                background: -moz-linear-gradient(top,  #fefcea 0%, #f1da36 25%); /* FF3.6+ */
                                background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fefcea), color-stop(25%,#f1da36)); /* Chrome,Safari4+ */
                                background: -webkit-linear-gradient(top,  #fefcea 0%,#f1da36 25%); /* Chrome10+,Safari5.1+ */
                                background: -o-linear-gradient(top,  #fefcea 0%,#f1da36 25%); /* Opera 11.10+ */
                                background: -ms-linear-gradient(top,  #fefcea 0%,#f1da36 25%); /* IE10+ */
                                background: linear-gradient(to bottom,  #fefcea 0%,#f1da36 25%); /* W3C */
                                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fefcea', endColorstr='#f1da36',GradientType=0 ); /* IE6-9 */                                                
                                ">
                                <li>
                                    <div style="padding-top:5px; padding-bottom:5px; border-bottom:dotted 2px silver;">
                                        <a id="linkToMyAccount" href="/myaccount" style="font-weight:bold;">My Account & Wallet</a>
                                    </div>
                                </li>
                                <li>
                                    <div style="padding-top:5px; padding-bottom:5px; border-bottom:dotted 2px silver;">
                                        <a id="linkToChangePassword" href="/changepassword" style="font-weight:bold;">Change Password</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown" style="padding-top:8px;">&nbsp;&nbsp;</li>
                        <li class="dropdown" id="item2"></li>
                    </ul>
                </div>
            </div>
            <div style="float:right; padding-top:20px;">
                <a id="loginview1_loginStatus1" class="mini-gold" href="javascript:logout()" style="font-weight:bold;">Logout</a>
            </div>
            <div class="clear">
            </div>
        </div>

    </div>
</div>
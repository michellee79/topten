<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--New GA-->
    <script>

        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r; i[r] = i[r] || function () {

                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date(); a = s.createElement(o),

            m = s.getElementsByTagName(o)[0]; a.async = 1; a.src = g; m.parentNode.insertBefore(a, m)

        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        // ga('create', 'UA-12342582-8', 'auto');
        ga('create', 'UA-71335337-1', 'auto');

        ga('send', 'pageview');

    </script>

    <link rel="shortcut icon" href="/Images/topten.ico" type="image/x-icon" />
    <script src="/scripts/jquery-1.7.2.min.js" type="text/javascript"></script>
    <script src="/scripts/bootstrap.min.js" type="text/javascript"></script>

    <script src="/scripts/jquery-ui.js" type="text/javascript"></script>
    <link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />


    <link href="/styles/Business.css" rel="stylesheet" type="text/css" />
    <link href="/styles/master.css" rel="stylesheet" type="text/css" />
    <link href="/styles/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/styles/Mobile.css" rel="stylesheet" type="text/css" />

    <script src="/scripts/jquery.watermark.js" type="text/javascript"></script>

    <script src="/js/check_cookie.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>

    <script type="text/javascript">
        /mobi/i.test(navigator.userAgent) && !location.hash && setTimeout(function () {
            if (!pageYOffset) window.scrollTo(0, 1);
        }, 1000);

        $(document).ready(function () {
            if (navigator.platform == 'iPad' || navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
                $(".bottomTab").css("position", "static");
            };

            $('.txtUserName').watermark("Username");
            $('.txtPassword').watermark("Password");

            $(".sideTabHover").hover(function () {
                //Hover Over
                $(this).animate({ marginLeft: 0 }, 200);
            }, function () {
                //Hover Out
                $(this).animate({ marginLeft: -10 }, 200);
            });

            $('.myAccount').click(function () {
                $(this).parent().toggleClass('toggle');
                $(this).find('.arrow').toggleClass('toggle');
                $(this).parent().find('.subSubMenu').toggle('medium');
            });
        });
    </script>

    <style type="text/css">
        .watermark
        {
            color: #999 !important;
            font-style:italic;
        }
        a
        {
            color: #999999;
            font-weight:bold;
        }
        a:hover
        {
            color: #999999;
            font-weight:bold;
            text-decoration:none;
        }
    </style>

    <title>Top Ten Percent</title>

    @yield('head')

</head>

<body id="body">
	<!-- Normal Header -->
    <div class="pgHeaderContentContainer content">
        <div class="pgHeaderContainer">
            <div style="float:left;">
                <a id="LinktoHome" href="/"><div class="pgLogoContainer"><img src="/Images/logo_large.png" height="82px" width="167px"></div></a>
            </div>            
            <div style="float:right; padding-right:25px; padding-top:30px; color:#999;">
                @if ($user == NULL)
                    @include('common.header_login_widget')
                @else
                    @include('common.header_logout_widget')
                @endif
            </div>
            <div class="clear"></div>
        </div>
        <div class="headerStitch"></div>
    </div>

	<!-- Mobile Header -->
	<div class="headerMobile mobile-only" style="padding-top:0px;">
        <div class="headerContainerMobile">                
            <div style="padding-top:10px; padding-bottom:20px; padding-left:20px;">                
                <a id="linkToHomeMobile" href="./"><img id="imgMobileLogo" src="/Images/logo_large.png"></a>
            </div>        
            <div class="headerStitch" style="top:-15px;"></div>
        </div>
    </div>

	<div class="mobile-only">
        <ul>
            <li class="submenu">                
                <div class="menuText">
                    <a id="linkToChangeLocationMobile" href="Set%20Location" style="color:#999999;text-decoration:none;">
                        <img id="imgLocationPinMobile" src="/Images/locationPin.png" style="width:40px;">&nbsp;
                        <span id="lblCurrentLocationMobile" title="Change Current Location" style="color:#A6832F;font-weight:normal;">Set Location</span>
                    </a>
                </div>
            </li>
            <li class="submenu">
                <div class="menuText">
                    <a id="linkToOtherBusinesses" href="/businesses" style="color:#A6832F;font-weight:normal;">
                        <img id="imgOtherBusinesses" src="/Images/shopping.png" style="width:40px;">&nbsp;Other Businesses
                    </a>
                </div>
            </li>
        </ul>
    </div>

	@yield('content')

	<!-- Normal Footer -->
	<div class="footerContentContainer content">
        <div class="footerContainer">
            <div style="float: left;">
                <div class="footerLinks">
				    @include('common.footer')
				</div>
				<div class="copyright">
					<span>&copy; <?php echo date("Y"); ?> Top Ten Percent</span>
				</div>
			</div>

			<div class="socialmedia">
	            <a id="linkToFacebook" title="Like us on Facebook" href="http://www.facebook.com/TopTenPercent" target="_blank" style="text-decoration:none;">
	            	{!! Html::image('/Images/FacebookIcon.png', 'Like Us in Facebook', array('style' => 'width:25px;')) !!}
	            </a>
	            |
	        	<a id="linkToTwitter" title="Follow us on Twitter" href="https://twitter.com/TopTenPercent_" target="_blank" style="text-decoration:none;">
	        		{!! Html::image('/Images/TwitterIcon.png', 'Like Us in Twitter', array('style' => 'width:25px;')) !!}
	        	</a>
	        </div>
		</div>
	</div>

	<div class="footerMobile mobile-only">
        <div class="copyright" style="text-align: center;">
            <span>&copy; <?php echo date("Y"); ?> Top Ten Percent</span>
        </div>
    </div>
</body>
</html>
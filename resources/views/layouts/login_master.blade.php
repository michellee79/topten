<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<!--GOOGLE ANALYTICS-->
    <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', '<?php echo env('GOOGLE_ANALYTICS_ID') ?>']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
    </script>

    {!! Html::script('scripts/jquery-1.7.2.min.js') !!}
    {!! Html::script('scripts/bootstrap.min.js') !!}

    <script src="/scripts/jquery-ui.js" type="text/javascript"></script>
    <link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

    <script src="/js/check_cookie.js" type="text/javascript"></script>
    <script src="/js/common.js" type="text/javascript"></script>

    <link rel="shortcut icon" href="/Images/topten.ico" type="image/x-icon" />

    {!! Html::style('styles/bootstrap.css') !!}
    {!! Html::style('styles/master.css?v=1.4') !!}
    {!! Html::style('styles/Mobile.css') !!}
    {!! Html::style('styles/Page.css') !!}

    <title>Top Ten Percent</title>

    @yield('head')

</head>

<body>
	<!--NORMAL HEADER-->
    <div class="pgHeaderContentContainer content">
        <div class="pgHeaderContainer">
            <div style="float: left;">
                <a id="LinktoHome" href="/">
                    <div class="pgLogoContainer">
                        <img src="/Images/logo_large.png" height="82px" width="167px">
                    </div>
                </a>
            </div>
            <div style="float: right;">
            </div>
            <div class="clear"></div>
        </div>
        <div class="headerStitch"></div>
    </div>

    <!--MOBILE HEADER-->
    <div class="headerMobile mobile-only">
        <div class="headerContainerMobile">
            <div style="padding-top: 10px; padding-bottom: 20px; padding-left: 20px;">
                <a id="linkToHomeMobile" href="/">
                    <img id="imgMobileLogo" src="/Images/logo_large.png">
                </a>
            </div>
            <div class="headerStitch" style="top: -15px;"></div>
        </div>
    </div>

    @yield('content')
    <!--NORMAL FOOTER-->
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

	<div class="footerMobile mobile-only" style="padding-top: 10px; padding-bottom: 10px;">
        <div class="copyright" style="text-align: center;">
            <span>&copy; <?php echo date("Y"); ?> Top Ten Percent</span>
        </div>
    </div>
    
</body>
</html>
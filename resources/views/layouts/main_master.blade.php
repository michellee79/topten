<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />
	<!-- iPhone Util -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="apple-touch-icon" href="/Images/ttp-apple-touch-icon.png" />
    <link rel="apple-touch-startup-image" href="/Images/ttp-apple-startup-image.png" />

	<title>Top Ten Percent</title>

	{!! Html::script('scripts/jquery-1.7.2.min.js') !!}
	{!! Html::script('scripts/jquery.easing.1.3.js') !!}
	{!! Html::script('scripts/jquery.flipCounter.1.2.js') !!}
	{!! Html::script('scripts/bootstrap.min.js') !!}
	{!! Html::script('scripts/AddToHomescreen/addtohomescreen.min.js') !!}

	{!! Html::style('styles/master.css?v=1.4') !!}
	{!! Html::style('styles/bootstrap.css') !!}
	{!! Html::style('styles/Mobile.css') !!}
	{!! Html::style('scripts/AddToHomescreen/addtohomescreen.css') !!}

    <link rel="shortcut icon" href="/Images/topten.ico" type="image/x-icon" />

	@yield('head')

    {!! Html::script('js/check_cookie.js') !!}
    {!! Html::script('js/main.js') !!}
    {!! Html::style('css/main.css') !!}
    <script type="text/javascript">
        @if (Auth::guest() && $location == NULL)
            setCounterValueAndOpenDefineUserLocation('{{$totalSavings}}','{{$totalUsers}}');
        @endif
        tDollarSavings = {{$totalSavings}};
        tUsers = {{$totalUsers}};
    </script>

</head>
<body>
	<!-- <span>
	    <span id="lblCounterValue"></span>
	</span> -->

	<div class="headerContentContainer content">
        <div class="headerContainer">
	        <a id="LinktoHome" title="Top Ten Percent - Buy From The Best For Less" href="/">
	        	<div class="largeLogoContainer">
	            	{!! Html::image('/Images/logo_large.png') !!}
	            </div>
        	</a>

        	<div class="counterContainer">
                <div class="counterPosition">
                    <div class="topDisclaimer">
                        <span id="HyperLink3" style="display:inline-block;color:#C19B41;text-decoration:none;width:390px;">Over</span>
                    </div>
                    <div class="counterBlank"></div>
                    <div class="counterFiller">
                        <div id="counterMember" class="counterMember">
                            <input type="hidden" name="counter-value" value="100" /></div>
                    </div>
                    <div class="disclaimer">
                        <span id="HyperLink1" style="color:#C19B41;text-decoration:none;">&nbsp;</span>
                    </div>
                    <div class="disclaimer2">
						<span id="HyperLink2" style="display:inline-block;color:#C19B41;text-decoration:none;width:390px;">Consumers Have Saved More Than</span>
                    </div>
                </div>
            </div>

            <div class="counterContainerBottom">
                <div class="counterPosition">
                    <div class="counterDollarSign"></div>
                    <div class="counterFiller">
                        <div id="counter" class="counter .numbers-with-commas">
                            <input type="hidden" name="counter-value" value="100" /></div>
                    </div>
                    <div class="disclaimer">
                        <a id="linkToDisclaimer" href="#" style="color:#C19B41;text-decoration:none;"></a>
                    </div>
                </div>
            </div>

        </div>

        <div class="headerStitch"></div>

    </div>

    <div class="headerMobile mobile-only">
        <div class="headerContainerMobile">
            <div style="padding-top: 10px; padding-bottom: 20px; padding-left: 20px;">
                <a id="linkToHomeMobile" href="./">
                	{!! Html::image('/Images/logo_large.png', '', array('id' => 'imgMobileLogo')) !!}
                </a>
            </div>
            <div class="headerStitch" style="top: -15px;"></div>
        </div>
    </div>

    @yield('content')

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
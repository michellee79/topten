@extends('layouts.page_master')

@section('head')
	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>
    
    <script src="/scripts/typeAhead/jquery.autocomplete.js" type="text/javascript"></script>
    <link href="/scripts/typeAhead/jquery.autocomplete.css" rel="stylesheet" type="text/css" />

    <script src="/scripts/jquery.tools.min.js" type="text/javascript"></script>
    <script type="text/javascript">        
        function showLoading() {
            $('.pgContainer').showLoading();
        }

        function hideLoading() {
            $('#DefineUserLocation').hideLoading();
        }

        $(document).ready(function () {            
            $(".txtLocation").autocomplete("/ajax/getlocations", {
                delay: 10,
                minChars: 3,
                matchSubset: 1,
                matchContains: 1
            });

            $(".txtLocationMobile").autocomplete("/ajax/getlocations", {
                delay: 10,
                minChars: 3,
                matchSubset: 1,
                matchContains: 1
            });
        });
    </script>

    <style type="text/css">
        #DefineUserLocation
        {
            width: 420px;
            height: 380px;
            background: #999999 url('/Images/bgDefineUserLocation.jpg') no-repeat 0px 0px;                                    
            display: none;
            z-index: 4000;
        }
        
        .modalHeader
        {
            font-family: OpenSansRegular;   
            font-size: 28px;
            color: white;
            text-align: center;
            position: relative;
            top: 24px;
        }
        
        .modalContent
        {
            padding-top: 70px;
            padding-left: 300px;
            font-family: OpenSansRegular;            
            font-size: 24px;
            line-height: 32px;
            color: #E6E6E6;
        }
    </style>

    <script type="text/javascript" src="/js/location.js"></script>
@endsection

@section('content')

@include('common.sidetab')

<div class="mainContentContainer content">
	<div class="mainContainer">
		<div class="pgMainContainer">
			<div class="pgContainer">
				
				<table width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td>
                            <div class="modalHeader">
                                Please Select Your Location                                   
                            </div>                                                       
                        </td>
                    </tr>
                    <tr>
                        <td class="modalContent">
                            <table width="100%" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td style="padding-top:10px;">
                                    ENTER&nbsp;&nbsp;Zipcode&nbsp;&nbsp;/&nbsp;&nbsp;City, State
                                    <span id="locationRequired" style="color:#B03535;font-size:20px;visibility:hidden;">  Required!</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top:0px;">
                                    <input name="location" type="text" id="location" class="txtLocation ac_input" style="font-size:24px;height:30px;width:296px;" autocomplete="off">
                                </td>
                            </tr>                                                                                                                                                                                                                
                            <tr>
                                <td style="padding-top:30px;">
                                    <a id="lbSetLocation" class="btn-large btn-warning" href="javascript:setLocation('')" style="font-size:20px;font-weight:bold;">Set Location</a>
                                </td>
                            </tr>
                            </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
                </table>

			</div>
		</div>
	</div>
</div>

<div class="mobile-only">
	<ul>
        <li class="submenu">                
            <div class="menuText mobileTitle">
                SET LOCATION
            </div>
        </li>
    </ul>
    <div class="mobileContentPane">
        <div class="mobileContent">
            <div>

                <div style="padding-bottom:5px;">
                    ENTER&nbsp;&nbsp;Zipcode&nbsp;&nbsp;/&nbsp;&nbsp;City, State
                    <span id="locationRequiredMobile" style="color:#B03535;font-size:20px;visibility:hidden;">Required!</span>
                </div>
                <div style="padding-bottom:25px;">
                    <input name="location" type="text" id="locationMobile" class="txtLocation ac_input" style="font-size:24px;height:30px;width:296px;" autocomplete="off">
                </div>
                <div style="padding-bottom:5px;">                   
                    <input type="button" value="Set Location" onclick="setLocation('Mobile');" id="setLocationMobile" class="btn-large btn-warning" style="font-size:20px;font-weight:bold;">
                </div>
            
            </div>
        </div>
    </div>
</div>
@endsection
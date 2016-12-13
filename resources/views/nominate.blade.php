@extends('layouts.page_master')

@section('head')

	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

    <script src="/scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

    <script type="text/javascript">
        function showLoading() {
            $('.pgContainer').showLoading();
        }

        function hideLoading() {
            $('.pgContainer').hideLoading();
        }

        $(document).ready(function () {
            //$('.txtBusinessPhone').watermark('614-123-4567');
        });

    </script>

    <style type="text/css">
        .validation
        {
            color: #B03535;
            font-size: 10px;
        }
        .stepTxtOn
        {
            color: #B28211;
            font-size: 15px;
            position: relative;
            top: 40px;
            left: 10px;
            float: left;
            border-bottom: 2px solid #B28211;
            width: 190px;
        }
        .stackValidation
        {
            color: #B03535;
            font-size: 10px;
            position: relative;
            top: 5px;
            right: 500px;
            float: right;
        }
        
    </style>
    <script type="text/javascript" src="/js/nominate.js"></script>

@endsection

@section('content')

@include('common.sidetab')

<div class="mainContentContainer">
    <div class="pgMainContainer" style="width:90%;">
        <div class="pgContainer" style="width:95%;">
            <div style="width:75%; float:left;">
                <p class="titleText">
                	Nominate A Business
	            </p>
	            
                @if ($name=='')
                <p class="subTitleText">
	                Please nominate up to three businesses you feel deserves inclusion into<br>
	                the Top Ten Percent® by completing the information below:
                </p>
                @else
                <p class="titleText">
                Nominate {{$name}} and if they meet TTP's selection criteria you'll get Special Member Pricing from them!
                </p>
                @endif
			</div>
           	<img src="/Images/toptenawardwin.PNG" alt=" top ten" style="margin-top:-35px">
           	<div style="padding-top: 10px; border-top: solid thin #B28211; border-bottom: solid thin #B28211; padding-bottom: 10px;">
                <table width="100%" cellpadding="0" cellspacing="0" style="line-height: 3; color: #fff;">
                    <tbody>
                    <tr>
                        <td colspan="2" class="subTitleText" style="padding-top: 10px; padding-bottom: 10px;">
                            Business Nomination #<span id="businessNum">{{$nCnt}}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            Business Name:
                        </td>
                        <td>
                            <input name="businessName" type="text" id="businessName" style="width:85%;" value="{{$name}}">
                            <span id="businessNameRequired" class="validation" style="visibility: hidden;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            Business City:
                        </td>
                        <td>
                            <input name="businessCity" type="text" id="businessCity" style="width:85%;">
                            <span id="cityRequired" class="validation" style="visibility: hidden;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 120px;">
                            Business State:
                        </td>
                        <td>
                            <select name="ddlState" id="ddlState" style="width:85%;">
								<option value=""></option><option value="AL">Alabama</option><option value="AK">Alaska</option><option value="AZ">Arizona</option><option value="AR">Arkansas</option><option value="CA">California</option><option value="CO">Colorado</option><option value="CT">Connecticut</option><option value="DC">District of Columbia</option><option value="DE">Delaware</option><option value="FL">Florida</option><option value="GA">Georgia</option><option value="HI">Hawaii</option><option value="ID">Idaho</option><option value="IL">Illinois</option><option value="IN">Indiana</option><option value="IA">Iowa</option><option value="KS">Kansas</option><option value="KY">Kentucky</option><option value="LA">Louisiana</option><option value="ME">Maine</option><option value="MD">Maryland</option><option value="MA">Massachusetts</option><option value="MI">Michigan</option><option value="MN">Minnesota</option><option value="MS">Mississippi</option><option value="MO">Missouri</option><option value="MT">Montana</option><option value="NE">Nebraska</option><option value="NV">Nevada</option><option value="NH">New Hampshire</option><option value="NJ">New Jersey</option><option value="NM">New Mexico</option><option value="NY">New York</option><option value="NC">North Carolina</option><option value="ND">North Dakota</option><option value="OH">Ohio</option><option value="OK">Oklahoma</option><option value="OR">Oregon</option><option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option><option value="SD">South Dakota</option><option value="TN">Tennessee</option><option value="TX">Texas</option><option value="UT">Utah</option><option value="VT">Vermont</option><option value="VA">Virginia</option><option value="WA">Washington</option><option value="WV">West Virginia</option><option value="WI">Wisconsin</option><option value="WY">Wyoming</option>
							</select>
                            <span id="stateRequired" class="validation" style="visibility: hidden;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">
                            Business Phone#:
                        </td>
                        <td>
                            <input name="businessPhone" type="text" id="businessPhone" class="txtBusinessPhone" style="width:85%;">                                        
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Your First Name:
                        </td>
                        <td>
                            <input name="firstName" type="text" id="firstName" 
                            @if ($user != NULL)
                            value="{{$user->firstName}}" 
                            @endif
                            style="width:85%;">
                            <span id="firstNameRequired" class="validation" style="visibility: hidden;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Your Last Name:
                        </td>
                        <td>
                            <input name="lastName" type="text" id="lastName" 
                            @if ($user != NULL)
                            value="{{$user->lastName}}" 
                            @endif
                            style="width:85%;">
                            <span id="lastNameRequired" class="validation" style="visibility: hidden;">*</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Your Email&nbsp;<span id="revEmail" class="validation" style="visibility:hidden;">Invalid</span>
                        </td>
                        <td>
                            <input name="email" type="text" id="txtEmail" 
                            @if ($user != NULL)
                            value="{{$user->email}}" 
                            @endif
                            style="width:85%;">
                            <span id="emailRequired" class="validation" style="visibility: hidden;">*</span>                                        
                        </td>
                    </tr>                                                                
                    <tr>
                        <td colspan="2" style="line-height:1.2; padding-top:10px; padding-bottom:10px;">
                            Why do You Feel This Business Should be Included in the Top Ten Percent®?
                            <span id="reasonRequired" class="validation" style="visibility: hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <textarea name="reason" rows="5" cols="20" id="reason" style="width:87%;"></textarea>
                        </td>
                    </tr>
                    <tr>                                    
                        <td colspan="2" style="padding-right: 10px;">
                            <div class="btnContainer">
                                <input type="button" name="finishNomination" value="Complete Nomination" onclick="nominate(false);" id="finishNomination" class="btn btn-warning" style="font-weight:bold;">
                                &nbsp;&nbsp;<span style="font-weight:bold;">OR</span>&nbsp;&nbsp;
                                <input type="button" name="nominateAnother" value="Nominate Another Business" onclick="nominate(true);" id="nominateAnother" class="btn btn-warning" style="font-weight:bold;">
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="completeEnrollmentModal" class="modal" style="display:none; position:absolute; overflow: visible;">
    You have nominated 2 businesses. Click <a href="/register_from_nominate">Here</a> to Complete Your Free Enrollment
</div>

@endsection
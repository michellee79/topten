@extends('layouts.businesses_master')

@section('head')

	<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

    <link href="/scripts/toastMessage/css/jquery.toastmessage.css" rel="stylesheet" type="text/css" />
    <script src="/scripts/toastMessage/jquery.toastmessage.js" type="text/javascript"></script>

    <script src="/js/account.js" type="text/javascript"></script>

    <script type="text/javascript">

        function showLoading() {
            $('.pgContainer').showLoading();
        }

        function hideLoading() {
            $('.pgContainer').hideLoading();
        }

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this coupon?')) {
                showLoading();
            }
            else {
                event.preventDefault();
                return false;
                event.returnValue = false;
            }
        }
    
    </script>

    <style type="text/css">
        .borderDashedBottom{
            border-bottom:dashed 2px #333333;
        }
        .paddingTop10{
            padding-top: 10px;
        }
        .paddingBottom10{
            padding-bottom: 10px;
        }
        .profile{
            font-size: 10pt;
            color: #ffffff;
            line-height: 2;
        }
        .required{
            font-weight: bold;
            font-size: 8pt;
            color: #B03535;                            
        }
    </style>

@endsection

@section('content')
<div class="content">
@include('common.sidetab')
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <div>
                    <div id="UserProfile" style="padding-left:25px; padding-right:25px;">
                        <div class="titleText borderDashedBottom">
                            My Profile
                        </div>
                        <div class="borderDashedBottom paddingTop10 paddingBottom10">
                            <table width="100%" cellpadding="0" cellspacing="0" class="profile">
                            <tbody>
                                <tr>
                                    <td class="paddingTop10" style="width:100px;">
                                        <label for="txtEmail" id="lblEmail">Email:</label>
                                    </td>
                                    <td class="paddingTop10">
                                        <input name="txtEmail" type="text" value="{{$user->email}}" id="txtEmail" disabled="disabled">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtFirstName" id="lblFirstName">First Name:</label>
                                    </td>
                                    <td>
                                        <input name="txtFirstName" type="text" value="{{$user->firstName}}" id="txtFirstName">
                                        <span id="requiredFirstName" class="required" style="visibility:hidden;">Required!</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtLastName" id="lblLastName">Last Name:</label>
                                    </td>
                                    <td>
                                        <input name="txtLastName" type="text" value="{{$user->lastName}}" id="txtLastName">
                                        <span id="requiredLastName" class="required" style="visibility:hidden;">Required!</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="txtZipcode" id="Zipcode">Zipcode:</label>
                                    </td>
                                    <td style="float:left;">
                                        <input name="txtZipcode" type="text" value="{{$user->zipcode}}" id="txtZipcode">
                                        <span id="requiredZipcode" class="required" style="visibility:hidden;">Required!</span>
                                        <span id="validatorZipcode" class="required" style="visibility:hidden;">Invalid Format!</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>                                        
                                    </td>
                                    <td class="paddingTop10 paddingBottom10">
                                        <a id="lbUpdateUserProfile" class="mini-gold" href='javascript:save("")'> Save </a>
                                    </td>
                                </tr>
                            </tbody>
                            </table>
                        </div>
                    </div>

                    <div id="UserCoupons" style="padding-left:25px; padding-right:25px;">
                        <div class="titleText borderDashedBottom">
                            My Coupons
                        </div>
                        <div id="MyCoupons">
                            @include('components.mycoupons')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-only" style="padding-bottom:30px;">
    <ul>
        <li class="submenu">
            <div class="menuText">
                My Profile
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                <div style="float:left; width:130px; padding-top:10px;">
                    Username/Email:
                </div>
                <div style="float:left; padding-top:15px;">
                    <input name="txtEmailMobile" type="text" value="{{$user->email}}" id="txtEmailMobile" disabled="disabled">
                </div>                    
                <div class="clear"></div>                    
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                <div style="float:left; width:130px; padding-top:10px;">
                    First Name:    
                </div>
                <div style="float:left; padding-top:15px;">
                    <input name="txtFirstNameMobile" type="text" value="{{$user->firstName}}" id="txtFirstNameMobile">
                    <span id="requiredFirstNameMobile" class="required" style="font-size:15pt;visibility:hidden;">*</span>
                </div>                    
                <div class="clear"></div>
            </div>
        </li>
        <li class="submenu">
            <div class="menuText">
                <div style="float:left; width:130px; padding-top:10px;">
                    Last Name:    
                </div>
                <div style="float:left; padding-top:15px;">
                    <input name="txtLastNameMobile" type="text" value="{{$user->lastName}}" id="txtLastNameMobile">
                    <span id="requiredLastNameMobile" class="required" style="font-size:15pt;visibility:hidden;">*</span>
                </div>                    
                <div class="clear"></div>
            </div>                
        </li>
        <li class="submenu">
             <div class="menuText">
                <div style="float:left; width:130px; padding-top:10px;">
                    Zipcode:
                </div>
                <div style="float:left; padding-top:15px;">
                    <input name="txtZipcodeMobile" type="text" value="43081" id="txtZipcodeMobile">
                    <span id="requiredZipcodeMobile" class="required" style="font-size:15pt;visibility:hidden;">*</span>
                    <span id="validatorZipcodeMobile" class="required" style="visibility:hidden;">Invalid!</span>
                </div>                    
                <div class="clear"></div>
            </div>                   
        </li>
         <li class="submenu">
            <div class="menuText">
                <a id="lbSaveMobile" class="mini-gold" href='javascript:save("Mobile")'> Save </a>&nbsp;
            </div>                   
        </li>
    </ul>
    
    @include('common.footer_mobile_widget')
</div>

@endsection
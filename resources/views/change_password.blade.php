@extends('layouts.page_master')

@section('head')
	<style type="text/css">
        .regMainContainer { width:960px; margin:0 auto; background: url('/Images/img_contentBGSlice.png') repeat-x top left;}
        #regFormContainer { width:620px; min-height:400px; margin:0 auto 60px auto; position:relative; top:30px;}
        .stepContainer { width:600px; height:65px; margin:0 auto 20px auto;}
        .step1 { width:260px; float:left; margin: 0 10px;}
        .step2 { width:260px; float:left; margin: 0 10px;}
        .stepTxtOn { color:#B28211; font-size:15px; position:relative; top:40px; left:10px; float:left; border-bottom:2px solid #B28211; width:190px;}
        .stepTxtOff { color:#2F2305; font-size:15px; position:relative; top:40px; left:10px; float:left; border-bottom:2px solid #2F2305; width:190px;}
        .requiredMessage {color:#b03535; font-size:12px;}
    </style>
    <script type="text/javascript" src="/js/account.js"></script>
@endsection

@section('content')
@include('common.sidetab')

<!-- Normal Content -->
<div class="content">

    <div class="mainContentContainer">
        <div class="regMainContainer">
            <div id="regFormContainer">
                <form onsubmit="changePassword(''); return false;">
                    <table id="changePassword" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td>
                                    <div class="stepContainer">
                                        <div class="step1">
                                            <img class="floatLt" src="/Images/step1_on.png">
                                            <p class="stepTxtOn">Change Password</p>
                                        </div>
                                        <div class="step2">
                                            <img class="floatLt" src="/Images/step2_off.png">
                                            <p class="stepTxtOff">Complete</p>
                                        </div>
                                    </div>
                                    <table cellpadding="1" cellspacing="0" style="border-collapse:collapse;">
                                        <tbody>
                                            <tr>
                                                <td style="padding-left:90px;">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td align="left" style="width:150px;">
                                                                    <label for="currentPassword" style="color:White;">Current Password:</label>
                                                                </td>
                                                                <td>
                                                                    <input name="currentPassword" type="password" id="currentPassword">
                                                                    <span id="currentPasswordRequired" title="Password is required." class="requiredMessage" style="visibility:hidden;">Required!</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                    <label for="newPassword" style="color:White;">New Password:</label>
                                                                </td>
                                                                <td>
                                                                    <input name="newPassword" type="password" id="newPassword">
                                                                    <span id="newPasswordRequired" title="New Password is required." class="requiredMessage" style="visibility:hidden;">Required!</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left">
                                                                    <label for="confirmPassword" style="color:White;">Confirm New Password:</label>
                                                                </td>
                                                                <td>
                                                                    <input name="confirmNewPassword" type="password" id="confirmPassword">
                                                                    <span id="confirmPasswordRequired" title="Confirm New Password is required." class="requiredMessage" style="visibility:hidden;">Required!</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" colspan="2">
                                                                    <span id="newPasswordCompare" class="requiredMessage" style="visibility:hidden;">The Confirm New Password must match the New Password entry.</span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" colspan="2" style="color:#b03535;" id="error">
                                                                    
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                </td>
                                                                <td>
                                                                    <input type="button" class="btn btn-danger" value="Cancel" />
                                                                    &nbsp;
                                                                    <input type="submit" value="Change Password" onclick="" id="submit" class="btn btn-warning">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>    
        </div>
    </div>

</div>

<div class="mobile-only">
    <ul>
        <li class="submenu">
            <div class="menuText">                    
                Change Password
            </div>   
        </li>
    </ul>
        
    <div class="mobileContentPane" style="padding-bottom:0px;">
        <div class="mobileContent">
            <div id="regFormContainerMobile">
                <form onsubmit="changePassword('Mobile'); return false;" method="POST">
                    <table id="mChangePassword" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">
                        <tbody>
                            <tr>
                                <td>
                                    <div style="width:100%;">
                                        <div style="padding-top:10px; padding-bottom:10px;">
                                            <label for="currentPasswordMobile" >Password:</label>&nbsp;
                                            <span id="currentPasswordRequiredMobile" title="Password is required." class="requiredMessage" style="visibility:hidden;">Required!</span><br>
                                            <input name="currentPassword" type="password" id="currentPasswordMobile">
                                        </div>
                                        <div style="padding-bottom:10px;">
                                            <label for="newPasswordRequiredMobile" >New Password:</label>&nbsp;
                                            <span id="newPasswordRequiredMobile" title="New Password is required." class="requiredMessage" style="visibility:hidden;">Required!</span><br>
                                            <input name="newPassword" type="password" id="newPasswordMobile">
                                        </div>
                                        <div style="padding-bottom:10px;">
                                            
                                        </div>
                                        <div style="padding-bottom:10px;">
                                            <label for="confirmPasswordMobile">Confirm New Password:</label>&nbsp;
                                            <span id="confirmPasswordRequiredMobile" title="Confirm New Password is required." class="requiredMessage" style="visibility:hidden;">Required!</span><br>
                                            <input name="confirmNewPassword" type="password" id="confirmPasswordMobile">
                                        </div>
                                        <div style="padding-bottom:10px;">
                                            
                                        </div>
                                        <div style="padding-bottom:10px;">
                                            <span id="newPasswordCompareMobile" class="requiredMessage" style="visibility:hidden;">The Confirm New Password must match the New Password entry.</span>
                                        </div>
                                        <div style="padding-bottom:10px; color:#B03535;" id="errorMobile">
                                            
                                        </div>
                                        <div style="padding-bottom:10px;">
                                            <a href="/" class="mini-red" style="font-size:12pt;">Cancel</a>
                                                &nbsp;
                                            <input type="submit" value="Change Password" class="mini-gold" style="font-size:12pt; margin-top:5px;">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

    @include('common.footer_mobile_widget')

    </div>

@endsection
@extends('layouts.login_master')

@section('head')

<style>
    .noMargin
    {
        margin-bottom:0px;                            
        padding:0px;
    }
</style>

<script type="text/javascript">
    redirect = '';
    @if (isset($redirect))
        redirect = "{{$redirect}}";
    @endif
</script>

<script type="text/javascript" src="/js/login.js"></script>
@endsection

@section('content')
<div class="content">
    <div class="mainContentContainer">
        <div class="pgMainContainer">
            <div class="pgContainer">
                <p class="titleText">Login</p>
                <div>
                    <form onsubmit="login(''); return false;">
                    <table style="border: solid thin silver; padding: 20px; width: 915px; line-height:2.5; color:#999;">                                
                        <tbody>
                            <tr>
                                <td style="width: 20px; padding-top:20px;">
                                    &nbsp;
                                </td>
                                <td style="width: 90px; padding-top:20px;" align="right">
                                    <b>User Name:&nbsp;&nbsp;</b>
                                </td>
                                <td style="width: 190px; padding-top:20px;">
                                    <input name="userName" type="text" id="userName" class="noMargin" style="width:175px;">
                                </td>
                                <td style="padding-top:20px;">
                                    <span id="rfvUserName" title="User Name is required." class="error" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">*Required!</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    &nbsp;
                                </td>
                                <td align="right">
                                    <b>Password:&nbsp;&nbsp;</b>
                                </td>
                                <td>
                                    <input name="password" type="password" id="password" class="noMargin" style="width:175px;">
                                </td>
                                <td>
                                    <span id="rfvPassword" title="Password is required." class="error" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;">*Required!</span>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20px; padding-top:20px;">
                                    &nbsp;
                                </td>
                                <td style="width: 90px; padding-top:20px;" align="right">
                                    &nbsp;
                                </td>
                                <td colspan="2" style="text-align:left ;">
                                    <a href="/forgot-password" style="color:#fff; font-size:8pt;">Forgot your password?</a>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td colspan="3" align="left" style="color: Red; font-size: 8pt;" class="loginErrorText">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td colspan="3" style="text-align: right; padding-right: 20px; padding-bottom:20px;">
                                    <input type="submit" name="btnLogin" value=" Login " id="btnLogin" class="mini-gold" style="font-weight:bold;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </form>
                </div>
            </div>
        </div>
    </div>    
</div>

<div class="mobile-only">
    <ul>
        <li class="submenu">                
            <div class="menuText mobileTitle">
                LOGIN
            </div>
        </li>
    </ul>

    <div class="mobileContentPane">
        <div class="mobileContent">
            <div>
                <form onsubmit="login('Mobile'); return false;">
                <div style="padding-bottom:5px;">
                    <b>User Name:&nbsp;&nbsp;</b>
                    <span id="rfvUserNameMobile" title="User Name is required." class="error" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">*Required!</span>
                </div>
                <div style="padding-bottom:25px;">
                    <input name="userNameMobile" type="text" id="userNameMobile" class="noMargin" style="font-size:12pt;height:25px;">
                </div>
                <div style="padding-bottom:5px;">
                    <b>Password:&nbsp;&nbsp;</b>
                    <span id="rfvPasswordMobile" title="Password is required." class="error" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">*Required!</span>
                </div>
                <div style="padding-bottom:25px;">
                    <input name="passwordMobile" type="password" id="passwordMobile" class="noMargin" style="font-size:12pt;height:25px;">
                </div>
                <div>
                    <input type="submit" name="btnLoginMobile" value=" Login " id="btnLoginMobile" class="mini-gold" style="font-size:12pt;font-weight:bold;">
                </div>
                <div style="color:#B03535;" class="loginErrorText">
                    
                </div>
                </form>
            </div>
        </div>            
    </div>
</div>
@endsection
@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script type="text/javascript" src="/js/admin/active_user.js"></script>

<style type="text/css">
    .pagingContainer ul{
        list-style-type: none;
        margin: 0;
        padding: 0;
    }

    .pagingContainer li{
        display: inline;
        margin-left: 5px;
        font-size: 12px;
    }

    .pagingContainer li a{
        color: #999;
    }
</style>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div id="grid">
                <p class="titleText">
                    Manage Users (Admin Only)
                </p>
                <div style=" float:right; padding-bottom: 30px;">
                    <table width="500px" cellpadding="5" cellspacing="0" style="-moz-border-radius: 10px; border-radius: 10px; background-color: #b1b4b5;
                        background-image: -moz-linear-gradient(top, #b1b4b5 0%, #5f6161 100%);
                        background-image: -webkit-linear-gradient(top, #b1b4b5 0%, #5f6161 100%);
                        background-image: -o-linear-gradient(top, #b1b4b5 0%, #5f6161 100%);
                        background-image: -ms-linear-gradient(top, #b1b4b5 0% ,#5f6161 100%);
                        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#5f6161', endColorstr='#5f6161',GradientType=0 );
                        background-image: linear-gradient(top, #b1b4b5 0% ,#5f6161 100%);
                        -webkit-box-shadow: 0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;
                        -moz-box-shadow: 0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;
                        box-shadow: 0px 0px 2px #bababa, inset 0px 0px 1px #ffffff;">
                        <tbody>
                            <tr>
                                <td colspan="3"></td>
                            </tr>                        
                            <tr>
                                <td style="width:150px; padding-left:20px; font-weight:bold; font-size:12pt;">
                                    Filter By
                                </td>
                                <td style="position:relative; top:-5px;" colspan="2"></td>
                            </tr>
                            <tr>
                                <td style="width:150px; padding-left:20px; font-weight:bold;">
                                    <select name="ddlFilterType" id="ddlFilterType" style="width:140px;">
                                        <option value=""
                                        @if ($fkey == '')
                                        selected="selected" 
                                        @endif
                                        >Select One</option>
                                        <option value="firstName"
                                        @if ($fkey == 'firstName')
                                        selected="selected" 
                                        @endif
                                        >First Name</option>
                                        <option value="lastName"
                                        @if ($fkey == 'lastName')
                                        selected="selected" 
                                        @endif
                                        >Last Name</option>
                                        <option value="Email"
                                        @if ($fkey == 'email')
                                        selected="selected" 
                                        @endif
                                        >Email</option>
                                        <option value="promoCode"
                                        @if ($fkey == 'promoCode')
                                        selected="selected" 
                                        @endif
                                        >Promo Code</option>
                                    </select>
                                </td>
                                <td style="width:150px; padding-left:10px; font-weight:bold;">
                                    <input name="txtFilter" type="text" id="txtFilter" style="width:140px;" value="{{$fval}}">
                                </td>
                                <td style="position:relative; top:-5px;">
                                    <a id="lbReset" class="mini-grey" href="javascript:" onclick="resetFilter();">Reset</a>&nbsp;
                                    <a id="lbFilter" class="mini-gold" href='javascript:' onclick="setFilter();">Filter</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding-left:20px;">
                                    <span id="rqrdFilter" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Filter Type is Required!</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="clear:both;"></div>
                <div id="activeUsers">
                    @include('components.admin.active_users')
                </div>

            </div>
            <div id="fields" style="display:none;">
                <p class="titleText" style="padding-bottom: 10px;">
                    Edit User Info  (Admin Only)
                </p>
                <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999; padding-left:10px; font-size:12pt; line-height:2;">
                <tbody>
                    <tr>
                        <td style="width: 150px;">
                            Promo:
                        </td>
                        <td>
                            <span id="lblCode">10001</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Username / Email:
                        </td>
                        <td>
                            <span id="lblUsername"></span>                                
                        </td>
                    </tr>
                    <tr>
                        <td>
                            First Name:
                        </td>
                        <td>
                            <input name="firstName" type="text" value="" id="txtFirstName" class="txtLocation requiredInput">
                            <span id="firstNameRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Last Name:
                        </td>
                        <td>
                            <input name="lastName" type="text" value="Clum" id="txtLastName" class="txtLocation requiredInput">
                            <span id="lastNameRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Zipcode:
                        </td>
                        <td>
                            <input name="zipcode" type="text" value="43081" id="txtZipcode" class="txtLocation requiredInput">
                            <span id="ContentPlaceHolder1_RequiredFieldValidator3" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                        </td>
                    </tr>                        
                    <tr>
                        <td colspan="2" style="padding:10px; text-align:right;">
                            <input type="submit" name="btnCancel" value=" Cancel " onclick="hideFields();" id="btnCancel" class="mini-red" style="font-weight:bold;">
                            &nbsp;&nbsp;
                            <input type="submit" name="btnSaveBusiness" value="   Save   " onclick="submitEdit();" id="btnSaveBusiness" class="mini-gold" style="font-weight:bold;">
                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
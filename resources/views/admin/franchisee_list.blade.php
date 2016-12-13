@extends('layouts.admin_master')

@section('head')

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

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

<script type="text/javascript" src="/js/admin/franchise.js"></script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.admin_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div id="grid">
                <p class="titleText">
                    Franchisee List
                </p>
                
                <div style="clear:both;"></div>
                <div style="text-align: right; padding-bottom: 10px;">                    
                    <a onclick="showCreate();" id="lbAddNewFranchise" class="mini-gold" href="javascript:">Add New Franchise</a>
                </div>
                <div id="franchisees">
                    @include('components.admin.franchisees')
                </div>

            </div>
            <div id="fields" style="display:none;">
                <p class="titleText" style="padding-bottom: 10px;">
                    <span id="lblAddOrEdit">Add</span>&nbsp;Franchisee Info
                </p>
                <div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
                    <tbody>
                        <tr>
                            <td style="width: 150px;">
                                Franchise Code:
                            </td>
                            <td width="230px;">
                                <input name="code" type="text" id="txtCode" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="codeRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">
                                Franchise Name:
                            </td>
                            <td>
                                <input name="name" type="text" id="txtName" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="nameRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">
                                Franchise Legal Name:
                            </td>
                            <td>
                                <input name="legalName" type="text" id="txtLegalName" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="legalNameRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">
                                Phone:
                            </td>
                            <td>
                                <input name="phone" type="text" id="txtPhone" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="phoneRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 100px;">
                                Street Address:
                            </td>
                            <td>
                                <input name="streetAddress" type="text" id="txtStreetAddress" class="requiredParam param">
                            </td>
                            <td>
                                <input name="showOnContract" id="cbxShowOnContract" type="checkbox">
                                <label for="showOnContract">Show On Contract</label>
                                <span id="streetAddressRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City:
                            </td>
                            <td>
                                <input name="city" type="text" id="txtCity" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="cityRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                State:
                            </td>
                            <td>
                                <select name="state" id="ddlState" class="requiredParam param">
                                    <option selected="selected" value=""></option>
                                    @foreach ($states as $state)
                                    <option value="{{$state->stateAbbr}}">{{$state->state}}</option>
                                    @endforeach
                                </select>&nbsp;
                            </td>
                            <td>
                                <span id="stateRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Franchisee Zipcode:
                            </td>
                            <td>
                                <input name="zipcode" type="text" id="txtZipcode" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="zipcodeRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Zipcodes:                                            
                            </td>
                            <td>
                                <textarea name="zipcodes" rows="7" cols="20" id="txtZipcodes" class="txtZipcodes watermark param"></textarea>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Contact First Name:
                            </td>
                            <td>
                                <input name="firstName" type="text" id="txtFirstName" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="firstName" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Contact Last Name:
                            </td>
                            <td>
                                <input name="lastName" type="text" id="txtLastName" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="lastNameRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email / Username:
                            </td>
                            <td>
                                <textarea name="emails" rows="7" cols="20" id="txtEmails" class="txtEmail watermark param"></textarea>
                            </td>
                            <td>
                                <span style="font-size:8pt; font-style:italic;">(tied to this franchise)</span>&nbsp;
                                <span id="emailRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                LM Group ID:
                            </td>
                            <td>
                                <input name="lmGroup" type="text" id="txtLmGroup" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="lmGroupRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                LM User Name
                            </td>
                            <td>
                                <input name="lmUsername" type="text" id="txtLmUsername" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="lmUsernameRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                LM Password:
                            </td>
                            <td>
                                <input name="lmPassword" type="text" id="txtLmPassword" class="requiredParam param">&nbsp;
                            </td>
                            <td>
                                <span id="lmPasswordRequired" style="color:Red;font-size:8pt;font-weight:bold;visibility:hidden;" class="validator">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Account Status:
                            </td>
                            <td>
                                <span style="color:#999999;">
                                <input id="cbxStatus" type="checkbox" name="status">
                                <label for="cbxStatus">Is Active</label></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                Launch Status:
                            </td>
                            <td>
                                <span style="color:#999999;">
                                <input id="cbxLaunchStatus" type="checkbox" name="launchStatus">
                                <label for="cbxLaunchStatus">Post Launch</label></span>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                            </td>
                            <td style="padding-top:10px;">                                            
                                <input type="submit" name="btnCancel" value=" Cancel " onclick="hideFields();" id="btnCancel" class="mini-red" style="font-weight:bold;">
                                &nbsp;&nbsp;
                                <input type="submit" name="btnSaveFranchise" value="   Save   " onclick="submitEdit()" id="btnSaveFranchise" class="mini-gold" style="font-weight:bold;">
                            </td>
                        </tr>
                    </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
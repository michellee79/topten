@extends('layouts.franchisor_master')

@section('head')
<script type="text/javascript" src="/scripts/tinymce/tinymce.min.js"></script>

<style type="text/css">
    .verticalStitchDivider {
        background: url('/Images/img_vertStitching.png') no-repeat;
        width: 1px;
        height: 330px;
        float: left;
        margin: 0px 0 0 0;
    }

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

    .mce-edit-area{
    	overflow-y:scroll !important;
    	max-height: 300px !important;
    	height: 400px;
    }

</style>

<script type="text/javascript" src="/scripts/showLoading/js/jquery.showLoading.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/showLoading/css/showLoading.css" />

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/js/franchisor/business_crud.js"></script>
<script type="text/javascript">
	
	function showLoading() {
        $('#pnlUpdate').showLoading();
    }

    function hideLoading() {
        $('#pnlUpdate').hideLoading();
    }

	var categories = JSON.parse('<?php echo $categoriesJson ?>');
	var bId = '{{$business->id}}';
</script>

@endsection

@section('content')
<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')
		<div class="pgContainer">
			<div style="color: #999999; padding-top:0px; padding-bottom:100px;">
		        <div>
		            <div>
		                <div id="pnlUpdate">
		                    <div id="divFields">
		                        <div style="float:left;">
		                            <p class="titleText" style="padding-bottom: 10px;">
		                                <span id="lblAddOrEdit">{{$createOrEdit}}</span>&nbsp;Business Listing
		                            </p>
		                        </div>
		                        <div style="float:right;">
		                            <a id="linkToCancelTop" class="mini-red" href="/franchise_businesses">Cancel</a>
		                                &nbsp;&nbsp;
		                                <span style="position:relative; top:4px;">
		                                    <input type="submit" name="btnSaveTop" value=" Save " onclick="submit()" id="btnSaveTop" class="mini-gold" style="font-weight:bold;">
		                                </span>
		                            </div>
		                            <div class="clear"></div>

		                            <div>
		                                <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999;">
		                                    <tbody>
		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Franchise:
		                                        </td>
		                                        <td>
		                                            <select name="franchisee" id="ddlFranchise" class="requiredInput">
														<option value="">Select a Franchise</option>
														@foreach($franchisees as $franchisee)
														<option value="{{$franchisee->id}}"
														@if($fid == $franchisee->id)
														selected="selected"
														@endif
														>{{$franchisee->code}}</option>
														@endforeach
													</select>
		                                            &nbsp;<span id="franchiseeRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Group 1:
		                                        </td>
		                                        <td>
		                                            <select name="group" id="ddlGroup" class="requiredInput" onchange="refreshCategory()">
														<option value="">Select a Group</option>
														@foreach ($categories as $group)
														<option value="{{$group->name}}"
														@if ($group->name == $business->ctGroup)
														selected="selected"
														@endif
														>{{$group->name}}</option>
														@endforeach
													</select>
		                                            &nbsp;<span id="groupRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>

		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Category 1:
		                                        </td>
		                                        <td>
		                                            <select name="category" id="ddlCategory" class="requiredInput" onchange="refreshSubCategory()">
														<option value="">Select a Category</option>
														@foreach ($cats as $cat)
														<option value="{{$cat->name}}"
														@if ($cat->id == $business->parentcategoryId)
														selected="selected"
														@endif
														>{{$cat->name}}</option>
														@endforeach
													</select>
		                                            &nbsp;<span id="categoryRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>

		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Sub Category 1:
		                                        </td>
		                                        <td>
		                                            <select name="subCategory" id="ddlSubCategory" 
		                                            @if ($createOrEdit == 'Add')
		                                            disabled="disabled"
		                                            @endif
		                                             class="requiredInput">
		                                            @foreach ($subcats as $subcat)
														<option value="{{$subcat->id}}"
														@if ($subcat->id == $business->businesssubcategoryId)
														selected="selected"
														@endif
														>{{$subcat->name}}</option>
													@endforeach
													</select>
		                                            &nbsp;<span id="subCategoryRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>



		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Group 2:
		                                        </td>
		                                        <td>
		                                            <select name="group2" id="ddlGroup2" class="requiredInput" onchange="refreshCategory('2')">
														<option value="0"
														@if ($business->ctGroup2 == null || $business->ctGroup2 == 0)
														selected="selected"
														@endif
														>Select a Group</option>
														@foreach ($categories as $group)
														<option value="{{$group->name}}"
														@if ($group->name == $business->ctGroup2)
														selected="selected"
														@endif
														>{{$group->name}}</option>
														@endforeach
													</select>
		                                            &nbsp;<span id="groupRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>

		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Category 2:
		                                        </td>
		                                        <td>
		                                            <select name="category2" id="ddlCategory2" class="requiredInput" onchange="refreshSubCategory('2')">
														<option value="0"
														@if ($business->parentcategoryId2 == null || $business->parentcategoryId2 == 0)
														selected="selected"
														@endif
														>Select a Category</option>
														@foreach ($cats2 as $cat)
														<option value="{{$cat->name}}"
														@if ($cat->id == $business->parentcategoryId2)
														selected="selected"
														@endif
														>{{$cat->name}}</option>
														@endforeach
													</select>
		                                            &nbsp;<span id="categoryRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>

		                                    <tr>
		                                        <td style="width: 150px;">
		                                            Sub Category 2:
		                                        </td>
		                                        <td>
		                                            <select name="subCategory2" id="ddlSubCategory2" 
		                                            @if ($createOrEdit == 'Add')
		                                            disabled="disabled"
		                                            @endif
		                                             class="requiredInput">
		                                            @foreach ($subcats2 as $subcat)
														<option value="{{$subcat->id}}"
														@if ($subcat->id == $business->businesssubcategoryId2)
														selected="selected"
														@endif
														>{{$subcat->name}}</option>
													@endforeach
													</select>
		                                            &nbsp;<span id="subCategoryRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>



		                                    <tr>
		                                        <td>
		                                            Business Name:
		                                        </td>
		                                        <td>
		                                            <input name="businessName" type="text" id="txtBusiness" value="{{$business->name}}" class="requiredInput">
		                                            &nbsp;<span id="businessNameRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width: 100px;">
		                                            Address:
		                                        </td>
		                                        <td>
		                                            <input name="address" type="text" id="txtAddress" class="requiredInput" value="{{$business->address}}">&nbsp;
		                                            <span id="addressRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width: 100px;">
		                                            City:
		                                        </td>
		                                        <td>
		                                            <input name="city" type="text" id="txtCity" class="requiredInput" value="{{$business->city}}">&nbsp;
		                                            <span id="cityRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td style="width: 100px;">
		                                            State:
		                                        </td>
		                                        <td>
		                                            <select name="state" id="ddlState" class="requiredInput">
														<option value="">Select a State</option>
														@foreach ($states as $state)
														<option value="{{$state->stateAbbr}}"
														@if ($business->state == $state->stateAbbr)
														selected="selected"
														@endif
														>{{$state->state}}</option>
														@endforeach
													</select>
													&nbsp;<span id="stateRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
												</td>
		                                	</tr>
		                                    <tr>
		                                        <td>
		                                            Zipcode:
		                                        </td>
		                                        <td>
		                                            <input name="zipcode" type="text" id="txtZipcode" class="requiredInput" value="{{$business->zipcode}}">
		                                            &nbsp;<span id="zipcodeRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Contact First Name:
		                                        </td>
		                                        <td>
		                                            <input name="firstName" type="text" id="txtFirstName" value="{{$business->firstName}}">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Contact Last Name:
		                                        </td>
		                                        <td>
		                                            <input name="lastName" type="text" id="txtLastName" value="{{$business->lastName}}">                                            
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Contact Email:
		                                        </td>
		                                        <td>
		                                            <input name="email" type="text" id="txtEmail" value="{{$business->email}}">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Website URL:
		                                        </td>
		                                        <td>
		                                            <input name="URL" type="text" id="txtURL" value="{{$business->website}}">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Phone Number:
		                                        </td>
		                                        <td>
		                                            <input name="phone" type="text" id="txtPhone" value="{{$business->phone}}">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Cellphone Number:
		                                        </td>
		                                        <td>
		                                            <input name="cellphone" type="text" id="txtCellphone" value="{{$business->cellPhone}}">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Start Date:
		                                        </td>
		                                        <td>
		                                            <input name="startDate" type="text" id="txtStartDate" class="datepicker" value="{{convertDate($business->startDate, 'm/d/Y')}}">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Status:
		                                        </td>
		                                        <td>
		                                            <span style="color:#999999;">
		                                            <input id="status" type="checkbox" name="cbxStatus" 
		                                            @if ($business->isActive == 1)
		                                            checked="checked"
		                                            @endif
		                                            >
		                                            <label for="cbxStatus">Is Active</label></span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td>
		                                            Summary:
		                                        </td>
		                                        <td>
		                                            <textarea name="summary" rows="5" cols="20" id="txtSummary" style="width:500px;" class="requiredInput">{{$business->summary}}</textarea>
		                                            &nbsp;<span id="summaryRequired" style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                            <br>
		                                        </td>
		                                    </tr>                                    
		                                    <tr>
		                                        <td colspan="2" style="border-bottom:dashed 2px silver;">                                             
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">                                            
		                                            <br>
		                                            <p class="titleText" style="padding-bottom: 10px;">
		                                                Business Profile</p>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                            <table width="100%" cellpadding="0" cellspacing="0">
		                                                <tbody>
		                                                <tr>
		                                                    <td style="width:300px; padding:5px; padding-top:12px; vertical-align:top;">
		                                                        <div>
		                                                        	@if ($createOrEdit == 'Add')
		                                                        	<img id="imgBusinessLogo" src="/Images/BusinessProfile/DefaultBusinessImage.png" style="height:200px;width:220px;">
		                                                        	@else
		                                                            <img id="imgBusinessLogo" src="{{$business->logo->url}}" style="height:200px;width:220px;">
		                                                            @endif
		                                                        </div>
		                                                        <div style="padding-top:10px; font-weight:bold; font-size:11pt; width:200px;">
		                                                            Upload Business Logo:<br>
		                                                            <span style="font-weight:bold; font-style:italic; font-size:10pt;">Note for Recommended Image Size:</span><br>
		                                                            <span style="font-weight:bold; font-style:italic; font-size:10pt;">Max Width = 220px</span><br>
		                                                            <span style="font-weight:bold; font-style:italic; font-size:10pt;">Max Height = 180px</span>
		                                                        </div>
		                                                        <div style="padding-top:5px;">
		                                                            <div id="fpBusinessImage" class="RadAsyncUpload RadUpload RadUpload_Default" style="width:280px;">
																		<span style="position: absolute; display: block; width: 100%;">
																			<input type="file" name="image" accept="image/*" id="imagePicker" />
																		</span>
																	</div>
		                                                        </div>
		                                                        <div style="padding-top:50px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver;">
		                                                            <a id="lbBusinessImageGallery" href="/franchise_business_images/{{$business->id}}" class="mini-grey" style="font-size:24px;">Manage Images</a>
		                                                        </div>
		                                                        <div style="clear:both; padding-bottom:50px;"></div>
		                                                        <div style="padding-top:50px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver;">
		                                                            <a id="linkToManageContract" 
		                                                            
		                                                            onclick="showContract()"
		                                                            class="mini-gold" style="font-size:24px; cursor: pointer;" 
		                                                            >Contract</a>
		                                                        </div>                
		                                                        <div style="clear:both; padding-bottom:50px;"></div>
		                                                        <div style="padding-top:50px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver;">
		                                                            <a id="lbManageCoupons" href="/franchise_business_coupons/{{$business->id}}" class="mini-green" style="font-size:24px;">Manage Coupons</a>
		                                                        </div>
		                                                        <div style="clear:both; padding-bottom:50px;"></div>
		                                                        <div style="padding-top:50px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver;">
		                                                            <a id="lbManageRatings" href="/franchise_business_ratings/{{$business->id}}" class="mini-gold" style="font-size:24px;">Manage Ratings</a>
		                                                        </div>                                          
		                                                        <div style="clear:both; padding-bottom:50px;"></div>
		                                                        <div style="padding-top:50px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver;">
		                                                            <a id="lbManageComplains" href="/franchise_business_complaints/{{$business->id}}" class="mini-red" style="font-size:24px;">Manage Complaints</a>
		                                                        </div>  
		                                                        <div style="clear:both; padding-bottom:50px;"></div>
		                                                        <div style="padding-top:50px; font-weight:bold; font-size:12pt; border-top: dashed 2px silver;">
		                                                            <a id="lbReports" class="mini-gold" href="/franchise_business_report/{{$business->id}}" style="font-size:22px;">Profile &amp; Coupon Views</a>
		                                                        </div>
		                                                    </td>
		                                                    <td style="width:600px; padding:10px; vertical-align:top;">
		                                                        <div id="editorTopRight" class="RadEditor Default reWrapper" style="width: 580px; min-width: 580px;">
																	<textarea id="topRightEditor" style="width:582px;">{{$business->profileTopRight}}</textarea>
																</div>
		                                                        
		                                                        <br><br><br><br>
		                                                        
		                                                        <div id="editorBottomLeft" class="RadEditor Default reWrapper" style="width: 580px; min-width: 580px;">
		                                                        	<textarea id="bottomLeftEditor" style="width:582px;">{{$business->profileBottomLeft}}</textarea>
																</div>
																
																<form id="my_form" action="/upload" target="form_target" method="post" enctype="multipart/form-data" style="width:0px;height:0;overflow:hidden">
													                <input type="hidden" name="_token" value="{{ csrf_token() }}">
													                <input name="image" id="uploadname" type="file" onchange="upload();">
													            </form>

		                                                    </td>
		                                                </tr>
		                                            	</tbody>
		                                            </table>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                            <table width="100%" cellpadding="0" cellspacing="0">
		                                                <tbody>
		                                                <tr>
		                                                    <td style="width:600px; padding:10px; vertical-align:top;">
		                                                         
		                                                    </td>
		                                                    <td style="width:300px; padding:10px; vertical-align:top; padding-left:20px; padding-top:50px;">                                                        
		                                                        
		                                                    </td>
		                                                </tr>
		                                            	</tbody>
		                                            </table>    
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                            <br>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2" style="border-bottom:dashed 2px silver;">
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2">
		                                            <br>
		                                        </td>
		                                    </tr>
		                                    <tr>
		                                        <td colspan="2" style="padding:10px; text-align:right;">
		                                            <a id="linkToCancelBottom" class="mini-red" href="/franchise_businesses">Cancel</a>
		                                            
		                                            &nbsp;&nbsp;
		                                            <span style="position:relative; top:4px;">
		                                                <input type="submit" name="btnSaveBusiness" value=" Save " onclick="submit()" id="btnSaveBusiness" class="mini-gold" style="font-weight:bold;">
		                                            </span>
		                                        </td>
		                                    </tr>
		                                	</tbody>
		                                </table>
		                            </div>
		                        </div>
		                    </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>
@endsection
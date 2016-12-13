@extends('layouts.franchisor_master')

@section('head')
<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="/scripts/showLoading/js/jquery.showLoading.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/showLoading/css/showLoading.css" />

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script type="text/javascript" src="/js/franchisor/contract.js"></script>

<style type="text/css">
.txt {
    color: #A6832F;
    font-weight: bold;
    font-size: 11pt;
}
</style>

<script type="text/javascript">
	categories = JSON.parse('<?php echo $categoriesJson ?>');
	bId = {{$bc->businessId}};
</script>

@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')
		<div class="pgContainer">
			<div class="fRight">
		        <a id="linkToBusinessProfile" class="mini-gold" href="/franchise_edit_business/{{$bc->businessId}}">Business Profile</a>
		    </div>
		    <div style="clear:both;"></div>
		    <br>
		    <div class="ContractBody">        
		        <div class="left">
		            <div style="position:relative; top: -40px;">
		                <img src="/Images/TTP_Logo_bg_white.JPG">
		            </div>            
		        </div>
                
		        <div class="right">
		        	{{$franchisee->legalName}}<br>
		           	dba Top Ten Percent #{{$franchisee->code}}<br/>
		           	{{$franchisee->streetAddress}} <br>
		           	{{$franchisee->city}}, {{$franchisee->state}} {{$franchisee->franchiseZipcode}}<br/>
		           	{{$franchisee->phone}}
		        </div>
	    		<div class="clear"> </div>
	    		<h2>Business Membership Agreement</h2>
		        <div class="ContractLanguage">
		            This “Business Membership Agreement” (“Agreement”) is effective as per the date shown below, it is entered into by {{$enterprise}} dba Top Ten Percent, Inc. (“TTP”) an {{$corporation}} with the address above and:
		        </div>
		        <div class="ContractInputs">
		            <table class="Form W100p">
		                <tbody>
		                <tr>
		                    <td colspan="3">BUSINESS NAME ("BUSINESS MEMBER")
		                        <input name="txt_BusinessName" type="text" value="{{$bc->name}}" id="txt_BusinessName" class="W50p txt">
		                    </td>
		                    <td>DATE
		                        <input name="txt_EffectiveDate" type="text" value="{{$bc->effectiveDate}}" id="txt_EffectiveDate" class="W50p datepicker txt">
		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="2" style="width: 350px;">ADDRESS
		                        <input name="txt_Address" type="text" value="{{$bc->address}}" id="txt_Address" class="W75p txt">

		                    </td>
		                    <td>CITY
		                        <input name="txt_City" type="text" value="{{$bc->city}}" id="txt_City" class="W75p txt">
		                    </td>
		                    <td>
		                        <div style="float:left; padding-top:7px;">
		                            STATE
		                        </div>
		                        <div style="float:left; padding-top:2px; padding-left:5px;">
		                            <select name="$ddlState" id="ddlState" style="width:120px;">
										<option value="">Select a State</option>
										@foreach ($states as $state)
										<option value="{{$state->stateAbbr}}"
										@if ($bc->state == $state->stateAbbr)
										selected="selected"
										@endif
										>{{$state->state}}</option>
										@endforeach
									</select>
		                        </div>                                                                                            
		                    </td>
		                </tr>
		                <tr>
		                    <td>
		                        ZIP
		                        <input name="txt_Zip" type="text" value="{{$bc->zip}}" id="txt_Zip" class="W75p txt">
		                    </td>
		                    <td>PHONE
		                        <input name="txt_Phone" type="text" value="{{$bc->phone}}" id="txt_Phone" class="W60p txt">
		                    </td>
		                    <td colspan="2">FAX
		                        <input name="txt_Fax" type="text" id="txt_Fax" class="W60p txt" value="{{$bc->fax}}">
		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="2">
		                        EMAIL
		                        <input name="txt_Email" type="text" value="{{$bc->email}}" id="txt_Email" class="W75p txt">
		                    </td>
		                    <td colspan="2">WEBSITE
		                        <input name="txt_Website" type="text" value="{{$bc->website}}" id="txt_Website" class="W75p txt">
		                    </td>
		                   
		                </tr>
		                 <tr>
		                    <td colspan="2">
		                        AUTHORIZED REPRESENTATIVE
		                        <input name="txt_AuthorizedRep" type="text" value="{{$bc->authorizedRep}}" id="txt_AuthorizedRep" class="W40p txt">
		                    </td>
		                    <td colspan="2">TITLE
		                        <input name="txt_Title" type="text" value="{{$bc->repTitle}}" id="txt_Title" class="W75p txt">
		                    </td>
		                   
		                </tr>
		            </tbody>
		            </table>
		           
		        </div>
		        <div class="ContractLanguage">
		            The parties shall be referred to collectively as (“Parties”).  In addition to the Terms and Conditions included herein, the (“Terms of Use”) as shown on TTP’s website, www.TopTenPercent.com are incorporated herein by reference. This Agreement and the Terms of Use together comprise a binding and enforceable agreement.
		        </div>
		        <div class="ContractLanguage">
		            The Parties hereby agree that the Business Member has been approved for membership into TTP and have met all required selection criteria.  The parties further agree that the Business Member desires to be listed on TTP’s website, www.TopTenPercent.com, in the following category(s)
		        </div>
		        <div class="ContractInputs">
		            <table class="Form W100p">
	                <tbody>
	                	<tr>
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
		                    </td>
		                    <td>
		                        <select name="subCategory" id="ddlSubCategory" 
		                         class="requiredInput">
		                        @foreach ($subcats as $subcat)
									<option value="{{$subcat->id}}"
									@if ($subcat->id == $bc->subCatId)
									selected="selected"
									@endif
									>{{$subcat->name}}</option>
								@endforeach
								</select>
		                    </td>
		                </tr>
	                	<tr>
		                    <td>
		                        <select name="group2" id="ddlGroup2" class="requiredInput" onchange="refreshCategory('2')">
									<option value="">Select a Group</option>
									@foreach ($categories as $group)
									<option value="{{$group->name}}"
									@if ($group->name == $business->ctGroup2)
									selected="selected"
									@endif
									>{{$group->name}}</option>
									@endforeach
								</select>
		                    </td>
		                    <td>
		                        <select name="category2" id="ddlCategory2" class="requiredInput" onchange="refreshSubCategory('2')">
									<option value="">Select a Category</option>
									@foreach ($cats2 as $cat)
									<option value="{{$cat->name}}"
									@if ($cat->id == $business->parentcategoryId2)
									selected="selected"
									@endif
									>{{$cat->name}}</option>
									@endforeach
								</select>
		                    </td>
		                    <td>
		                        <select name="subCategory2" id="ddlSubCategory2" 
		                         class="requiredInput">
		                        @foreach ($subcats2 as $subcat)
									<option value="{{$subcat->id}}"
									@if ($subcat->id == $bc->subCatId2)
									selected="selected"
									@endif
									>{{$subcat->name}}</option>
								@endforeach
								</select>
		                    </td>
		                </tr>
		                <tr>
		                    <td colspan="3">
		                        ADDITIONAL INSTRUCTIONS<br>
		                        <input name="txt_AdditionalInstructions" type="text" id="txt_AdditionalInstructions" class="W100p txt" value="{{$bc->additionalInstructions}}">
		                    </td>
		                </tr>
		            </tbody>
		            </table>
		            <table class="Form W100p" style="width:676px;">
		                <tbody><tr>
		                    <td style="width: 300px;">INITIAL COUPON OR DISCOUNT<br>
		                        <input name="txt_InitialDiscount" type="text" id="txt_InitialDiscount" class="txt" value="{{$bc->initialCoupon}}">
		                    </td>

		                    <td>AVG TRANSACTION AMOUNT<br>
		                        <input name="txt_AvgTransaction" type="text" id="txt_AvgTransaction" class="W100p txt" value="{{$bc->averageTransaction}}">
		                    </td>
		                    <td>AVG DETERMINED VALUE<br>
		                        <input name="txt_AvgValue" type="text" id="txt_AvgValue" class="W100p txt" value="{{$bc->averageDeterminedValue}}">
		                    </td>
		                </tr>
		            </tbody>
		            </table>
		        </div>
		        <div class="ContractLanguage">
		            The Business Member’s Listing will be active on TTP’s website no later than 
		            <input name="txt_StartDate" type="text" id="txt_StartDate" class="datepicker txt" style="width:100px;" value="{{$bc->visibleOnWebsite}}">. 
		            The listing will include the coupon or offer above that the Business Member commits to provide to TTP’s Consumer Members.  Business Member understands and agrees that the order their listing will appear within the specific category(s) above will be ranked with the highest Average Determined Value being listed first.
		        </div>
		        <div class="ContractLanguage">
		            This Business Membership will continue monthly until cancelled by Business Member with 30 days written notice or immediately should the Business Member default on any Terms and Conditions including non-payment. The next payment will be due on  
		            <input name="txt_NextPaymentDate" type="text" id="txt_NextPaymentDate" class="datepicker txt" style="width:100px;" value="{{$bc->paymentDueDate}}">
		             and every payment thereafter will be due on the same date of each month.
		        </div>
		        <div class="ContractInputs">
		           <span class="left">Payment to be authorized by:</span> 
		           <span class="left Box"><input id="ch_AutoCard" type="checkbox" name="ch_AutoCard" checked="checked"></span>  
		           <span class="left"> Auto Draft Credit/Debt Card  <b>OR</b></span>  
		           <span class="left Box"><input id="ch_AutoDraft" type="checkbox" name="ch_AutoDraft"></span> 
		           <span class="left">Auto Bank Draft  <b>OR</b> </span> 
		           <span class="left Box"><input id="ch_FullCash" type="checkbox" name="ch_FullCash"></span>  
		           <span class="left">Paid in Full Cash Basis</span>   
		        </div>
		        
		        
		        <div class="clear" style="padding-top:20px;">
		            The undersigned Business Member has read, acknowledges and accepts the services under this Agreement and all Terms and Conditions herein including the “<a href="#contractContent" style="font-weight:bold; text-decoration:underline;">Additional Terms and Conditions</a>” attached to and made part of this Agreement.
		        </div>

		        <div class="clear ContractLanguage W50p left">
		            
		            <div class="Sig">
		            
					    <script type="text/javascript" src="/scripts/signature/libs/jSignature.min.js"></script>
					    <script type="text/javascript" src="/scripts/signature/app.js"></script>
			            @if ($isNew)
			            <div id="pnlUnSigned">
				
			                <table>
			                <tbody>
			                	<tr>
			                        <td>
			                            Signed  
			                            <img id="reset" src="/Images/clear.png" style="width:20px; height:20px; cursor:pointer;" title="reset signature">
			                        </td>
			                        <td>
			                            <div id="signature" style="border:solid thin silver;"></div>
				                        <div style="display:none;">
			                                <input id="generate" type="button" value="Get Encoded Signature">
			                                <span><input name="hf_EncodedSig1" type="text" value="0" id="hf_EncodedSig1"></span>
			                                <input id="output" type="text">
				                            <input id="strokes" type="text">
			                            </div>
			                        </td>
			                    </tr>
			                    <tr>
			                        <td></td><td style="font-size:8pt;">Authorized Representative of Business Member</td>
			                    </tr>
			                </tbody>
			                </table>
			                <br><br>
			                <table>
			                <tbody>
			                	<tr>
			                        <td>
			                            Signed
			                            <img id="reset2" src="/Images/clear.png" style="width:20px; height:20px; cursor:pointer;" title="reset signature">
			                        </td>
			                        <td>
			                            <div id="signature2" style="border:solid thin silver;"></div>
			                            <div style="display:none;">
			                                <input id="generate2" type="button" value="Get Encoded Signature">
			                                <span><input name="hf_EncodedSig2" type="text" value="0" id="hf_EncodedSig2"></span>
			                                <input id="output2" type="text">
				                            <input id="strokes2" type="text">
			                            </div>                        
			                        </td>
			                    </tr>
			                    <tr>
			                        <td></td>
			                        <td style="font-size:8pt;">Authorized Representative of TTP</td>
			                    </tr>
			                </tbody>
			                </table>
						</div>
						@else
						<div id="pnlSigned">
			                <table>
		                    <tbody>
			                    <tr>
			                        <td>
			                            Signed
			                        </td>
			                        <td>
			                            <img id="imgSig1" src="{{$bc->businessMemberSignature->url}}">
			                        </td>
			                    </tr>
			                    <tr>
			                        <td></td><td style="font-size:8pt;">Authorized Representative of Business Member</td>
			                    </tr>
			                </tbody>
			                </table>
			                <br><br>
			                <table>
		                    <tbody>
		                    	<tr>
			                        <td>
			                            Signed
			                        </td>
			                        <td>
			                            <img id="imgSig2" src="{{$bc->topTenRepSignature->url}}">
			                        </td>
			                    </tr>
			                    <tr>
			                        <td></td><td style="font-size:8pt;">Authorized Representative of TTP</td>
			                    </tr>
			                </tbody>
			                </table>
						</div>
						@endif

		        	</div>
	        	</div>
		        <div class="ContractInputs W50p right" style="margin-top: 20px;">
		        	<table width="315px" border="1" style="margin-bottom:10px;">
		        		<tr align="center">
		        			<td style="border-right:0;">
		        				<input type="checkbox" id="vip" style="float:none;"
		        				@if ($bc->vip == 1)
		        				checked="checked"
		        				@endif
		        				>
		        				<label for="vip" style="display:inline; float:none; color:black; font-weight:bold;">VIP</label>
		        			</td>
		        			<td style="border-left:0;">
		        				<input type="checkbox" id="promo" style="float:none;"
		        				@if ($bc->promo == 1)
		        				checked="checked"
		        				@endif>
		        				<label for="promo" style="display:inline; color:black; font-weight:bold;">Promo</label>
		        			</td>
		        		</tr>
		        	</table>
		            <table class="Fee">
		            <tbody>
		                <tr>
		                    <td style="width: 200px;">
		                        <table>
		                        <tbody>
		                        	<tr>
		                                <td colspan="2" style="border:none; padding-left:15px;">
		                                    Membership Fee
		                                </td>
		                            </tr>
		                            <tr>
		                                <td style="border:none;">
		                                    <span class="Box2" style="color:Black;"><input id="cbxMonthly" type="checkbox" name="cbxMonthly"></span>Monthly&nbsp;&nbsp;&nbsp;&nbsp;
		                                </td>
		                                <td style="border:none;">
		                                    <span class="Box2" style="color:Black;"><input id="cbxAnnualy" type="checkbox" name="cbxAnnualy" checked="checked"></span>Annual
		                                </td>
		                            </tr>
		                        </tbody>
		                        </table>
		                    </td>
		                    <td style="width: 100px;">
		                        $ <input name="txt_MemberFee" type="text" value="{{$bc->membershipFee}}" id="txt_MemberFee" class="txt" style="width:70px;">
		                    </td>
		                </tr>
		                <tr>
		                    <td style="padding-left:15px;">
		                        Activation Fee
		                    </td>
		                    <td>
		                    	$<input name="txt_ActivationFee" type="text" value="{{$bc->fee}}" id="txt_ActivationFee" class="txt" style="width:70px;">
		                    </td>
		                </tr>
		                <tr>
		                    <td style="padding-left:15px;">
		                        Other
		                    </td>
		                    <td>
		                    	<input name="txt_Other" type="text" value="{{$bc->other1}}" id="txt_Other" class="txt" style="width:70px;">
		                	</td>
		                </tr>
		                <tr>
		                    <td style="padding-left:15px;">
		                        Other
		                    </td>
		                    <td>
		                    	<input name="txt_Other2" type="text" value="{{$bc->other2}}" id="txt_Other2" class="txt" style="width:70px;">
		                	</td>
		                </tr>
		                <tr>
		                    <td style="padding-left:15px; padding-bottom:20px; padding-top:20px;">
		                        Total Due Now
		                    </td>
		                    <td>
		                    	$<input name="txt_DueNow" type="text" value="{{$bc->totalDueNow}}" id="txt_DueNow" class="txt" style="width:70px;">
		                	</td>
		                </tr>
		                <tr>
		                    <td style="padding-left:15px; padding-bottom:20px; padding-top:20px;">
		                        On-Going Monthly Fee
		                    </td>
		                    <td>
		                    	$<input name="txt_MonthlyFee" type="text" value="{{$bc->onGoingMonthlyFee}}" id="txt_MonthlyFee" class="txt" style="width:70px;">
		                	</td>
		                </tr>
		                <tr style="display:none;">
		                    <td style="padding-left:15px; padding-bottom:20px; padding-top:20px;">
		                        Note
		                    </td>
		                    <td>
		                        <input name="txt_Note" type="text" id="txt_Note" class="txt" style="width:80px;" value="{{$bc->note}}">
		                    </td>
		                </tr>
		            </tbody>
		            </table>
		        </div>
	        
		        <div class="clear"></div>
		        @if($isNew == 1)
		        <div style="text-align:center; padding-top:50px; border-bottom: solid thin #000;" class="submit">
			        <div id="pnlNewContract">
	                    &nbsp;&nbsp;
	                	<a id="lbSubmit" class="mini-gold" href="javascript:submit()" style="display:inline-block;font-size:25pt;width:200px;">   Submit   </a>
	                    <br><br><br>
					</div>
				</div>
				@elseif ($isNew == 2)
				<div style="text-align:center; padding-top:50px; border-bottom: solid thin #000;" class="submit">
					<div id="pnlNewContract">
	
	                	<a id="lbCancel" class="mini-red" href="/franchise_contract/{{$bc->businessId}}" style="display:inline-block;font-size:25pt;width:200px;">  Cancel  </a>
	                    &nbsp;&nbsp;
	                	<a id="lbSubmit" class="mini-gold" href="javascript:submit()" style="display:inline-block;font-size:25pt;width:200px;">   Submit   </a>
	                    <br><br><br>
					</div>
				</div>
				@else
				<div style="text-align:center; padding-top:50px; border-bottom: solid thin #000;" class="submit">
		            <div id="pnlResign">
			
		                <a id="lbEmail" title="Email Contract to Business Rep" class="mini-gold" href="javascript:sendEmail()" style="display:inline-block;font-size:25pt;width:300px;"> Email Contract </a>
		                &nbsp;&nbsp;
		                <a id="lbResign" class="mini-green" href="/franchise_contract/{{$bc->businessId}}?renew=true" style="display:inline-block;font-size:25pt;width:300px;"> Update / Re-Sign </a>
		                <br><br>
		                <h4>
		                    Last Updated On: <span id="lblLastUpdate">{{$bc->lastUpdated}}</span> (UTC Time)
		                </h4>                
		                <br>
		            
					</div>
		            
		        </div>
		        @endif
		    </div>

		    <div class="ContractBody" id="contractContent">
		    	{!! $contractContent !!}
		    </div>
		</div>
	</div>
</div>

@endsection
@extends('layouts.franchisor_master')

@section('head')

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/js/franchisor/user.js" type="text/javascript"></script>

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

    .ActiveStatus:hover{
    	color: #999;
    	text-decoration: none;
    }
    .ActiveStatus{
    	color: #999;
    }

</style>


@endsection

@section('content')

<div class="mainContentContainer">
    <div class="pgMainContainer">
        
        @include('common.franchisor_navigation')

        <div class="pgContainer" style="padding-bottom:200px;">
            <div class="grid" style="color: #999999; padding-top:0px; padding-bottom:100px;">

	            <div id="pnlUpdate">
	                <div class="titleText">
	                    Active Users (Franchise Admin Only)
	                </div>

                    {!! filter_form($filters, $hasFilter) !!}
	                
	                <div style="margin-top:15px;" id="ratings">
	                	<table cellspacing="0" cellpadding="8" rules="all" id="gvUsers" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
	                		<tr align="left" style="color:White;">
								<th scope="col">
                                    <a onclick="setSortColumn('franchise_activeusers', 'promoCode');" id="lbPromoCode" style="color:White;cursor:pointer;">{{column('promoCode', 'Promo Code', $sort)}}</a>
                                </th><th scope="col">
                                    <a onclick="setSortColumn('franchise_activeusers', 'firstName');" id="lbFirstName" style="color:White;cursor:pointer;">{{column('firstName', 'First Name', $sort)}}</a>
                                </th><th scope="col">
                                    <a onclick="setSortColumn('franchise_activeusers', 'lastName');" id="lbLastName" style="color:White;cursor:pointer;">{{column('lastName', 'Last Name', $sort)}}</a>
                                </th><th scope="col">
                                    <a onclick="setSortColumn('franchise_activeusers', 'email');" id="lbEmail" style="color:White;cursor:pointer;">{{column('email', 'Email', $sort)}}</a>
                                </th><th scope="col">
                                    <a onclick="setSortColumn('franchise_activeusers', 'createdDate');" id="lbCreatedDate" style="color:White;cursor:pointer;">{{column('createdDate', 'Sign Up Date', $sort)}}</a>
                                </th><th scope="col">
                                    <a onclick="setSortColumn('franchise_activeusers', 'activationDate');" id="lbCreatedDate" style="color:White;cursor:pointer;">{{column('activationDate', 'Activated Date', $sort)}}</a>
                                </th>
							</tr>
							@foreach ($users as $user)
							<tr>
								<td>
                                    <span id="lblPromoCode">{{$user->promoCode}}</span>
                                </td><td>
                                    <span id="lblFirstName">{{$user->firstName}}</span>
                                </td><td>
                                    <span id="lbLastName">{{$user->lastName}}</span>
                                </td><td>
                                    <span id="lblEmail">{{$user->email}}</span>
                                </td><td>
                                    <span id="lblActiveDate">{{convertDate($user->createdDate)}}</span>
                                </td><td>
                                    <span id="lblIsActivatedDate">{{convertDate($user->activationDate)}}</span>
							</tr>
							@endforeach
							<tr align="right" style="color:White;font-size:8pt;font-weight:bold;">
				                <td colspan="6">
				                            
				                    <div class="pagingContainer">
				                        
				                        {!! $users->render() !!}
				                                                        
				                    </div>
				                        
				                </td>
				            </tr>
	                	</table>
					</div>
	            </div>

            </div>
            
        </div>
    </div>
</div>

@endsection
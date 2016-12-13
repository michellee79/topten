@extends('layouts.franchisor_master')

@section('head')

<script src="/scripts/jquery-ui.js" type="text/javascript"></script>
<link href="/styles/jq_themes/base/jquery.ui.all.css" rel="stylesheet" type="text/css" />

<link href="/scripts/showLoading/css/showLoading.css" rel="stylesheet" type="text/css">
<script src="/scripts/showLoading/js/jquery.showLoading.js" type="text/javascript"></script>

<script type="text/javascript" src="/scripts/toastMessage/jquery.toastmessage.js"></script>
<link rel="stylesheet" type="text/css" href="/scripts/toastMessage/css/jquery.toastmessage.css" />

<script src="/js/franchisor/complaint.js" type="text/javascript"></script>

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
                    Complaints
                </div>
                <div class="fRight">
			        <a id="linkToBusinessProfile" class="mini-gold" href="/franchise_edit_business/{{$business->id}}">Business Profile</a>
			        <a id="linkToBusinessProfile" class="mini-red" href="/franchise_businesses" style="margin-left:10px;">Business List</a>
			    </div>
			    <div class="clear"></div>
                <div style="margin-top:15px;">
                @if (count($business->complaints) > 0)
					<table cellspacing="0" cellpadding="8" rules="rows" id="gvRatings" style="color:#999999;border-color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
						<tbody><tr align="left" style="color:White;">
							<th scope="col">
                                <a id="lbMemberName" style="color:White;">Member</a>
                            </th>
                            <th scope="col">
                                <a id="lbBusinessName" style="color:White;">Business</a>
                            </th>
                            <th scope="col">
                                <a id="lbRating" style="color:White;">Rating</a>
                            </th>
                            <th scope="col">
                                <a id="lbComment" style="color:White;">Comment</a>
                            </th>
                            <th scope="col">
                                <a id="lbSubmitted" style="color:White;">Submitted</a>
                            </th>
                            <th scope="col">
                                <a id="lbPublished" style="color:White;">Published</a>
                            </th>
                            <th scope="col">
                                <a id="lbIsResolved" style="color:White;">Resolved</a>
                            </th>
                            {{-- Role is admin --}}
                            @if($user->role == 2)
                                <th scope="col">&nbsp;</th>
                                <th scope="col">&nbsp;</th>
                            @endif
						</tr>
						@foreach ($business->complaints as $bc)
						<tr id="trComplaint_{{$bc->id}}">
							<td valign="top">
                                <span id="lblFirstName_{{$bc->id}}">{{$bc->user->firstName}}</span>&nbsp;<span id="lblLastName">{{$bc->user->lastName}}</span>
                            </td>
                            <td valign="top">
                                <span id="lblBusinessName_{{$bc->id}}">{{$business->name}}</span>
                            </td>
                            <td valign="top" style="width:100px;">
                                <img id="imgRating_{{$bc->id}}" src="/Images/Rating_{{$bc->rating}}_of_5.png" style="height:20px;">
                            </td>
                            <td valign="top">
                                <span id="lblComment_{{$bc->id}}">{{$bc->comment}}</span>
                            </td>
                            <td valign="top" style="width:70px;">
                                <span id="lblSubmitted_{{$bc->id}}">{{convertDate($bc->submitted_on)}}</span>
                            </td>
                            <td valign="top" style="width:100px;">
                                <span id="lblPublished_{{$bc->id}}">
                                    @if ($bc->isPublished)
                                        True
                                    @else
                                        False
                                    @endif
                                </span>
                            </td>
                            <td valign="top" style="width:60px;">
                                <span id="lblIsResolved_{{$bc->id}}">
                                @if ($bc->isResolved)
                                True
                                @else
                                False
                                @endif
                                </span>
                            </td>
                            {{-- Role is admin --}}
                            @if ($user->role == 2)
                                <td align="center" valign="top" style="width:60px;">
                                    <a id="lbDelete" class="mini-red" href="javascript:deleteComplaint({{$bc->id}});" style="color:White;">Delete</a>
                                </td>
                                <td align="center" valign="top" style="width:60px;">
                                    <a id="lbEdit" class="mini-gold" href="javascript:showEdit({{$bc->id}});" style="color:White;">Edit</a>
                                </td>
                            @endif
						</tr>
						@endforeach
					</tbody>
					</table>
				@else
				<span id="ContentPlaceHolder1_lblNoRatings" style="color:#B03535;font-weight:bold;">No complaint found</span>
				@endif
				</div>
            </div>

            </div>

        	<div class="fields" style="display: none;">
                <div style="float:left;">
                <p class="titleText" style="padding-bottom: 10px;">
                    Complaint Details</p>
                </div>

                <div>
                    <table width="100%" cellpadding="0" cellspacing="0" style="color: #999999; line-height:2;">
                        <tbody><tr>
                            <td style="width: 150px;">
                                Member Info:
                            </td>
                            <td>
                                <span id="lblMemberName"></span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 150px;">
                                Member Email:
                            </td>
                            <td>
                                <span id="lblEmail"></span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Rating:
                            </td>
                            <td>
                                <div style="float:left;">
                                    <table style="width:200px;">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <input id="rblRatings_1" type="radio" name="rblRatings" value="1">
                                                <label for="rblRatings_1">1</label>
                                            </td>
                                            <td>
                                                <input id="rblRatings_2" type="radio" name="rblRatings" value="2">
                                                <label for="rblRatings_2">2</label>
                                            </td>

                                            <td>
                                                <input id="rblRatings_3" type="radio" name="rblRatings" value="3">
                                                <label for="rblRatings_3">3</label>
                                            </td>
                                            <td>
                                                <input id="rblRatings_4" type="radio" name="rblRatings" value="4">
                                                <label for="rblRatings_4">4</label>
                                            </td>
                                            <td>
                                                <input id="rblRatings_5" type="radio" name="rblRatings" value="5">
                                                <label for="rblRatings_5">5</label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div style="float:left;">
                                    <span style="font-style:italic; font-size:8pt;">
                                        (1 being the lowest and 5 being the highest)
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align:top; padding-top:5px;">
                                Comment:
                            </td>
                            <td style="line-height:1.2; vertical-align:top; padding-top:10px; padding-bottom:15px;">
                                <textarea name="txtComment" rows="5" cols="20" id="txtComment" style="width:600px;"></textarea>&nbsp;
                                <span style="color:#B03535;font-size:8pt;font-weight:bold;visibility:hidden;">Required!</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Status:
                            </td>
                            <td>
                                <input id="cbxIsResolved" type="checkbox" name="cbxIsResolved"><label for="cbxIsResolved">Issue has been resolved</label>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="padding-top:10px;">
                                <input type="submit" name="btnCancel" value=" Cancel " onclick="hideEdit();" id="btnCancel" class="mini-red" style="font-weight:bold;">
                                &nbsp;&nbsp;
                                <input type="submit" name="btnSave" value=" Save " onclick="submit();" id="btnSave" class="mini-gold" style="font-weight:bold;"> 
                            </td>
                        </tr>
                    </tbody></table>
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
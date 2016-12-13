<div>
	<table cellspacing="0" cellpadding="8" rules="rows" id="gvBusiness" style="color:#999999;border-color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
		<tbody>
			<tr align="left" style="color:White;cursor:pointer;">
				<th scope="col">
                    <a onclick="setSortColumn('franchise_businesslist', 'name');" id="lbName" style="color:White;cursor:pointer;">
                    Name
                    @if ($sort == 'name')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-name')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th><th scope="col">
                    <a onclick="setSortColumn('franchise_businesslist', 'city');" id="lbCity" style="color:White;cursor:pointer;">
                    City
                    @if ($sort == 'city')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-city')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th><th scope="col">
                    <a onclick="setSortColumn('franchise_businesslist', 'state');" id="lbState" style="color:White;cursor:pointer;">
                    State
                    @if ($sort == 'state')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-state')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th><th scope="col">
                    <a onclick="setSortColumn('franchise_businesslist', 'zipcode');" id="lbZipcode" style="color:White;cursor:pointer;">
                    Zipcode
                    @if ($sort == 'zipcode')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-zipcode')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th><th scope="col">
                    <a onclick="setSortColumn('franchise_businesslist', 'startDate');" id="lbStartDate" style="color:White;cursor:pointer;">
                    Start Date
                    @if ($sort == 'startDate')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-startDate')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th><th scope="col">&nbsp;</th>
			</tr>

			@foreach($businesses as $business )
			<tr>
				<td>
                    <span id="lblBusinessName">{{$business->name}}</span>
                </td>
                <td>
                    <span id="lblCity">{{$business->city}}</span>
                </td>
                <td>
                    <span id="lblState">{{$business->state}}</span>
                </td>
                <td>
                    <span id="lblZipcode">{{$business->zipcode}}</span>
                </td>
                <td style="width:80px;">
                    <span id="lblStartDate">{{convertDate($business->startDate)}}</span>
                </td>
                <td align="center" style="width:500px;">
                    <a onclick="deleteBusiness({{$business->id}});" id="lbDelete" class="mini-red" style="color:White;cursor:pointer;">Delete</a>
                        &nbsp;
                    <a id="lbContract" class="mini-grey" href="/franchise_contract/{{$business->id}}">Contract</a>
                        &nbsp;
                    <a id="lbEdit" class="mini-gold" href="/franchise_edit_business/{{$business->id}}" style="color:White;cursor:pointer;">Edit</a>
                        &nbsp;
                    <a id="lbComplaints" class="mini-red" href="/franchise_business_complaints/{{$business->id}}" style="color:White;cursor:pointer;">Complaints</a>
                        &nbsp;
                    <a id="lbRatings" class="mini-gold" href="/franchise_business_ratings/{{$business->id}}" style="color:White;cursor:pointer;">Ratings</a>
                        &nbsp;
                    <a id="lbImageGallery" class="mini-grey" href="/franchise_business_images/{{$business->id}}" style="color:White;cursor:pointer;">Images</a>                                                
                </td>
			</tr>
			@endforeach

			<tr align="right" style="color:White;cursor:pointer;font-size:8pt;font-weight:bold;">
				<td colspan="6">
                    <div class="pagingContainer">                                                                           
                
                		{!! $businesses->render() !!}
                
                    <div class="clear"></div>
                    </div>
                </td>
			</tr>
		</tbody></table>
</div>
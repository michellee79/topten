<div>
	<table cellspacing="0" cellpadding="8" rules="all" currentsortdir="DESC" currentsortfield="" id="gvNominations" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
		<tbody>
            <tr align="left" style="color:White;">
                <th scope="col">
                    <a onclick="setSortColumn('admin_nomination', 'businessName');" style="color:White; cursor:pointer;">
                    Business
                    @if ($sort == 'businessName')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-businessName')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_nomination', 'nominationReason');" style="color:White; cursor:pointer;">
                    Reasons
                    @if ($sort == 'nominationReason')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-nominationReason')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_nomination', 'firstName');" style="color:White; cursor:pointer;">
                    Submitted By
                    @if ($sort == 'firstName')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-firstName')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_nomination', 'dateSubmitted');" style="color:White; cursor:pointer;">
                    Date Submitted
                    @if ($sort == 'dateSubmitted')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-dateSubmitted')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_nomination', 'isApproved');" style="color:White; cursor:pointer;">
                    Approved
                    @if ($sort == 'isApproved')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-isApproved')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                    </a>
                </th>
                <th scope="col">&nbsp;</th>
            </tr>
            @foreach($nominations as $nomination)
            <tr id="row_{{$nomination->id}}">
    			<td valign="top" style="width:100px;">                                        
                    <span id="lblBusinessName" style="font-weight:bold;">{{$nomination->businessName}}</span><br>
                    <span id="lblBusinessPhone" style="font-size:8pt;font-style:italic;">{{$nomination->businessPhone}}</span>
                </td>
                <td valign="top" style="width:400px;">                                        
                    {{ $nomination->nominationReason }}
                </td>
                <td valign="top">
                    <span id="lblSubmittedFirstName">{{$nomination->firstName}}</span>&nbsp;<span id="lblSubmittedLastName">{{$nomination->lastName}}</span><br>
                    <a id="hlSubmittedEmail" href="mailto:{{$nomination->email}}" style="color:#666666;font-size:9pt;font-style:italic;text-decoration:underline;">{{ $nomination->email }}</a>
                </td>
                <td valign="top" style="width:60px;">
                    <span id="lblDateSubmitted">{{ convertDate($nomination->dateSubmitted) }}</span>
                </td>
                <td align="center" valign="top" style="width:60px;">
                    <a id="lbStatus" href="javascript:" style="color:White;" onclick="toggleApproval({{$nomination->id}})">
                    @if ($nomination->isApproved)
                    True
                    @else
                    False
                    @endif
                    </a>
                </td>
                <td align="center" valign="top">
                    <a onclick="deleteNomination({{$nomination->id}});" id="DeleteButton" href="javascript:" style="color:White;">Delete</a>
                </td>
    		</tr>
            @endforeach
            <tr align="right" style="color:White;font-size:8pt;font-weight:bold;">
    			<td colspan="6">                                
                    <div class="pagingContainer">                                                                           
                        {!! $nominations->render() !!}
                        <div class="clear"></div>
                    </div>                
                </td>
    		</tr>
    	</tbody>
    </table>
</div>
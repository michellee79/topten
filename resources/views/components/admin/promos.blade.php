<div>
	<table cellspacing="0" cellpadding="8" rules="all" id="gvPromoCodes" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:White; cursor:pointer;">
                <th scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'id');" id="lbID" style="color:White; cursor:pointer;">
                    ID
                    @if ($sort == 'id')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-id')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'code');" id="lbCode" style="color:White; cursor:pointer;">
                    Code
                    @if ($sort == 'code')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-code')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'created');" id="lbCreatedOn" style="color:White; cursor:pointer;">
                    Created On
                    @if ($sort == 'created')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-created')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'assignedTo');" id="lbAssignedTo" style="color:White; cursor:pointer;">
                    Assigned To
                    @if ($sort == 'assignedTo')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-assignedTo')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'requireActivation');" id="lbNeedActivation" style="color:White; cursor:pointer;">
                    Need Activation
                    @if ($sort == 'requireActivation')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-requireActivation')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'isActive');" id="lbStatus" style="color:White; cursor:pointer;">
                    Is Active
                    @if ($sort == 'isActive')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-isActive')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th align="center" scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'totalSignedUp');" id="lbTotalSignedUp" style="color:White; cursor:pointer;">
                    Total Signed Up
                    @if ($sort == 'totalSignedUp')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-totalSignedUp')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th align="center" scope="col">
                    <a onclick="setSortColumn('franchise_promo', 'totalActivated');" id="lbTotalActivated" style="color:White; cursor:pointer;">
                    Total Activated
                    @if ($sort == 'totalActivated')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-totalActivated')
                    <img src="/Images/down.png">
                    @endif
                    </a>
                </th>
                <th scope="col">&nbsp;</th>
            </tr>

            @foreach($promos as $promo)
            <tr>
                <td>
                    <span id="lblID">{{$promo->id}}</span>
                </td>
                <td style="padding:0; text-align:center;">
                    <span id="lblCode">{{ $promo->code }}</span>
                </td>
                <td>
                    <span id="lblCreatedOn">{{ convertDate($promo->created) }}</span>
                </td>
                <td>
                    <a id="Promo_{{$promo->id}}" onclick="showEdit(this);" class="Promo" href="javascript:">{{$promo->assignedTo}}</a>
                </td>
                <td>
                    <a onclick="togglePromoActivation(this, {{$promo->id}});" id="lbChangeActivationStatus" href="javascript:" style="color:White; cursor:pointer;">
                    @if ($promo->requireActivation)
                    True
                    @else
                    False
                    @endif
                    </a>
                </td>
                <td>
                    <a onclick="togglePromoNeedActivation(this, {{$promo->id}});" id="lbStatus" href="javascript:" style="color:White; cursor:pointer;">
                    @if ($promo->isActive)
                    True
                    @else
                    False
                    @endif
                    </a>
                </td>
                <td align="center">
                    <a id="lbViewSignedUpUsers" title="Click to view list of users who has signed up without activating their account" href="/admin_signedup_users/{{$promo->id}}" style="color:#999999;">{{$promo->totalSignedUp}}</a>
                </td>
                <td align="center">
                    <a id="lbViewActiveUsers" title="Click to view list of users who has signed up and activated their account" href="/franchise_active_users/{{$promo->id}}" style="color:#999999;">{{$promo->totalActivated}}</a>
                </td>
                <td align="center">
                    <a onclick="deletePromo(this, {{$promo->id}});" id="DeleteButton" href="javascript:" style="color:White; cursor:pointer;">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
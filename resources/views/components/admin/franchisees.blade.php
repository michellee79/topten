<div>
	<table cellspacing="0" cellpadding="8" rules="rows" id="gvUsers" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:White;cursor:pointer;">
                <th scope="col">
                    <a onclick="setSortColumn('admin_franchisees', 'code');" id="lbID" style="color:White;cursor:pointer;">{{column('code', 'Code', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_franchisees', 'name');" id="lbName" style="color:White;cursor:pointer;">{{column('name', 'Franchisee', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_franchisees', 'city');" id="lbCity" style="color:White;cursor:pointer;">{{column('city', 'City', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_franchisees', 'state');" id="lbState" style="color:White;cursor:pointer;">{{column('state', 'State', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_franchisees', 'created');" id="lbCreatedOn" href="javascript:" style="color:White;cursor:pointer;">{{column('created', 'Created On', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_franchisees', 'isActive');" id="lbStatus" href="javascript:" style="color:White;cursor:pointer;">{{column('isActive', 'Is Active', $sort)}}</a>
                </th><th scope="col">&nbsp;</th>
            </tr>

            @foreach($franchisees as $franchisee)
            <tr id="row_{{$franchisee->id}}">
                <td>
                    <span id="lblFranchiseCode">{{$franchisee->code}}</span>
                </td><td>
                    <span id="lblFranchiseName">{{$franchisee->name}}</span>
                </td><td>
                    <span id="lblCity">{{$franchisee->city}}</span>
                </td><td>
                    <span id="lblState">{{$franchisee->state}}</span>
                </td><td>
                    <span id="lblCreatedOn">{{convertDate($franchisee->created)}}</span>
                </td><td>
                    <a onclick="toggleFranchiseeStatus({{$franchisee->id}});" id="lbStatus_{{$franchisee->id}}" href="javascript:" style="color:White;cursor:pointer;">
                    @if ($franchisee->isActive)
                    True
                    @else
                    False
                    @endif
                    </a>
                </td><td align="center">
                    <a onclick="deleteFranchisee({{$franchisee->id}});" id="lbDelete" class="mini-red" href="javascript:">Delete</a>
                        &nbsp;
                    <a onclick="showEdit({{$franchisee->id}});" id="lbEdit" class="mini-gold" href="javascript:">edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
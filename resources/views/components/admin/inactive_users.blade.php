<div>
	<table cellspacing="0" cellpadding="8" rules="rows" id="gvUsers" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:White;cursor:pointer;">
                <th scope="col">
                    <a onclick="setSortColumn('admin_inactiveusers', 'firstName');" id="lbFirstName" style="color:White;cursor:pointer;">{{column('firstName', 'First Name', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_inactiveusers', 'lastName');" id="lbLastName" style="color:White;cursor:pointer;cursor:pointer;">{{column('lastName', 'Last Name', $sort)}}</a>
                </th>
                <th scope="col" width="400px;">
                    <a onclick="setSortColumn('admin_inactiveusers', 'email');" id="lbEmail" style="color:White;cursor:pointer;cursor:pointer;">{{column('email', 'Email', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_inactiveusers', 'zipcode');" id="lbZipcode" style="color:White;cursor:pointer;cursor:pointer;">{{column('zipcode', 'Zipcode', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_inactiveusers', 'promoCode');" id="lbPromocode" style="color:White;cursor:pointer;">{{column('promoCode', 'Promo Code', $sort)}}</a>
                </th>
                <th>
                    &nbsp;
                </th>
            </tr>

            @foreach($users as $user)
            <tr>
                <td>
                    <span id="lblFirstName">{{$user->firstName}}</span>
                </td>
                <td>
                    <span id="lblLastName">{{$user->lastName}}</span>
                </td>
                <td>
                    <span id="lblEmail">{{$user->email}}</span>
                </td>
                <td>
                    <span id="lblZipcode">{{$user->zipcode}}</span>
                </td>
                <td>
                    <span id="lblCreatedOn">{{$user->promoCode}}</span>
                </td>
                <td>
                    <a onclick="deleteUser({{$user->id}});" id="lbDelete" class="mini-red" href="javascript:" style="color:Black;">Delete</a>
                </td>
            </tr>
            @endforeach
            <tr align="right" style="color:White;cursor:pointer;font-size:8pt;font-weight:bold;">
                <td colspan="7">
                            
                    <div class="pagingContainer">
                        
                        {!! $users->render() !!}
                                                        
                    </div>
                        
                </td>
            </tr>
        </tbody>
    </table>
</div>
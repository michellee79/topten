
<div>
	<table cellspacing="0" cellpadding="8" rules="rows" id="gvUsers" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:White;cursor:pointer;">
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'id');" id="lbID" style="color:White;cursor:pointer;">{{column('id', 'ID', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'promoCode');" id="lbPromo" style="color:White;cursor:pointer;">{{column('promoCode', 'Promo code', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'firstName');" id="lbFirstName" style="color:White;cursor:pointer;">{{column('firstName', 'First Name', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'lastName');" id="lbLastName" style="color:White;cursor:pointer;">{{column('lastName', 'Last Name', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'email');" id="lbEmail" style="color:White;cursor:pointer;">{{column('email', 'Email', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'zipcode');" id="lbZipcode" style="color:White;cursor:pointer;">{{column('zipcode', 'Zipcode', $sort)}}</a>
                </th>
                <th scope="col">
                    <a onclick="setSortColumn('admin_activeusers', 'createdDate');" id="lbCreatedOn" style="color:White;cursor:pointer;">{{column('createdDate', 'Sign Up Date', $sort)}}</a>
                </th>
                <th scope="col">&nbsp;</th>
            </tr>

            @foreach($users as $user)
            <tr>
                <td>
                    <span id="lblID_{{$user->id}}">{{$user->id}}</span>
                </td>
                <td>
                    <span id="lblID_{{$user->id}}">{{$user->promoCode}}</span>
                </td>
                <td>
                    <span id="lblFirstName_{{$user->id}}">{{$user->firstName}}</span>
                </td>
                <td>
                    <span id="lblLastName_{{$user->id}}">{{$user->lastName}}</span>
                </td>
                <td>
                    <span id="lblEmail_{{$user->id}}">{{$user->email}}</span>
                </td>
                <td>
                    <span id="lblZipcode_{{$user->id}}">{{$user->zipcode}}</span>
                </td>
                <td>
                    <span id="lblCreatedOn_{{$user->id}}">{{convertDate($user->createdDate)}}</span>
                </td>
                <td align="center">
                    <a onclick="deleteUser({{$user->id}});" id="lbDelete" class="mini-red" href="javascript:" style="color:Black;">Delete</a>
                        &nbsp;
                    <a onclick="showEdit({{$user->id}});" id="lbEdit" class="mini-gold" href="javascript:" style="color:Black;">Edit</a>
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

@if (count($ratings) > 0)
    <table cellspacing="0" cellpadding="8" rules="rows" id="gvRatings" style="color:#999999;border-color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody><tr align="left" style="color:White;cursor:pointer;">
            <th scope="col">
                <a onclick="setSortColumn('franchise_businessratings', 'firstName');" id="lbMemberName" style="color:White;cursor:pointer;">
                Member
                @if ($sort == 'firstName')
                <img src="/Images/up.png">
                @elseif ($sort == '-firstName')
                <img src="/Images/down.png">
                @endif
                </a>
            </th><th scope="col">
                <a onclick="setSortColumn('franchise_businessratings', 'rating');" id="lbRating" style="color:White;cursor:pointer;">
                Rating
                @if ($sort == 'rating')
                <img src="/Images/up.png">
                @elseif ($sort == '-rating')
                <img src="/Images/down.png">
                @endif
                </a>
            </th><th scope="col">
                <a onclick="setSortColumn('franchise_businessratings', 'comment');" id="lbComment" style="color:White;cursor:pointer;">
                Comment
                @if ($sort == 'comment')
                    <img src="/Images/up.png">
                    @elseif ($sort == '-comment')
                    <img src="/Images/down.png">
                    @endif
                </a>
            </th><th scope="col">
                <a onclick="setSortColumn('franchise_businessratings', 'submitted');" id="lbSubmitted" style="color:White;cursor:pointer;">
                Submitted
                @if ($sort == 'submitted')
                <img src="/Images/up.png">
                @elseif ($sort == '-submitted')
                <img src="/Images/down.png">
                @endif
                </a>
            </th><th scope="col">
                <a onclick="setSortColumn('franchise_businessratings', 'isDisplayed');" id="lbIsActive" title="Selected for main display" style="color:White;cursor:pointer;">
                Is Highlighted
                @if ($sort == 'isDisplayed')
                <img src="/Images/up.png">
                @elseif ($sort == '-isDisplayed')
                <img src="/Images/down.png">
                @endif
                </a>
            </th><th scope="col">&nbsp;</th>
        </tr>
        @foreach ($ratings as $br)
        <tr>
            <td valign="top">
                <span id="lblFirstName_{{$br->id}}">{{$br->user->firstName}}</span>&nbsp;<span id="lblLastName">{{$br->user->lastName}}</span>
            </td><td valign="top" style="width:100px;">
                <img id="imgRating_{{$br->id}}" src="/Images/Rating_{{$br->rating}}_of_5.png" style="height:20px;">
            </td><td valign="top">
                <span id="lblComment_{{$br->id}}">{{$br->comment}}</span>
            </td><td valign="top" style="width:70px;">
                <span id="lblSubmitted_{{$br->id}}">{{convertDate($br->submitted_on)}}</span>
            </td><td valign="top" style="width:100px;">
                @if ($br->isDisplayed == 1)
                <a id="lblIsActive_{{$br->id}}" class="ActiveStatus">True</a>
                @else
                <a id="lblIsActive_{{$br->id}}" class="ActiveStatus" href="javascript:activateRating({{$br->id}});">False</a>
                @endif
            </td><td align="center" valign="top" style="width:120px;">
                @if (Auth::user()->role == 2)
                <a id="lbEdit" class="mini-red" href="javascript:deleteRating({{$br->id}});" style="color:White;cursor:pointer;">Delete</a>
                <a id="lbEdit" class="mini-gold" href="javascript:showEdit({{$br->id}});" style="color:White;cursor:pointer; margin-left:5px;">Edit</a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
@else
    <span id="ContentPlaceHolder1_lblNoRatings" style="color:#B03535;font-weight:bold;">No rating found</span>
@endif
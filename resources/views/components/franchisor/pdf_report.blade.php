<div style="padding:10px;">


@if ($franchisee != NULL)
    <hr>
    <div class="subTitleText">
        <span style="display:none;">
            Franchise ID: <span id="lblFranchiseID">{{ $franchisee->id }}</span><br>
        </span>
        <div class="subTitleText" style="line-height:1.5;">
            <table width="100%">
                <tr>
                    <td width="50%">
                        Franchise Name: <span id="lblFranchiseNumber">{{ $franchisee->code }}</span><br>
                    </td>
                    <td width="50%">
                        &nbsp;
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        Total Local Consumer Members: <span id="lblTotalConsumerCnt">{{ $totalUsers }}</span><br>
                    </td>
                    <td width="50%">
                        National Consumer Members: <span id="lblTotalConsumerCnt">{{ $nationalConsumerTotal }}</span><br>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    @if ($business != NULL)
    <div class="subTitleText" style="line-height:1.5;">
        <hr><hr>
        <table width="100%">
            <tr>
                <td colspan="2" align="center">
                    Business Name : {{$business->name}}
                </td>
            </tr>
            <tr>
                <td>
                    Start Date : {{$start}}
                </td>
                <td>
                    End Date : {{$end}}
                </td>
            </tr>
            <tr>
                <td width="50%">
                    # of Visitors To Main Category of Listing: <span id="lblBusinessViewsInSameCat">{{ $businessViewsInSameCat }}</span>
                </td>
                <td width="50%">
                    # of Page Visits: <span id="lblBusinessProfileViews">{{ $pageVisits }}</span>
                </td>
            </tr>
        </table>
        <hr><hr>
        <table width="100%">
            <tr>
                <td width="50%">
                    # of Hyper Link Clicks To Website: <span id="lblBusinessWebsiteViews">{{ $websiteVisits }}</span>
                </td>
                <td width="50%">
                @if ($coupon != NULL)
                    {{$coupon->title}}<br>
                    # of Downloads: <span id="lblCouponDownloads">{{ $couponDownloads }}</span>
                @else
                    No Coupon
                @endif
                </td>
            </tr>
        </table>
        <br>
        <hr>
        <hr>
        <br>
        <table width="100%">
                <tr>
                    <td width="50%">
                        Franchise Name: <span id="lblFranchiseNumber">{{ $franchisee->code }}</span><br>
                    </td>
                    <td width="50%">
                        
                    </td>
                </tr>
                <tr>
                    <td width="50%">
                        Total Local Consumer Members: <span id="lblTotalConsumerCnt">{{ $totalUsers }}</span><br>
                    </td>
                    <td width="50%">
                        National Consumer Members: <span id="lblTotalConsumerCnt">{{ $nationalConsumerTotal }}</span><br>
                    </td>
                </tr>
                @if ($business != NULL)
                
                @endif
                @foreach ($franchisee->zipcodes as $zipcode)
                <tr>
                    <td>
                    Zipcode {{ $zipcode->zipcode }} - Total Users: {{$zipcode->totalUsers}}
                    </td>
                    <td>
                    Activated users: {{$zipcode->totalActivatedUsers}}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <hr>
    @endif
@endif



    

</div>
<div style="padding:10px;">

<?php
use App\Model\User;
?>

@foreach($franchisees as $franchisee)

    <hr>
    <div class="subTitleText">
        <span style="display:none;">
            Franchise ID: <span id="lblFranchiseID">{{ $franchisee->id }}</span><br>
        </span>
            Franchise Code: <span id="lblFranchiseNumber_{{$franchisee->id}}">{{ $franchisee->code }}</span><br>
            Franchise Name: <span id="lblFranchiseName_{{$franchisee->id}}">{{ $franchisee->name }}</span><br>
            
            @if ($start != 0)
            Business Listings Added: <span id="lblTotalBusinessMembers_0">{{ $franchisee->businesses()->where('isDeleted', 0)->where('dateCreated', '>=', $start)->where('dateCreated', '<=', $end)->count() }}</span><br>

            Total Business Listings: <span id="lblTotalBusinessMembers_0">{{ $franchisee->businesses()->where('isDeleted', 0)->count() }}</span><br>

            Business Listings Deleted: <span id="lblTotalBusinessMembers_0">{{ $franchisee->businesses()->where('isDeleted', 1)->where('dateCreated', '>=', $start)->where('dateCreated', '<=', $end)->count() }}</span><br>
            
            Business Selections: <span id="lblTotalBusinessSelection_{{$franchisee->id}}">{{ $franchisee->businessSelections()->where('dateSubmitted', '>=', $start)->where('dateSubmitted', '<=', $end)->count() }}</span><br>

            Businesses signed as Promo: <span id="lblTotalBusinessSelection_{{$franchisee->id}}">{{ $franchisee->businessVs()->where('promo', 1)->where('signedDate', '>=', $start)->where('signedDate', '<=', $end)->count() }}</span><br>
        
            Total Businesses signed as VIP: <span id="lblTotalBusinessSelection_{{$franchisee->id}}">{{ $franchisee->businessVs()->where('vip', 1)->where('signedDate', '>=', $start)->where('signedDate', '<=', $end)->count() }}</span><br>

            Local Consumer Members added: <span id="lblLocalConsumerMembersAdded_{{$franchisee->id}}">{{ $franchisee->localConsumers()->where('isDeleted', 0)->where('createdDate','>=', $start)->where('createdDate', '<=', $end)->count() }}</span><br>

            Total Local Consumer Members: <span id="lblTotalLocalConsumerMembers_{{$franchisee->id}}">{{ $franchisee->localConsumers()->where('isDeleted', 0)->count() }}</span><br>

            @endif

            @if ($code != '')
                <br>
                <?php
                $activeUsers = User::where('fid', $franchisee->id)->where('isDeleted', 0)->where('isActivated', 1)->where('activationDate', '<=', $end)->where('activationDate', '>=', $start)->count();
                $totalUsers = User::where('fid', $franchisee->id)->where('isDeleted', 0)->where('activationDate', '<=', $end)->where('activationDate', '>=', $start)->count();
                ?>
                @foreach ($franchisee->zipcodes as $zipcode)
                    Total users in Zipcode {{ $zipcode->zipcode }}: {{$zipcode->totalUsers}}, activated users: {{$zipcode->totalActivatedUsers}}<br>
                @endforeach
                <br>
                <br>
                Total Users: <span>{{$totalUsers}}</span><br>
                Total Activated Users: <span>{{$activeUsers}}</span><br>
            @endif

            Total Business Members: <span id="lblTotalBusinessMembers_0">{{ $franchisee->businesses()->where('isDeleted', 0)->count() }}</span><br>
            Total Business Selectionis: <span id="lblTotalBusinessSelection_{{$franchisee->id}}">{{ $franchisee->businessSelections()->count() }}</span><br>
            Total Business Listings Deleted: <span id="lblTotalBusinessMembers_0">{{ $franchisee->businesses()->where('isDeleted', 1)->count() }}</span><br>
            Total Business signed as Promo: <span id="lblTotalBusinessSelection_{{$franchisee->id}}">{{ $franchisee->businessVs()->where('promo', 1)->count() }}</span><br>
            Total Business signed as VIP: <span id="lblTotalBusinessSelection_{{$franchisee->id}}">{{ $franchisee->businessVs()->where('vip', 1)->count() }}</span><br>

    </div>

@endforeach

    <hr>
    <hr>

    <div class="subTitleText" style="line-height:2;">
        National Business Members: <span id="lblTotalBusinessMembers">{{ $businessTotal }}</span>
        <br>
        National Active Consumer Members: <span id="lblTotalConsumerMembers">{{ $consumerTotal }}</span>
    </div>

</div>
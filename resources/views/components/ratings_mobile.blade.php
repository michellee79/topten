@if (count($business->ratings) == 0)
    <div align="center">
        <div style="width: 792px; text-align:left;">
            <span style="color:#B03535;font-weight:bold;">Currently no ratings for this business</span>
        </div>
    </div>
    @else
        @foreach($business->ratings as $rating)
        <div>
            <div style="padding-top:10px; padding-bottom:10px;">
                @if ($rating->rating === NULL)
                    <img src="/Images/Rating_None.png" alt="Business Ratings" style="height:25px;">
                @elseif ($rating->rating == 5)
                    <img src="/Images/Rating_5_of_5.png" alt="Business Ratings" style="height:25px;">
                @elseif ($rating->rating == 4)
                    <img src="/Images/Rating_4_of_5.png" alt="Business Ratings" style="height:25px;">
                @elseif ($rating->rating == 3)
                    <img src="/Images/Rating_3_of_5.png" alt="Business Ratings" style="height:25px;">
                @elseif ($rating->rating == 2)
                    <img src="/Images/Rating_2_of_5.png" alt="Business Ratings" style="height:25px;">
                @elseif ($rating->rating == 1)
                    <img src="/Images/Rating_1_of_5.png" alt="Business Ratings" style="height:25px;">
                @else
                    <img src="/Images/Rating_0_of_5.png" alt="Business Ratings" style="height:25px;">
                @endif
            </div>
            <div style="padding-bottom:10px;">
                <span>
                    {{$rating->comment}}
                </span>
            </div>
            <div style="padding-bottom:10px; font-size:8pt; font-style:italic;">
                Posted on: <span >{{ getTime($rating->submitted_on) }}</span><br>
                by: <span>{{ $rating->user->firstName }}</span>
            </div>
        </div>
    @endforeach
@endif
@if (count($business->ratings) == 0)
    <div align="center">
        <div style="width: 792px; text-align:left;">
            <span style="color:#B03535;font-weight:bold;">Currently no ratings for this business</span>
        </div>
    </div>
    @else
        {{$business->ratings->count()}}
        @foreach($business->ratings as $rating)
        <div class="couponContainer" style="width:100%; padding-top:30px;" align="center">
            <div>
                <img src="/Images/couponTop.png" style="width:800px;">
            </div>
            <div>
                <div style="width: 792px; min-height: 100px; border-left: dotted; border-right: dotted; border-width:3px;">
                    <table width="100%" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td align="left" style="padding-left:10px; width:592px; padding-top:10px; padding-bottom:10px;">
                                <div class="subTitleTextMultiLines" style="padding-bottom:20px; font-size:10pt;">
                                    <span>
                                        {{ $rating->comment }}
                                    </span>
                                </div>
                            </td>
                            <td align="right" style="width:200px; vertical-align:top; padding-top:10px; padding-bottom:10px; padding-right:10px;">
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
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="2" style="padding-right:10px; padding-bottom:10px;">
                                <div class="subTitleTextMultiLines" style="font-style:italic; font-size:8pt; text-align:right;">
                                    Posted on: <span >{{ getTime($rating->submitted_on) }}</span><br>
                                    by: <span>{{ $rating->user->firstName }}</span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
            <div>
                <img src="/Images/couponBottom.png" style="width:800px;">
            </div>
        </div>
    @endforeach
@endif
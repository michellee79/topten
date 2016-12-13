<div>
	<table cellspacing="0" cellpadding="10" rules="all" id="gvImages" style="color:#999999;border-width:1px;border-style:solid;width:100%;border-collapse:collapse;">
		<tbody>
			<tr align="left" style="color:White;">
            <th scope="col">
                <a onclick="setSortColumn('franchise_imagelist', 'category')" id="lbCategory" style="color:White;cursor:pointer;">
                Category
                @if ($sort == 'category')
                <img src="/Images/up.png">
                @elseif ($sort == '-category')
                <img src="/Images/down.png">
                @endif
                </a>
            </th>
            <th scope="col">
                <span id="lbImage" style="color:White;">Image</span>
            </th>
            <th scope="col">
                <a onclick="setSortColumn('franchise_imagelist', 'added');" id="lbAddedOn" style="color:White;cursor:pointer;">
                Date Added
                @if ($sort == 'added')
                <img src="/Images/up.png">
                @elseif ($sort == '-added')
                <img src="/Images/down.png">
                @endif
                </a>
            </th>
            <th scope="col">&nbsp;</th>
        </tr>

			@foreach($images as $image )
			<tr>
                <td style="width:150px;">
                    <span id="lblCategory">{{$image->category}}</span>
                </td>
                <td style="width:600px;">
                    <img id="Image" src="/{{ $image->url }}" style="height:100px;">                                    
                    
                </td>
                <td style="width:100px;">
                    <span id="lblAddedOn">{{ convertDate($image->added) }}</span>
                </td>
                <td align="center" style="width:80px;">
                    <a id="DeleteButton" class="btn btn-danger" href="javascript:" onclick="deleteImage({{$image->id}});">Delete</a>
                </td>
            </tr>
			@endforeach

			<tr align="right" style="color:White;font-size:8pt;font-weight:bold;">
				<td colspan="6">
                    <div class="pagingContainer">                                                                           
                
                		{!! $images->render() !!}
                
                    <div class="clear"></div>
                    </div>
                </td>
			</tr>
		</tbody></table>
</div>
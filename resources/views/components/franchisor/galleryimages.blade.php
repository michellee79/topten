<div>
@if (count($business->images) > 0)
    
    @foreach ($business->images as $img)
        <div style="float:left; padding-right:20px; min-height:150px;">
            <div style="position:relative;" class="image">
                <img src="/{{$img->url}}" style="width:150px;">
                <div style="position:absolute; top:4px; right: 0; width:100%; height:100%; display:none;" class="delete">
                    <a class="btn-small btn-danger" href="javascript:deleteImage({{$img->id}});">Remove</a>
                </div>
            </div>
        </div>
    @endforeach
    
@else
    <span id="lblNoImages" style="color:#B03535;font-weight:bold;">No images found</span>
@endif
</div>
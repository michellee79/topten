
<div style="height:600px; overflow-y:scroll;">
	<table cellspacing="0" cellpadding="8" rules="all" id="gvPromoCodes" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>

            @foreach($subcats as $subcat)
            <tr>
                <td>
                    <input type="radio" name="sub" id="sub_{{$subcat->id}}" value="{{$subcat->id}}" onclick="catSelChange(3, {{$subcat->id}})" />
                    <a class="item" href="javascript:catSelChange(3, {{$subcat->id}})">{{$subcat->subCategory}}</a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="float:right;">
    <a id="AddSub" class="btn btn-primary" style="font-weight: bold; cursor: pointer;" onclick="showAdd(3);">
        Add
    </a>
    <a id="EditSub" class="btn btn-warning" style="font-weight: bold; cursor: pointer; margin-left:10px;" onclick="showEdit(3);">
        Edit
    </a>
    <a id="DeleteSub" class="btn btn-danger" style="font-weight: bold; cursor: pointer; margin-left:10px; margin-right:10px;" onclick="deleteCategory();">
        Delete
    </a>
</div>
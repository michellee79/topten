
<div style="height:600px; overflow-y:scroll;">
	<table cellspacing="0" cellpadding="8" rules="all" id="gvPromoCodes" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            @foreach($cats as $cat)
            <tr>
                <td>
                    <input type="radio" name="cat" id="cat_{{$cat->id}}" value="{{$cat->id}}" onclick="catSelChange(2, {{$cat->id}})" />
                    <a class="item" onclick="catSelChange(2, {{$cat->id}})">{{$cat->category}}</a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div style="float:right;">
    <a id="AddCategory" class="btn btn-primary" style="font-weight: bold; cursor: pointer;" onclick="showAdd(2);">
        Add
    </a>
    <a id="EditCategory" class="btn btn-warning" style="font-weight: bold; cursor: pointer; margin-left:10px;" onclick="showEdit(2);">
        Edit
    </a>
    <a id="DeleteCategory" class="btn btn-danger" style="font-weight: bold; cursor: pointer; margin-left:10px; margin-right:10px;" onclick="deleteCategory();">
        Delete
    </a>
</div>
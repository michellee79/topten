
<div style="height:600px; overflow-y:scroll;">
	<table cellspacing="0" cellpadding="8" rules="all" id="gvPromoCodes" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>
                    <input type="radio" name="group" id="group_{{$group->id}}" value="{{$group->id}}" onclick="catSelChange(1, {{$group->id}});" />
                    <a class="item" onclick="catSelChange(1, {{$group->id}})">{{$group->ctGroup}}</a>
                </td>
                
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<div style="float:right; margin-top:10px;">
    <a id="AddGroup" class="btn btn-primary" style="font-weight: bold; cursor: pointer;" onclick="showAdd(1);">
        Add
    </a>
    <a id="EditGroup" class="btn btn-warning" style="font-weight: bold; cursor: pointer; margin-left:10px;" onclick="showEdit(1);">
        Edit
    </a>
    <a id="DeleteGroup" class="btn btn-danger" style="font-weight: bold; cursor: pointer; margin-left:10px; margin-right:10px;" onclick="deleteCategory();">
        Delete
    </a>
</div>
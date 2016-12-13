
<div>
	<table cellspacing="0" cellpadding="8" rules="all" id="gvBusinesses" style="color:#999999;border-width:0px;width:100%;border-collapse:collapse;">
        <tbody>
            <tr align="left" style="color:White;">
                <th scope="col">
                    <a onclick="setSortColumn('admin_businessselectionlist', 'id');" id="lbID" style="color:White;cursor:pointer;">{{column('id', 'ID', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_businessselectionlist', 'businessName');" id="lbBusinessName" style="color:White;cursor:pointer;">{{column('businessName', 'Business Name', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_businessselectionlist', 'consumerNominated');" style="color:White;cursor:pointer;">{{column('consumerNominated', 'Consumer Nominated', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_businessselectionlist', 'businessContract');" id="lbBusinessContact" style="color:White;cursor:pointer;">{{column('businessContract', 'Contract', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_businessselectionlist', 'passed');" id="lbPassed" style="color:White;cursor:pointer;">{{column('passed', 'Passed', $sort)}}</a>
                </th><th scope="col">
                    <a onclick="setSortColumn('admin_businessselectionlist', 'dateSubmitted');" id="lbDateSubmitted" style="color:White;cursor:pointer;">{{column('dateSubmitted', 'Submitted Date', $sort)}}</a>
                </th><th scope="col">&nbsp;</th>
            </tr>

            @foreach($businessSelections as $businessSelection)
            <tr>
                <td>
                    <span id="lblID">{{$businessSelection->id}}</span>
                </td><td>
                    <span id="lblBusinessName">{{$businessSelection->businessName}}</span>
                </td><td>
                    
                    <span id="lblConsumerNominated">{{$businessSelection->consumerNominated}}</span>
                </td><td>
                    <span id="lblBusinessContact">{{$businessSelection->businessContact}}</span>
                </td><td>
                    <span id="lblPassed">
                    @if($businessSelection->passed)
                    True
                    @else
                    False
                    @endif
                    </span>
                </td>
                <td>
                    <span id="lblDateSubmitted">{{convertDate($businessSelection->dateSubmitted)}}</span>
                </td>
                <td align="center">
                    <a id="linkToViewDetail" href="/business-criteria/{{$businessSelection->id}}" target="_blank" style="color:White;">
                        View
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
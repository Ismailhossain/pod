
<table width="100%" cellpadding="2" style="font-size: 11px;">
    <tr>
        <td><h4>ISO 22000.2005</h4></td>
        <td><h4>BGS Trading Sdn Bhd</h4></td>
        <td><h4>Issue No: OPRP-MR-PASS</h4></td>
    </tr>
</table><br/><br/>

<table border="1px" cellpadding="2px">
    <tr >
        <th  data-field="dn" >Total Document Number :</th>
        <td > {{$total}} </td>
    </tr>
    <tr >
        <th  data-field="dn" >Driver Name :</th>
        <td >{{$entriesRequest->Name}}</td>
    </tr>

    <tr >
        <th  data-field="dn" >Driver Code :</th>
        <td >{{$entriesRequest->Driver_Code}} </td>
    </tr>
    <tr >
        <th  data-field="dn" >First Assistant Name :</th>
        <td >{{$entriesRequest->Assistant_Name}} </td>
    </tr>
    <tr >
        <th  data-field="dn" >Second Assistant Name :</th>
        <td >{{$entriesRequest->Assistant2_Name}} </td>
    </tr>
    <tr >
        <th  data-field="in">Document No :</th>
        <td >
            <table width="100%" cellpadding="-1" style="font-size: 10px;">
                <tr>
                    <td  align="center" style="">{{$invoices}}</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr >
        <th  data-field="dn" >Vehicle No :</th>
        <td >{{$entriesRequest->Vehicle_No}} </td>
    </tr>
    <tr >
        <th  data-field="dn" >Report Date :</th>
        <td >{{$timestr}} </td>
    </tr>


</table><br/><br/>
<table border="1px" cellpadding="2px">
    <tbody >
    <tr >
    <th  data-field="dn" ><h5>Release Criteria Question : </h5></th>
    <td ><h5>Release Criteria Answer : </h5></td>
    </tr>
    @foreach($entriesAnswer as $ID)
        <tr >
            <td >{{$ID->Question_Name}} </td>
            <td >{{$ID->Question_ANS}} </td>
        </tr>
    @endforeach
    </tbody>


</table><br/><br/>
<table width="100%" cellpadding="2" style="font-size: 11px;">
    <tr><td colspan="5"></td></tr>
    <tr><td colspan="5"></td></tr>
    <tr style="text-align:left">
        <td width="40%" style="text-align:left;"><br><span style="font-size: 11px; text-align:left;">Checked By :</span>
            <br><b>{{$entriesRequest->Checker_Name}}</b>
        </td>
        <td colspan="1"></td>
        <td  width="40%" style="text-align:left;"><br><b>...............................................</b>
            <br><span style="font-size: 11px; text-align:left;">Approved for Released By </span>
        </td>
    </tr>

</table><br/><br/>
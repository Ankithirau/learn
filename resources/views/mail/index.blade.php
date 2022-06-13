<p>Hi {{$details['organization_name']}},</p><br>
<table border="1" cellpadding="0" cellspacing="0" align="center" width="100%">
  <thead style="background-color: #5367FC;">
    <tr>
      <td align="center"><b>S.No.</b></td>
      <td align="center"><b>Employee Code</b></td>
      <td align="center"><b>Password</b></td>
    </tr>
  </thead>
  <tbody>
    @if(!empty($details['employees']))
    @php
    $i = 0;
    @endphp
    @foreach($details['employees'] as $res)
    <tr>
      <td align="center">{{$i=$i+1}}</td>
      <td align="center">{{$res['EmployeeCode']}}</td>
      <td align="center">{{$res['password']}}</td>
    </tr>
    @endforeach
    @endif
  </tbody>
</table>
<p>Thank & Regards<br>
  <i><b>Travel Master</b></i>
</p>
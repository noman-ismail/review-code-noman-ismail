@php
  $cities_collection = collect($cities);
  $userss = collect($admin_users);
  $date_from = request('date_from');
  $date_to = request('date_to');
  // $date_dstring = (!empty($date_from) and !empty($date_to)) ? "Date From ".$date_from." To ".$date_to : "";
  $date_dstring = "";
@endphp
<!DOCTYPE html>
<html>
<head>
	<title></title>
    <style>
      body{
        background-color: none;
      }
    </style>
</head>
<body>
  <div  style="width: 100%; ">
  <div  style="text-align: center; width: inherit;">
    <h4>Fund Requests Report | {{ get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type) }}</h4>
  </div>
  <div style="width: inherit;">
    <table style="border: 1px solid black; width: inherit;border-collapse: collapse;">
      <thead style="font-size: 12px; width: 100%; border-bottom: 1px solid black">
        <tr>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">#</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Request From</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Username</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Amount</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Date</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Status</th>
        </tr>
      </thead>
      <tbody style="font-size: 10px;">
        @if(!empty($record))
        @foreach($record as $key => $value)
          @php
            $_c = $cities_collection->where('id',$value->district)->first();
            $_u = $userss->where('id',$value->user_id)->first();
          @endphp
         <tr>
           <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ ++$key }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;">{{ ($_c) ? $_c->name : "" }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;">{{ ($_u) ? $_u->name : "" }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ $value->amount }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ (!empty($value->date))?date('d/m/Y',strtotime($value->date)):"" }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ ucfirst($value->status) }}</td>
         </tr>
        @endforeach
        @else
          <tr>
            <td  colspan="6" style="text-align: center;">There is no record</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
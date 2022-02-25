@php
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
    <h4>Budget Requests Report | {{ get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type) }}</h4>
  </div>
  <div style="width: inherit;">
    <table style="border: 1px solid black; width: inherit;border-collapse: collapse;">
      <thead style="font-size: 12px; width: 100%; border-bottom: 1px solid black">
        <tr>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">#</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Request From</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Title</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Amount</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Due Date</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Request Date</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Status</th>
        </tr>
      </thead>
      <tbody style="font-size: 10px;">
        @if(!empty($record))
        @foreach($record as $key => $value)
         <tr>
           <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ ++$key }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ get_DeptName($value->reqst_from , $value->type) }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;">{{ $value->title }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ $value->amount }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ (!empty($value->due_date))?date('d/m/Y',strtotime($value->due_date)):"" }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ (!empty($value->created_at))?date('d/m/Y',strtotime($value->created_at)):"" }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;">{{ $value->status }}</td>
         </tr>
        @endforeach
        @else
          <tr>
            <td  colspan="7" style="text-align: center;">There is no record</td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
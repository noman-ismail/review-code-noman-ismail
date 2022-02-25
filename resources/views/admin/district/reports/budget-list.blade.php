@php
  $province_collection = collect($province);
  $date_from = request('date_from');
  $date_to = request('date_to');
  // $date_dstring = (!empty($date_from) and !empty($date_to)) ? "Date From ".$date_from." To ".$date_to : "";
  $date_dstring = "";
@endphp
@php
  if(request()->has('pending') and request('pending') == 'true'){
    $vll = 'Pending';
  }elseif(request()->has('approved') and request('approved') == 'true'){
    $vll = 'Approved';
  }elseif(request()->has('delivered') and request('delivered') == 'true'){
    $vll = 'Delivered';
  }elseif(request()->has('rejected') and request('rejected') == 'true'){
    $vll = 'Rejected';
  }else{
    $vll = '';
  }
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
    <h4>{{ $vll }} Budget List Report | {{ get_DeptName(auth('admin')->user()->dept_id,auth('admin')->user()->type) }}</h4>
  </div>
  <div style="width: inherit;">
    <table style="border: 1px solid black; width: inherit;border-collapse: collapse;">
      <thead style="font-size: 12px; width: 100%; border-bottom: 1px solid black">
        <tr>
          <th scope="col" style="border-right:1px solid black;text-align:center;">#</th>
          <th scope="col" style="border-right:1px solid black;text-align:center;">Title</th>
          <th scope="col" style="border-right:1px solid black;text-align:center;">Amount</th>
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Status</th>
          @if (auth('admin')->user()->type == 'national')
            <th scope="col" style="border-right: 1px solid black;text-align: center;">Request To</th>
          @endif
          <th scope="col" style="border-right: 1px solid black;text-align: center;">Request Date</th>
        </tr>
      </thead>
      <tbody style="font-size: 10px;">
        @if(count($record) > 0)
        @foreach($record as $key => $value)
         <tr>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ ++$key }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ $value->title }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ $value->amount }}</td>
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ $value->status }}</td>
            @if (auth('admin')->user()->type == 'national')
              @php
                $provvv = $province_collection->where('id',$value->reqst_to)->first();
              @endphp
              <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ ($provvv) ? $provvv->name : "" }}</td>
            @endif
            <td style="border-right: 1px solid black; border-bottom: 1px solid black; padding:5px;text-align: center;">{{ date('d/m/Y',strtotime($value->created_at)) }}</td>
         </tr>
        @endforeach
        @else
          <tr>
            @if (auth('admin')->user()->type == 'national')
              <td  colspan="6" style="text-align: center;">There is no record</td>
            @else
              <td  colspan="5" style="text-align: center;">There is no record</td>
            @endif
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
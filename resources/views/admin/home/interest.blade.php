@include( 'admin.layout.header' )
@php
tiny_editor();
@endphp
<div class="body-content">
	<div class="row">
		<div class="col-md-10 col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Skills & Rewards</h6>
						</div>
						<div class="text-right">
							<div class="actions">
								<a href="{{url('/'.admin.'/homepage')}}" class="btn {{ Request::segment(2)=='homepage'  &&  Request::segment(3)==''  ? 'btn-inverse' : 'btn-info' }} pull-right">Home Meta</a>
								<a href="{{url('/'.admin.'/homepage/grants')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='grants'  ? 'btn-inverse' : 'btn-info' }} pull-right">Grants</a>
								<a href="{{url('/'.admin.'/homepage/interest')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='interest'  ? 'btn-inverse' : 'btn-info' }} pull-right">Success Score</a>
								<a href="{{url('/'.admin.'/homepage/initiatives')}}" class="btn {{ Request::segment(2)=='homepage'  && Request::segment(3)=='initiatives'  ? 'btn-inverse' : 'btn-info' }} pull-right">Initiatives</a>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
		          @if (Session::has('flash_message'))
		          <div class="alert alert-success alert-block">
		            <button type="button" class="close" data-dismiss="alert">×</button>
		            <strong>{!! Session('flash_message') !!}</strong>
		          </div>
		          @endif
		          @if (count($errors) > 0)
		          <div class="alert alert-danger">
		            <strong>Whoops!</strong> There were some problems with your input.<br><br>
		            <ul>
		              @foreach ($errors->all() as $error)
		              <li>{{ $error }}</li>
		              @endforeach
		            </ul>
		          </div>
		          @endif
		          <form method="POST" action="/{{ admin }}/homepage/interest" enctype="multipart/form-data">
		            @csrf
		            <div class="row">
		              <div class="col-lg-12 col-md-12">
		                @php
		                $res   = ($data->interest  !="" )? json_decode($data->interest , true) : array();
		                @endphp
		                <input type="hidden" name="id" value="{{ isset($data)?$data->id:''}}">
		                <div class="form-group">
		                  <label class="font-weight-600">Heading</label>
		                  <input type="text" name="m_heading" class="form-control" value="{{ isset($res['m_heading'])?$res['m_heading']:''}}">
		                </div>
		                <div class="interest">
		                  <div class="form-rows">
		                    <table class="table table-bordered">
		                      <thead>
		                        <tr>
		                          <th>#</th>
		                          <th>Name</th>
		                          <th>Manual Counter <span style="font-size:8px">Priority</span></th>
		                          <th>Auto Counter</th>
		                          <th>
		                          	<span class="float-left">Icon</span>
		                          	<span style="font-size: 12px" class="float-right">
		                          		<a href="{{ route('icons') }}" target="_blank">Click Here for Help</a>
		                          	</span>
		                          </th>
		                        </tr>
		                      </thead>
		                      <tbody class="rec">
		                        @php
			                        $res = isset($res["interest"]) ? $res["interest"] : array();
			                        $rev_count = (count($res)==0) ? 0 : count($res) - 1;
			                        for ($n=0; $n <=$rev_count; $n++){
				                        $name = (isset($res[$n]["name"])) ? $res[$n]["name"]: "";
				                        $count = (isset($res[$n]["count"])) ? $res[$n]["count"]: "";
				                        $icon = (isset($res[$n]["icon"])) ? $res[$n]["icon"]: "";
				                        $c_count = 0;
				                        if($name == 'Provinces'){
				                        	$c_count = DB::table('users')->where('status','approved')->distinct()->count('province');
				                        }elseif($name == 'Districts'){
				                        	$c_count = DB::table('users')->where('status','approved')->distinct()->count('district');
				                        }elseif($name == 'Members'){
				                        	$c_count = DB::table('users')->where('status','approved')->count();     	
				                        }elseif($name == 'Events'){
				                        	$c_count = DB::table('event')->count(); 
				                        }elseif($name == 'Grants'){
				                        	$c_count = DB::table('death_claims')->where('status','delivered')->count();
				                        }elseif($name == 'Pension Calculations'){
				                        	$c_count = 0;
				                        }elseif($name == 'Pension Paper'){
				                        	$c_count = 0;
				                        }elseif($name == 'Notifications'){
				                        	$c_count = DB::table('downloads')->where(['type'=>'govt-notification'])->count();
				                        }
		                        @endphp
		                        <tr>
		                          <td>{{ $n+1 }}</td>
		                          <td>
		                          	<div class="form-group m-0">
		                            <input type="text" name="name[]" placeholder="Name" class="form-control" value="{{ $name }}" readonly />
		                            <div class="text-danger"> </div>
		                          </div>
		                        </td>
		                        <td style="width: 20%;">
		                        	<div class="form-group m-0">
		                            <input type="text" name="count[]" placeholder="0" class="form-control" value="{{ $count }}"/>
		                            <div class="text-danger"> </div>
		                          </div>
		                        </td>
		                        <td style="width: 20%;">
		                        	<div class="form-group m-0">
		                            <input type="text" name="autocount[]" placeholder="0" class="form-control" value="{{ $c_count }}" readonly />
		                            <div class="text-danger"> </div>
		                          </div>
		                        </td>
		                        <td>
		                          <div class="form-group m-0">
		                            <input type="text" name="icon[]" placeholder="eg: <i class='icon-user'></i> " class="form-control" value="{{ $icon }}"/>
		                          </div>
		                        </td>
		                        {{-- <td class="text-center"> <i class="fa fa-2x fa-times text-danger clear-item mx-auto my-auto"></i></td> --}}
		                      </tr>
		                      @php
		                      }
		                      @endphp
		                    </tbody>
		                  </table>
		                  {{-- <div style="text-align:right;">
		                    <a href="" class="btn btn-success add-interst text-white"><i class="fa fa-plus"></i></a>
		                  </div> --}}
		                  
		                </div>
		              </div>
		              <div class="form-group col-lg-12 pr-0">
		                <br>
		                  <button type="submit" name="submit" value="publish" class="btn btn-info float-right">Save Record </button>
		              </div>
		            </div>
		          </div>
		        </div>
			</div>
		</div>
	</div>
	@include('admin.layout.footer')
	
<script>
$(document).ready(function() {
$(".add-interst").click(function() {
var html_obj = $(".rec tr").first().clone();
var ln = $(".rec tr").length;
$(html_obj).find("input").each(function(){
$(this).attr("value", "");
});
$(html_obj).find("textarea").each(function(){
$(this).text("");
});
html_obj.find("td:first-child").text(parseInt(ln)+1);
$(".interest .rec").append("<tr>"+html_obj.html()+"</tr>");
return false;
});
$(document).on("click", ".clear-item", function() {
var v = window.confirm("Do you want to delete data?");
if (v) {
$(this).closest("tr").remove();
}
});
});
</script>
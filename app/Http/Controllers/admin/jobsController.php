<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Jobs;
use Illuminate\Database\Eloquent\Relations\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Auth;
class jobsController extends Controller
{

    public function addJobs(){
        if(request()->isMethod('post')){
             $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
      request()->validate([
            'title' => ['required','max:60'],
            'meta_title' => ['required'],
            'meta_description' => ['required'],
            'meta_tags' => ['required'],
            'content' => ['required'],
            'category' => ['required'],
            'job_type' => ['required'],
            'job_shift' => ['required'],
            'organization' => ['required'],
            'slug' => ['required'],
            'due_date' => ['required'],
            'published_by' => ['nullable','max:50'],
            'vacancies' => ['nullable','numeric','min:1','max:10000000'],
        ]);
       // dd(request()->all());
        // if(validate_data(request('due_date')))
        $schema= (request()->has('schema'))?request('schema'):array();
        $type= request('type');
            $schm = array();
            for($a = 0; $a < count($schema); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            }  
        $schema= (json_encode($schm));
        $category = request('category') ;
        $job_type = (is_array(request('job_type'))) ? implode(",", request('job_type')) : request('job_type');
        $job_shift = (is_array(request('job_shift'))) ? implode(",", request('job_shift')) : request('job_shift');
        //dd(request('due_date'));
        if (request("due_date") !="" and validate_date(request('due_date'))) {
            $date = explode("/", request('due_date'));
            $date = $date[2]."-".$date[1]."-".$date[0];
        }else{
            $date = Null;
        }
        if (request()->has("submit")) {
            $data = array();
            $data["title"] = request('title');
            $data["slug"] = Str::slug(request( 'slug' ), '-');
            $data["meta_title"] = request('meta_title');
            $data["meta_description"] = request('meta_description');
            $data["meta_tags"] = request('meta_tags');
            $data["cover"] = request('cover-image');
            $data["og_image"] = request('og-image');
            $data["vacancies"] = request('vacancies');
            $data["official_link"] = request('official_link');
            $data["job_type"] = $job_type;
            $data["job_shift"] = $job_shift;
            $data["category"] = request('category');
            $data["status"] = request('submit');
            if ($user->type == "district") {
                $data["user_type"] = request('user_type');
                $data["district"] = request('district');
                $data["province"] = request('province'); 
            }elseif ($user->type == "province") {
                $data["user_type"] = request('user_type');
                $data["district"] = request('district');
                $data["province"] = request('province'); 
            }elseif ($user->type == "national") {
                $data["user_type"] = request('user_type');
            }elseif($user->type == "admin"){
                $data["user_type"] = request('user_type');
            }           
            $data["published_by"] = request('published_by');
            $data["organization"] = request('organization');
            $data["content"] = request('content');
            $data["due_date"] = $date;
            $data["microdata"] = $schema;
           // dd($data);
            if(request()->has('id')){

            DB::table('jobs')->where('id', request('id'))->update($data);
            return back()->with('flash_message', 'Job Record Updated Successfully');
        }else{
            $id = DB::table('jobs')->insertGetId($data);
            return redirect(route('jobs-create').'?edit='.$id)->with('success','Job Record Inserted Successfully');
            }
        }
    }else{
        if(request('edit')){
                $id = request('edit');
                $data = DB::table('jobs')->where('id',$id)->first();
                return view('admin.district.job.jobs',compact('data'));
            }
        if(request('delete')){
                $id = request('delete');
                $data = DB::table('jobs')->where('id',$id)->delete();
                return back()->with('flash_message','Job Post is deleted Successfully');
            }
        if ( request( 'publish' ) ) {
            $id = request( 'publish' );
            DB::table( 'jobs' )->where( 'id', $id )->update( [ 'status' => 'publish' ] );
            return redirect( '/' . admin . '/jobs/list')->with( 'flash_message', 'Job Post Status is Changed To Publish Successfully' );
        }
        if ( request( 'draft' ) ) {
            $id = request( 'draft' );
            DB::table( 'jobs' )->where( 'id', $id )->update( [ 'status' => 'draft' ] );
            return redirect( '/' . admin . '/jobs/list')->with( 'flash_message2', 'Job Post Status is Changed To Draft Successfully' );
        }
       return view('admin.district.job.jobs');  
   }
    }


    public function jobsList(){
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        $user_type = Auth::user()->type;
        $dept_id = Auth::user()->dept_id;
        if ($user_type == "admin") {
            $data = jobs::orderBy('id', 'DESC')->paginate(10);
        }elseif ($user_type == "district") {
            $data = jobs::where(['user_type' => $user_type , 'district' => $dept_id ])->paginate(10);
        }elseif ($user_type == "province") {
            $data = jobs::where(['province' => $dept_id ])->paginate(10);
        }elseif ($user_type == "national") {
            $data = jobs::where(['user_type' => $user_type ])->paginate(10);
        }else{
            if (request()->has( "st" )) {
                $st = request('st');
                $data = jobs::where('status' , '=' , $st)->where('district',$user->dept_id)->orderBy('id', 'DESC')->paginate(10);
            }
        }
        
        return view('admin.district.job.jobs_list' ,compact('data'));
    }
 
    public function jobCategory() {
        if (request('edit')) {
            $id = request('edit');
            $edit = jobcats::where('id', $id)->first();
            $cats = jobcats::all()->sortBy('tb_order');
            return view('admin.district.job.jobcats', compact('edit', 'cats'));
        }
        if (request('del')) {
            $id = request('del');
            $delete = jobcats::where('id', $id)->first();
            $delete->delete();
            return back()->with('flash_message', 'Category is Deleted successfully');
        }
        $edit = "";
        $cats = jobcats::all()->sortBy('tb_order');

        return view('admin.district.job.jobcats', compact('cats', 'edit'));
    }
    
}

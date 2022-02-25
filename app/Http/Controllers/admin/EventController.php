<?php 

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    
	public function _new()
    {   
         $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        if(request('edit')){
            $id = request('edit');
            $data = Event::where('id',$id)->first();
            return view('admin.district.event.create-event',compact('data'));
        }	
        if(request('delete')){
                $id = request('delete');
                $data = DB::table('event')->where('id',$id)->delete();
                return back()->with('flash_message','Record is deleted Successfully');
            }   	
    	if (request()->has("submit")) {
            //dd(request()->all());
            if (request("date") !="") {
                $date = explode("/", request('date'));
                $date = $date[2]."-".$date[1]."-".$date[0];
            }else{
                $date = Null;
            }
            
    		request()->validate([
            'meta_title' => ['required','max:250'],
            'meta_description' => ['required','max:250'],
            'meta_tags' => ['required','max:150'],
            'title' => ['required','max:250'],
            'slug' => ['required','max:300'],
            'address' => ['required','max:1000'],
            'time' => ['required','max:250'],
            'date' => ['required','max:250'],
            'chief_guest' => ['required','max:500'],
            'video_url' => ['required','url','max:1000'],
            'google_map' => ['required','max:1000'],
            'ts_details1' => ['required','max:100000'],
        ],[
            'ts_details1.required' => "Introduction Detail Section is missing." ,
            'video_url.url' => 'Please enter valid URL',
        ]);
            // dd(request()->all());
        $total = $_POST["total_images"];
            $images = array();
            for ($n=0; $n < $total; $n++){
                if (!empty($_POST["image".($n+1)])){
                    $images[] = $_POST["image".($n+1)];
                }
            }
        $gallery_image = json_encode($images);
        $name = request('name');
        $designation = request('designation');
        $fb_url = request('fb_url');
        $twitter_url = request('twitter_url');
        $instagram_url = request('instagram_url');
        $linkedin_url = request('linkedin_url');
        $gst = array();
        $mi=0;
        $imgs = array();

        for($a = 0; $a < count($name); $a++){
            if ($name[$a] !="" and $designation[$a] !="") {
            $mi = (array_key_exists("img".$mi, request()->all()))?$mi:$mi+1;    
             $img = (request()->has("img$mi")) ? request("img$mi") : "";
             if($name[$a] !="" and $designation[$a] !="" and $img !=""){
                $gst[]= array(
                    "name" => $name[$a],
                    "img" => $img,
                    "designation" => $designation[$a],
                    "fb_url" => $fb_url[$a],
                    "twitter_url" => $twitter_url[$a],
                    "instagram_url" => $instagram_url[$a],
                    "linkedin_url" => $linkedin_url[$a]
                );
                $mi++;  
            }
            }        
        }        
        $guest = (json_encode($gst));
        $text_sec1 = array(
                'ts_img1' => request( 'ts_img1' ),
                'ts_details1' => request( 'ts_details1' ),
            );
            $text_sec1 = json_encode( $text_sec1 );

        if (request()->has("submit")) {
		  $schema= (request()->has('schema'))?request('schema'):array();
		  $type = request( 'type' );
		  $schm = array();
		  if ( $type != "" ) {
			for ( $a = 0; $a < count( $schema ); $a++ ) {
			  if ( $type[ $a ] != "" ) {
				$schm[] = array(
				  "schema" => $schema[ $a ],
				  "type" => $type[ $a ],
				);
			  }
			}
		  }
		  $schema = ( json_encode( $schm ) );
            $social_links = array(
                'fb_link' => request('fb_link'),
                'twitter_link' => request('twitter_link'),
                'linkedin_link' => request('linkedin_link'),
                'instagram_link' => request('instagram_link'),
            );
            $data = array();
            $data["title"] = request('title');
            $data["slug"] = request('slug');
            $data["meta_title"] = request('meta_title');
            $data["meta_description"] = request('meta_description');
            $data["meta_tags"] = request('meta_tags');
            $data["details"] = request('details');
            $data["cover_image"] = request('cover_image');
            $data["address"] = request('address');
            $data["chief_guest"] = request('chief_guest');
            $data["google_map"] = request('google_map');
            $data["time"] = request('time');
            $data["video_url"] = request('video_url');
            $data["gallery_image"] = $gallery_image;
            $data["social_links"] = json_encode($social_links);
            $data["text_sec1"] = $text_sec1;
            $data["guest"] = $guest;
            $data["date"] = $date;
            $data["microdata"] = $schema;
            if ($user->type == "district") {
                $data["user_type"] = request('user_type');
                $data["district"] = request('district');
                $data["province"] = request('province'); 
            }elseif ($user->type == "province") {
                $data["user_type"] = request('user_type');
                $data["province"] = request('province'); 
            }else {
                $data["user_type"] = request('user_type');
              
            }   
            if(request()->has('id')){

            DB::table('event')->where('id', request('id'))->update($data);
            return back()->with('flash_message', 'Event Record updated successfully');
        }else{
            $id = DB::table('event')->insertGetId($data);
                return redirect(route('create-event').'?edit='.$id)->with('success','Event Record Inserted Successfully');
            }
        }

        }
        return view('admin.district.event.create-event');
	}
    public function eventList(){
       $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        $user_type = Auth::user()->type;
        $dept_id = Auth::user()->dept_id;
        if ($user_type == "admin") {
            $data = Event::orderBy('id', 'DESC')->paginate(10);
        }elseif ($user_type == "district") {
            $data = Event::where(['user_type' => $user_type , 'district' => $dept_id ])->paginate(10);
        }elseif ($user_type == "province") {
            $data = Event::where(['province' => $dept_id ])->paginate(10);
        }elseif ($user_type == "national") {
            $data = Event::where(['user_type' => $user_type ])->paginate(10);
        }
        return view('admin.district.event.event-list' ,compact('data'));
    }

    public function meta(){

        if(request('submit')){
            request()->validate([
                'meta_title' => ['required']
            ]);
            DB::table('meta')->updateOrInsert(
            ['id' => request('id')],
            ['page_name'=>request('page_name'),
                'meta_title'=>request('meta_title'),
                'meta_description'=>request('meta_description'),
                'meta_tags'=>request('meta_tags'),
                'og_image'=>request('og_image'),
            ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','events')->first();
            return view('admin.district.event.event-meta',compact('data'));
        }    
    }

}
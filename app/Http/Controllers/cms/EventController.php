<?php 
namespace App\Http\Controllers\cms;
use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class EventController extends Controller
{
    
	public function _new()
    {   
        if(request('edit')){
            $id = request('edit');
            $data = Event::where('id',$id)->first();
            return view('admin.event.create-event',compact('data'));
        }	
        if(request('delete')){
                $id = request('delete');
                $data = DB::table('events')->where('id',$id)->delete();
                return back()->with('flash_message','Record is deleted Successfully');
            }   	
    	if (request()->has("submit")) {
			//dd(request()->all());
            $date = explode("/", request('date'));
            $date = $date[2]."-".$date[1]."-".$date[0];
    		request()->validate([
                'meta_title' => ['required'],
                'meta_title' => ['required', 'min:20', 'max:255']
            ]);
        $social_links = array(
            'fb_link' => request('fb_link'),
            'twitter_link' => request('twitter_link'),
            'linkedin_link' => request('linkedin_link'),
            'instagram_link' => request('instagram_link'),
        );
        dd($social_links);
          $schema = request( 'schema' );
          $type = request( 'type' );
          $schm = array();
          if ( $type != "" ) {
            for ( $a = 0; $a < count( $type ); $a++ ) {
              if ( $type[ $a ] != "" ) {
                $schm[] = array(
                  "schema" => $schema[ $a ],
                  "type" => $type[ $a ],
                );
              }
            }
          }
      $schema = ( json_encode( $schm ) );
        Event::updateOrInsert(
        ['id' => request('id')],
            ['title'=>request('title'),
                'slug'=> Str::slug(request( 'slug' ), '-'),
                'details'=>request('details'),
                'meta_title'=>request('meta_title'),
                'meta_description'=>request('meta_description'),
                'image'=>request('image'),
                'meta_tags'=>request('meta_tags'),
                'address'=>request('address'),
                'time'=>request('time'),
                'social_links' => json_encode($social_links),
                'date'=>$date,
                'microdata'=>$schema
            ]);
            return back()->with('flash_message','Record is Updated successfully');
        }
        return view('admin.event.create-event');
	}
    public function eventList(){
        $data = Event::orderBy('id', 'DESC')->paginate(20);
        return view('admin.event.event-list' ,compact('data'));
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
            return view('admin.event.event-meta',compact('data'));
        }    
    }
}
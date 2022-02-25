<?php 

namespace App\Http\Controllers\cms;
use App\Http\Controllers\Controller;

use App\Models\AboutUs;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function about()
    {
       // dd(request()->all());
        $aboutmeta = array(
            'meta_title' => request('meta_title'),
            'meta_description' => request('meta_description'),
            'meta_tags' => request('meta_tags'),
            'about_image' => request('about_image'),
        );
        if (request()->has("submit")) {
            
             $text_sec1 = array(
                'ts_img1' => request( 'ts_img1' ),
                'ts_details1' => request( 'ts_details1' ),
            );
            $text_sec2 = array(
                'ts_img2' => request( 'ts_img2' ),
                'ts_details2' => request( 'ts_details2' ),
            );
            $text_sec3 = array(
                'ts_img3' => request( 'ts_img3' ),
                'ts_details3' => request( 'ts_details3' ),
            );

            $schema= request('schema');
            $type= request('type');
            $schm = array();
            for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            }  
            $schema= (json_encode($schm));
            $text_sec1 = json_encode( $text_sec1 );
            $text_sec2 = json_encode( $text_sec2 );
            $text_sec3 = json_encode( $text_sec3 );

         /*    request()->validate([
                'meta_title' => ['required', 'min:3'],
                'meta_description' => ['required', 'min:5'],
                'meta_tags' => ['required'],
            ]);*/
             if(request()->has('id')){
            AboutUs::where('id', request('id'))->update([
                   'about_meta' => json_encode($aboutmeta),
                   'text_sec1' => $text_sec1,
                   'text_sec2' => $text_sec2,
                   'text_sec3' => $text_sec3,
                   'microdata' => $schema,
                   'og_image' => request('og_image'),
                ]);
            return back()->with('flash_message', 'about Record settings updated successfully');
        }else{
            AboutUs::insert([
                'about_meta' => json_encode($aboutmeta),
                ]);
                return back()->with('flash_message', 'about Record settings updated successfully');
            }
        }
        $data = AboutUs::select('id','about_meta' ,'og_image' , 'text_sec1' , 'text_sec2' , 'text_sec3' , 'microdata')->first();
        
        return view('admin.about.about-us' , compact('data'));
    }

    public function attorneys()
    {
        if (request()->has("submit")) {
            $atr = array(
                'm_heading' => request('m_heading'),
            );
            $name = request('name');
            $designation = request('designation');
            $fb_url = request('fb_url');
            $twitter_url = request('twitter_url');
            $instagram_url = request('instagram_url');
            $linkedin_url = request('linkedin_url');
            $data = array();
            $mi=0;
            $imgs = array();
            if ($name !="") {
                    for($a = 0; $a < count($name); $a++){
                    $mi = (array_key_exists("img".$mi, request()->all()))?$mi:$mi+1;    
                     $img = (request()->has("img$mi")) ? request("img$mi") : "";
                    $data[]= array(
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
        $atr['attorneys'] = $data;
        $attorneys = (json_encode($atr));
             if(request()->has('id')){
            AboutUs::where('id', request('id'))->update([
                   'attorneys' => $attorneys,
                ]);
            return back()->with('flash_message', 'Attorney Record updated successfully');
        }else{
            AboutUs::insert([
                'attorneys' => $attorneys,
                ]);
                return back()->with('flash_message', ' Attorney Record updated successfully');
            }
        }
        $data = AboutUs::select('id','attorneys')->first();
       return view('admin.about.attorneys' , compact('data')); 
    }
    public function reviews()
    {
        if (request()->has("submit")) {
           $reviews = array(
                'm_heading' => request('m_heading'),
            );

            $name = request('name');
            $designation = request('designation');
            $review = request('review');
            $data = array();
            $mi=0;
            $imgs = array();
            if ($name !="") {
                    for($a = 0; $a < count($name); $a++){
                    $mi = (array_key_exists("img".$mi, request()->all()))?$mi:$mi+1;    
                    $img = (request()->has("img$mi")) ? request("img$mi") : "";
                    $data[]= array(
                        "name" => $name[$a],
                        "img" => $img,
                        "designation" => $designation[$a],
                        "review" => $review[$a],
                    );
                    $mi++;          
                }   
            }       
            $reviews["reviews"] = $data;
            $reviews = (json_encode($reviews));
             if(request()->has('id')){
            AboutUs::where('id', request('id'))->update([
                   'reviews' => $reviews,
                ]);
            return back()->with('flash_message', 'Attorney Record updated successfully');
        }else{
            AboutUs::insert([
                'reviews' => $reviews,
                ]);
                return back()->with('flash_message', ' Attorney Record updated successfully');
            }
        }
        $data = AboutUs::select('id','reviews')->first();
       return view('admin.about.reviews' , compact('data')); 
    }
}
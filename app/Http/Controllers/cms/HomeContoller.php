<?php 

namespace App\Http\Controllers\cms;
use App\Http\Controllers\Controller;
use App\Models\Homedata;

class HomeContoller extends Controller
{
    
    public function homemeta()
    {
       // dd(request()->all());
    	$homemeta = array(
    		'meta_title' => request('meta_title'),
            'meta_description' => request('meta_description'),
            'meta_tags' => request('meta_tags'),
            'og_image' => request('og_image'),
		);
        
    	if (request()->has("submit")) {

             $text_sec1 = array(
                'ts_img1' => request( 'ts_img1' ),
                'ts_title1' => request( 'ts_title1' ),
                'ts_details1' => request( 'ts_details1' ),
            );
            $text_sec1 = json_encode( $text_sec1 );
            //dd($text_sec1);
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
    		 request()->validate([
	            'meta_title' => ['required', 'min:3'],
	            'meta_description' => ['required', 'min:5'],
	            'meta_tags' => ['required'],
	        ]);
    		 if(request()->has('id')){
            Homedata::where('id', request('id'))->update([
                   'home_meta' => json_encode($homemeta),
                   'microdata' => $schema,
                   'text_sec1' => $text_sec1,
                ]);
            return back()->with('flash_message', 'Home meta settings updated successfully');
    	}else{
    		Homedata::insert([
				'home_meta' => json_encode($homemeta),
                'microdata' => $schema,
                'text_sec1' => $text_sec1,
				]);
    			return back()->with('flash_message', 'Home meta settings updated successfully');
    		}
    	}
    	$data = Homedata::select('id','home_meta' , 'microdata' , 'text_sec1')->first();
    	return view('admin.home.homemeta' , compact('data'));
	}
    public function grants()
    {
        if (request()->has("submit")) {
           //dd(request()->all());
            $data2 = array(
                'm_heading' => request('m_heading'),
            );
            $title = request('title');
            $description = request('description');
            $anchor_url = request('anchor_url');
            $anchor_text = request('anchor_text');
            $data = array();
            $mi=0;
            $imgs = array();
            if ($title !="") {
                    for($a = 0; $a < count($title); $a++){
                    $mi = (array_key_exists("img".$mi, request()->all()))?$mi:$mi+1;    
                     $img = (request()->has("img$mi")) ? request("img$mi") : "";
                    $data[]= array(
                        "title" => $title[$a],
                        "img" => $img,
                        "description" => $description[$a],
                        "anchor_url" => $anchor_url[$a],
                        "anchor_text" => $anchor_text[$a],
                    );
                    $mi++;          
                }   
            }  
        $data2["grants"] = $data;      
        $grants = (json_encode($data2));
             if(request()->has('id')){
            Homedata::where('id', request('id'))->update([
                   'grants' => $grants,
                ]);
            return back()->with('flash_message', 'Grants Record updated successfully');
        }else{
            Homedata::insert([
                'grants' => $grants,
                ]);
                return back()->with('flash_message', ' Grants Record updated successfully');
            }
        }
        $data = Homedata::select('id','grants')->first();
       return view('admin.home.grants' , compact('data')); 
    }
    public function initiatives()
    {
        if (request()->has("submit")) {
           //dd(request()->all());
             $data2 = array(
                'm_heading' => request('m_heading'),
            );
            $title = request('title');
            $description = request('description');
            $anchor_url = request('anchor_url');
            $anchor_text = request('anchor_text');
            $data = array();
            $mi=0;
            $imgs = array();
            if ($title !="") {
                    for($a = 0; $a < count($title); $a++){
                    $mi = (array_key_exists("img".$mi, request()->all()))?$mi:$mi+1;    
                     $img = (request()->has("img$mi")) ? request("img$mi") : "";
                    $data[]= array(
                        "title" => $title[$a],
                        "img" => $img,
                        "description" => $description[$a],
                        "anchor_url" => $anchor_url[$a],
                        "anchor_text" => $anchor_text[$a],
                    );
                    $mi++;          
                }   
            }   
        $data2["initiatives"] = $data;    
        $initiatives = (json_encode($data2));
             if(request()->has('id')){
            Homedata::where('id', request('id'))->update([
                   'initiatives' => $initiatives,
                ]);
            return back()->with('flash_message', 'Initiatives Record updated successfully');
        }else{
            Homedata::insert([
                'initiatives' => $initiatives,
                ]);
                return back()->with('flash_message', ' Initiatives Record updated successfully');
            }
        }
        $data = Homedata::select('id','initiatives')->first();
       return view('admin.home.initiatives' , compact('data')); 
    }
    public function interest()
    {       
        if (request()->has("submit")) {
            //dd(request()->all());
             $data2 = array(
                'm_heading' => request('m_heading'),
            );
            $name = request('name');
            $count = request('count');
            $icon = request('icon');
            $data = array();
            for($a = 0; $a < count($name); $a++){
                if ($name[$a] !="") {
                    $data[]= array(
                        "name" => $name[$a],
                        "count" => $count[$a],
                        "icon" => $icon[$a],
                    ); 
                }  
            } 
            $data2["interest"] = $data;
            $interest = (json_encode($data2));
             if(request()->has('id')){
            Homedata::where('id', request('id'))->update([
                   'interest' => $interest,
                ]);
            return back()->with('flash_message', 'Interest Record is  Updated Successfully');
        }else{
            Homedata::insert([
                'interest' => $interest,
                ]);
                return back()->with('flash_message', 'Interest Record is  Updated Successfully');
            }
        }
        $data = Homedata::select('id','interest')->first();
        
        return view('admin.home.interest' , compact('data'));
    }

        public function footer()
    {
       // dd(request()->all());
        if (request()->has("submit")) {
            $icon = request('icon');
            $link = request('link');
            $links = array();
            for($a = 0; $a < count($link); $a++){
                if ($link[$a] !="") {
                        $links[]= array(
                        "link" => $link[$a],
                        "icon" => $icon[$a]
                    ); 
                }         
            }       
            $social_links = (json_encode($links));
            $footer = array(
                'address' => request('address'),
                'office_time' => request('office_time'),
                'copyrights' => request('copyrights'),
                'phone' => request('phone'),
                'email' => request('email'),
            );
            if(request()->has('id')){
            Homedata::where('id', request('id'))->update([
                   'footer' => json_encode($footer),
                   'social_links' => $social_links,
                ]);
            return back()->with('flash_message', 'Home footer data is  updated successfully');
        }else{
            Homedata::insert([
                'footer' => json_encode($footer),
                'copyrights' => json_encode($copyrights),
                'social_links' => $social_links,
                ]);
                return back()->with('flash_message', 'Home footer data is  updated successfully');
            }
        }
        $data = Homedata::select('id','footer' , 'copyrights' , 'social_links')->first();
        return view('admin.footer' , compact('data'));
    }
}

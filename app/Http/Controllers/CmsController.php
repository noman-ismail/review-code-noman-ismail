<?php
namespace App\Http\Controllers;
use App\Models\ContactUs;
use App\Models\Faqs;
use App\Models\Privacy;
use App\Models\TermsCondition;
use DB;
use Auth;
use Illuminate\Http\Request;
use Spatie\PdfToImage\Pdf;
use Org_Heigl\Ghostscript\Ghostscript;
use Illuminate\Support\Facades\Storage;
class CmsController extends Controller {

    public function contact() {
        $user_type = Auth::user()->type;
        $dept_id = Auth::user()->dept_id;
        if ($user_type == "admin") {
            $data = ContactUs::where('user_type' , $user_type)->first();
        }elseif ($user_type == "district") {
            $data = ContactUs::where(['user_type' => $user_type , 'district' => $dept_id ])->first();
        }elseif ($user_type == "province") {
            $data = ContactUs::where(['user_type' => $user_type , 'province' => $dept_id ])->first();
        }elseif ($user_type == "national") {
            $data = ContactUs::where(['user_type' => $user_type ])->first();
        }
        $record = "";
        return view('admin.contact-us', compact('data', 'record' ));
    }
    public function editcontactus(AboutUs $record) {
        // dd($record);
        $page_data = AboutUs::all();
        return view('admin.about-us', compact('page_data', 'record'));
    }
    public function storecontactus() {
       // dd(request()->all());
        request()->validate([
                'meta_title' => ['required'],
                'google_map' => ['nullable', 'max:1000'],
        ]);
        if(Auth::user()->type == 'admin'){
            request()->validate([
                'meta_title' => ['required', 'min:3'],
                'title' => ['nullable', 'max:60'],
            ]);
        }
        $schema= request('schema');
        $type= request('type');
        $schm = array();
        if ($schema !="") {
            for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            }
        }
        $schema= (json_encode($schm));
        $profile = array(
            'person_image' => request( 'person_image' ),
            'pr_name' => request( 'pr_name' ),
            'pr_designation' => request( 'pr_designation' ),
            'pr_phone' => request( 'pr_phone' ),
            'pr_email' => request( 'pr_email' ),
            'pr_address' => request( 'pr_address' ),
            'pr_web_url' => request( 'pr_web_url' ),
            'pr_fb_url' => request( 'pr_fb_url' ),
            'pr_twitter_url' => request( 'pr_twitter_url' ),
            'pr_linkedin_url' => request( 'pr_linkedin_url' ),
            'pr_instagram_url' => request( 'pr_instagram_url' ),
        );
        // store and update categories
        DB::table('contact_us')->updateOrInsert(
        ['id' => request('id')],
        [
            'meta_title'=>request('meta_title'),
            'meta_description' => request('meta_description'),
            'meta_tags' => request('meta_tags'),
            'title' => request('title'),
            'r_email' => request('r_email'),
            'detail' => request('detail'),
            'email_title' => request('email_title'),
            'email' => request('email'),
            'phone_title' => request('phone_title'),
            'phone' => request('phone'),
            'address_title' => request('address_title'),
            'address' => request('address'),
            'google_map' => request('google_map'),
            'cover_image' => request('cover-image'),
            'user_type' => request('user_type'),
            'district' => request('district'),
            'province' => request('province'),
            'national' => request('national'),
            'admin' => request('admin'),
            'microdata' => $schema,
            'profile' => json_encode($profile),
        ]);
        
        return back()->with('flash_message', 'Record updated successfully');
    }
    public function delete(AboutUs $record) {
        // deleting selected category
        $record->delete();
        // returning back to the same page
        return back()->with('flash_message', 'Record updated successfully');
    }
/*    public function contactstore() {
        request()->validate([
            'meta_title' => ['required', 'min:3'],
            'meta_description' => ['required', 'min:5'],
            'title' => ['required', 'min:5'],
            'meta_tags' => ['required'],
            'content' => ['required'],
        ]);
        // store and update categories
        ContactUs::updateOrCreate(
            ['id' => request('id')]
            , [
                'meta_title' => request('meta_title'),
                'meta_descp' => request('meta_description'),
                'title' => request('title'),
                'meta_tags' => request('meta_tags'),
                'content' => request('content'),
            ]);
        return back()->with('flash_message', 'Record updated successfully');
    }*/
    public function privacypolicy() {
        $data = Privacy::first();
        
        return view('admin.privacy', compact('data'));
    }
    public function storeprivacypolicy() {
     //   dd(request()->all());
          $schema= request('schema');
         $type= request('type');
            $schm = array();
            if ($schema !="") {
                for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            }  
            }
            
            $schema= (json_encode($schm));
        request()->validate([
            'meta_title' => ['required'],
        ]);
        // store and update categories
        /*dd(request()->all());*/
        privacy::updateOrCreate(
            ['id' => request('id')]
            , [
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_tags' => request('meta_tags'),
                'content' => request('content'),
                'og_image' => request('og_image'),
                'microdata' => $schema
            ]);
         return back()->with('flash_message', 'Privacy Policy Record is Updated Successfully');
    }
    public function termscondition() {
        $data = TermsCondition::first();
        
        return view('admin.terms-condition', compact('data'));
    }
    public function storetermscondition() {
        request()->validate([
            'meta_title' => ['required', 'min:3'],
        ]);
          $schema= request('schema');
         $type= request('type');
            $schm = array();
            if ($schema !="") {
                for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            } 
            }
             
            $schema= (json_encode($schm));
        // store and update categories
        if(request()->has('id')){
            termscondition::where('id', request('id'))->update([
                'meta_title' => request('meta_title'),
                'meta_description' => request('meta_description'),
                'meta_tags' => request('meta_tags'),
                'content' => request('content'),
                'og_image' => request('og_image'),
                'microdata' => $schema,
            ]);
            return back()->with('flash_message', 'Terms & Condition Record is Updated Successfully');
        }
    }
    // FAQs 
    public function faqs() {
        if(request()->isMethod('post')){
                    request()->validate([
            'question' => ['required', 'min:10'],
            'answer' => ['required', 'min:10'],
        ]);
        // store and update categories
        Faqs::updateOrCreate(
            ['id' => request('id')]
            , [
                'question' => request('question'),
                'answer' => request('answer'),
            ]);
        return back()->with('flash_message', 'Record updated successfully');
    }else{
        if (request('edit')) {
            $id = request('edit');
            $edit = Faqs::where('id', $id)->first();
            $faqs = Faqs::all()->sortBy('tb_order');
            return view('admin.faqs', compact('edit', 'faqs'));
        }
        if (request('del')) {
            $id = request('del');
            $delete = Faqs::where('id', $id)->first();
            $delete->delete();
            return back()->with('flash_message', 'Record updated successfully');
        }
        $edit = "";
        $faqs = Faqs::all()->sortBy('tb_order');
        return view('admin.faqs', compact('faqs', 'edit'));
        }
    }
    public function allfaqs() {
        $faqs = Faqs::all()->sortBy('id');
        return view('admin.faqs_list', compact('faqs'));
    }
    public function faqsorder() {
        $orders = request('order');
        foreach ($orders as $k => $v) {
            $page = Faqs::find($v);
            if ($page) {
                $page->tb_order = $k;
                $page->save();
            }
        }
        return back()->with('flash_message', 'Record updated successfully');
    }
     public function faqs_meta(){
        
        if(request('submit')){
			$schema= request('schema');
			$type= request('type');
			$schm = array();
			if ($schema !="") {
				 for($a = 0; $a < count($type); $a++){
				if ($schema[$a] !="") {
					 $schm[]= array(
						"schema" => $schema[$a],
						"type" => $type[$a]
					);  
				 }     
			} 
			}

			$schema= (json_encode($schm));
            request()->validate([
                'meta_title' => ['required'],
                'meta_description' => ['required'],
                'meta_tags' => ['required']
            ]);
            DB::table('meta')->updateOrInsert(
            ['id' => request('id')],
            ['page_name'=>request('page_name'),
                'meta_title'=>request('meta_title'),
                'meta_description'=>request('meta_description'),
                'meta_tags'=>request('meta_tags'),
                'og_image'=>request('og_image'),
                'microdata'=>$schema,
            ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','faqs')->first();
            return view('admin.faqs_meta',compact('data' ));
        }    
    }

    // Notification meta

    public function notificationsmeta(){
       if(request('submit')){
        request()->validate([
            'meta_title' => ['required']
        ]);
         $schema= request('schema');
        $type= request('type');
        $schm = array();
        if ($schema !="") {
             for($a = 0; $a < count($type); $a++){
            if ($schema[$a] !="") {
                 $schm[]= array(
                    "schema" => $schema[$a],
                    "type" => $type[$a]
                );  
             }     
        } 
        }
        $schema= (json_encode($schm));
        DB::table('meta')->updateOrInsert(
        ['id' => request('id')],
        ['page_name'=>request('page_name'),
            'meta_title'=>request('meta_title'),
            'page_title'=>request('page_title'),
            'meta_description'=>request('meta_description'),
            'meta_tags'=>request('meta_tags'),
            'content'=>request('content'),
            'microdata'=>$schema,
            'og_image'=>request('og_image'),
            'pagination'=>request('pagination'),
        ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','notifications')->first();
            return view('admin.notifications-meta',compact('data'));
        }    
    }

    //documents meta

    public function documentsmeta(){
       if(request('submit')){
            request()->validate([
                'meta_title' => ['required']
            ]);
             $schema= request('schema');
            $type= request('type');
            $schm = array();
            if ($schema !="") {
                for($a = 0; $a < count($type); $a++){
                    if ($schema[$a] !="") {
                        $schm[]= array(
                            "schema" => $schema[$a],
                            "type" => $type[$a]
                        );  
                    }     
                } 
            }
            $schema= (json_encode($schm));
            DB::table('meta')->updateOrInsert(
            ['id' => request('id')],
            ['page_name'=>request('page_name'),
                'meta_title'=>request('meta_title'),
                'page_title'=>request('page_title'),
                'meta_description'=>request('meta_description'),
                'meta_tags'=>request('meta_tags'),
                // 'content'=>request('content'),
                'microdata'=>$schema,
                'og_image'=>request('og_image'),
                'pagination'=>request('pagination'),
            ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','documents')->first();
            return view('admin.documents-meta',compact('data'));
        }    
    }

    //Jobs meta

	public function jobsmeta(){
            if(Auth::user()->type == 'national'){
                return redirect(route('base_url')."/404");
            }
           if(request('submit')){
            request()->validate([
                'meta_title' => ['required']
            ]);
             $schema= request('schema');
            $type= request('type');
            $schm = array();
            if ($schema !="") {
                 for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            } 
            }
            $schema= (json_encode($schm));
            DB::table('meta')->updateOrInsert(
            ['id' => request('id')],
            ['page_name'=>request('page_name'),
                'meta_title'=>request('meta_title'),
                'page_title'=>request('page_title'),
                'meta_description'=>request('meta_description'),
                'meta_tags'=>request('meta_tags'),
                'content'=>request('content'),
                'microdata'=>$schema,
                'og_image'=>request('og_image'),
                'pagination'=>request('pagination'),
            ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','jobs')->first();
            return view('admin.jobs-meta',compact('data'));
        }    
    }

    //Event Meta

    public function eventmeta(){
        if(request('submit')){
            request()->validate([
                'meta_title' => ['required']
            ]);
             $schema= request('schema');
            $type= request('type');
            $schm = array();
            if ($schema !="") {
                 for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            } 
            }
            $schema= (json_encode($schm));
            DB::table('meta')->updateOrInsert(
            ['id' => request('id')],
            ['page_name'=>request('page_name'),
                'meta_title'=>request('meta_title'),
                'page_title'=>request('page_title'),
                'meta_description'=>request('meta_description'),
                'meta_tags'=>request('meta_tags'),
                'content'=>request('content'),
                'microdata'=>$schema,
                'og_image'=>request('og_image'),
                'before_limit'=>request('before_limit'),
                'after_limit'=>request('after_limit'),
            ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','events')->first();
            return view('admin.event-meta',compact('data'));
        }    
    }
    public function newsmeta(){
        if(request('submit')){
            request()->validate([
                'meta_title' => ['required']
            ]);
             $schema= request('schema');
            $type= request('type');
            $schm = array();
            if ($schema !="") {
                 for($a = 0; $a < count($type); $a++){
                if ($schema[$a] !="") {
                     $schm[]= array(
                        "schema" => $schema[$a],
                        "type" => $type[$a]
                    );  
                 }     
            } 
            }
            $schema= (json_encode($schm));
            DB::table('meta')->updateOrInsert(
            ['id' => request('id')],
            ['page_name'=>request('page_name'),
                'meta_title'=>request('meta_title'),
                'page_title'=>request('page_title'),
                'meta_description'=>request('meta_description'),
                'meta_tags'=>request('meta_tags'),
                'content'=>request('content'),
                'microdata'=>$schema,
                'og_image'=>request('og_image'),
            ]);
            return back()->with('flash_message','Settings are Updated successfully');
        }else{
            $data = DB::table('meta')->where('page_name','news')->first();
            return view('admin.news-meta',compact('data'));
        }    
    }

    public function welfarebenefit(){
        if ( request()->isMethod( 'post' ) ) {
         // dd(request()->all());
            request()->validate([
                'title' => [ 'required' ],
                'meta_title' => [ 'required' ],
                'meta_description' => [ 'required' ],
                'meta_tags' => [ 'required' ],
                // 'slug' => [ 'required' ],
                'content' => [ 'required' ]
            ]);
          $schema = request( 'schema' );
          $type = request( 'type' );
          $schm = array();
          if ( $schema != "" ) {
            for ( $a = 0; $a < count( $type); $a++ ) {
              if ( $type[ $a ] != "" ) {
                $schm[] = array(
                  "schema" => $schema[ $a ],
                  "type" => $type[ $a ],
                );
              }
            }
          }

          $schema = ( json_encode( $schm ) );
        }

        $reference = request( 'reference' );
        $quote = request( 'quote' );
        $num = request( 'num' );
        // dd($num);
        $quotes = array();
        if ( is_array( request( "reference" ) ) ) {
            for ( $a = 0; $a < count( $reference ); $a++ ) {
              if ( $reference[ $a ] != "" ) {
                $quotes[] = array(
                  "num" => $num[ $a ],
                  "reference" => $reference[ $a ],
                  "quote" => $quote[ $a ],
                );
              }
            }
            $quotes = json_encode( $quotes );
        }

        $gr_heading = request( 'gr_heading' );
        $gr_body = request( 'gr_body' );
        $gr_icon = request( 'gr_icon' );
        $gr_text = array();
        //dd($gr_icon);
        if ( is_array( request( "gr_heading" ) ) ){
            for ( $a = 0; $a < count( $gr_heading ); $a++ ) {
                if ( $gr_heading[ $a ] != "" ) {
                    $gr_text[] = array(
                        "gr_heading" => $gr_heading[ $a ],
                        "gr_body" => $gr_body[ $a ],
                        "gr_icon" => $gr_icon[ $a ],
                    );
                }
            }
        $green_text = json_encode( $gr_text );
        }
       // dd($green_text);

        if ( request()->has( "submit" ) ) {
            //dd("ok");
        $data = array();
        $data[ "title" ] = request( 'title' );
        // $data[ "slug" ] = request( 'slug' );
        $data[ "meta_title" ] = request( 'meta_title' );
        $data[ "meta_description" ] = request( 'meta_description' );
        $data[ "meta_tags" ] = request( 'meta_tags' );
        $data[ "cover" ] = request( 'cover-image' );
        $data[ "og_image" ] = request( 'og-image' );
        $data[ "quote" ] = $quotes;
        $data[ "green_text" ] = $green_text;
        $data[ "black_text" ] = request( 'black_body');
        $data[ "status" ] = request( 'submit' );
        $data[ "content" ] = request( 'content' );
        $data[ "microdata" ] = $schema;
        if ( request()->has( 'id' ) ) {
           // dd("ok");
          DB::table( 'welfare_benefits' )->where( 'id', request( 'id' ) )->update( $data );
          return back()->with( 'flash_message', 'Welfare Benefits Record Updated Successfully' );
        } else {
           // dd("no");
          $id = DB::table( 'welfare_benefits' )->insert( $data );
          return redirect( route( 'welfare-benefits' ))->with( 'success', 'Welfare Benefits Record Added Successfully' );
        }
      }
        $data = DB::table( 'welfare_benefits' )->first();
       // dd($data);
        return view('admin.welfare-benefits' , compact("data"));
    }
    public function CreatDownloads(Request $request){
        $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        $user_type = $user->type;
        if($user_type == 'district'){
            return redirect(route('base_url')."/404");
        }
        if(request('edit')){
            $id = request('edit');
            if($user_type == "admin"){
                $data = DB::table('downloads')->where('id',$id)->first();
            }elseif($user_type == 'national'){
                $data = DB::table('downloads')->where(['id'=>$id,'user_type'=>$user->type])->first();
            }elseif($user_type == 'province'){
                $data = DB::table('downloads')->where(['id'=>$id,'user_type'=>$user->type,'province'=>$user->dept_id])->first();
            }else{
                session(['back_url' => url()->previous()]);
                return redirect(route('404'));
            }

            return view('admin.create-download',compact('data'));
        }
        if(request('delete')){
            $id = request('delete');
            if($user_type == "admin"){
                $data = DB::table('downloads')->where('id',$id)->delete();
            }elseif($user_type == 'national'){
                $data = DB::table('downloads')->where(['id'=>$id,'user_type'=>$user->type])->delete();
            }elseif($user_type == 'province'){
                $data = DB::table('downloads')->where(['id'=>$id,'user_type'=>$user->type,'province'=>$user->dept_id])->delete();
            }else{
                session(['back_url' => url()->previous()]);
                return redirect(route('404'));
            }
            return back()->with('flash_message','Record is deleted Successfully');
        } 
        if ( request()->isMethod( 'post' ) and request()->has( 'id' ) ) {
			//dd(request()->file('pdffile')->getSize());
            //dd(request()->all());
            $data = array();
            request()->validate([
                'title' => 'required|max:100',
                'description' => 'required' ,
                "file" => "nullable|mimes:pdf|max:100000000",
                'type' =>  'required' ,
                'watermark' =>  'nullable|min:3|max:30' ,
                'date' =>  'required' 
            ]);
            if (request("date") !="") {
                $date = explode("/", request('date'));
                $date = $date[2]."-".$date[1]."-".$date[0];
            }else{
                $date = Null;
            }
            if ($files = request()->file('file')) {
                   $destinationPath = 'downloads/'; // upload path
                   $gen_file_nam = date('Y-m-d-his') . "." ;  
                   $profilefile = $gen_file_nam.$files->getClientOriginalExtension();
                   $files->move($destinationPath, $profilefile);
                   $gen_path = route('base_url')."/".$destinationPath.$profilefile;
                   $gen_file_name = $gen_file_nam.'jpg';
                   $t_name = $destinationPath.$profilefile.'[0]';
                   $imagic = new \Imagick();
                   $imagic->setResolution(150,150);
                   $imagic->readImage($t_name);
                   $imagic->writeImage('downloads/'.$gen_file_name);

                    $im = new \Imagick('downloads/'.$gen_file_name);
                    $imageprops = $im->getImageGeometry();
                    $width = $imageprops['width'];
                    $height = $imageprops['height'];
                    if($width > $height){
                        $newHeight = 100;
                        $newWidth = (100 / $height) * $width;
                    }else{
                        $newWidth = 100;
                        $newHeight = (100 / $width) * $height;
                    }
                    $im->resizeImage($newWidth,$newHeight, \Imagick::FILTER_LANCZOS, 0.9, true);
                    $im->cropImage (100,100,0,0);
                    $im->writeImage( 'downloads/'.$gen_file_name );
                }else{
                    $profilefile = request('mypdf');
                    $gen_file_name = request('pdf_name');
                }
            if (request( 'img_status' )) {
                $img_status = "on";
            }else{
                $img_status = "off";
            }
               // dd(request()->all());
				$fileSize = \File::size("downloads/".$profilefile);
				$fileSize = number_format($fileSize / 1048576, 1);
                $data[ "title" ] = request( 'title' );
                $data[ "description" ] = request( 'description' );
                $data[ "file" ] = $profilefile;
                $data[ "date" ] = $date;
                $data[ "watermark" ] = request('watermark');
                $data[ "img_status" ] = $img_status;
                $data[ "mannual_image" ] = request( 'mannual_image' );
                $data[ "pdf_img" ] = $gen_file_name;
                $data[ "type" ] = request( 'type' );
                $data[ "size" ] = $fileSize." MB";
               // dd(request()->all());
                  DB::table( 'downloads' )->where( 'id', request( 'id' ) )->update( $data );
                  return back()->with( 'flash_message', 'Download Record Updated Successfully' );
                   // dd("no");
        }elseif(request()->isMethod( 'post' )){
            // dd(request()->all());
            $data = array();
            request()->validate([
                'title' => 'required|max:100',
                'description' => 'required' ,
                "file" => "required|mimes:pdf|max:100000000",
                'type' =>  'required' ,
                'watermark' =>  'nullable|min:3|max:30' ,
                'date' =>  'required' 
            ]);
            if (request("date") !="") {
                $date = explode("/", request('date'));
                $date = $date[2]."-".$date[1]."-".$date[0];
            }else{
                $date = Null;
            }
            if ($files = request('file')) {
                   $destinationPath = 'downloads/'; // upload path
                   $gen_file_nam = date('Y-m-d-his') . "." ;  
                   $profilefile = $gen_file_nam . $files->getClientOriginalExtension();
                   $files->move($destinationPath, $profilefile);
                   $gen_path = route('base_url')."/".$destinationPath.$profilefile;
                   $gen_file_name = $gen_file_nam.'jpg';
                   $t_name = $destinationPath.$profilefile.'[0]';
                   $imagic = new \Imagick();
                   $imagic->setResolution(150,150);
                   $imagic->readImage($t_name);
                   $imagic->writeImage('downloads/'.$gen_file_name);

                    $im = new \Imagick('downloads/'.$gen_file_name);
                    $imageprops = $im->getImageGeometry();
                    $width = $imageprops['width'];
                    $height = $imageprops['height'];
                    if($width > $height){
                        $newHeight = 100;
                        $newWidth = (100 / $height) * $width;
                    }else{
                        $newWidth = 100;
                        $newHeight = (100 / $width) * $height;
                    }
                    $im->resizeImage($newWidth,$newHeight, \Imagick::FILTER_LANCZOS, 0.9, true);
                    $im->cropImage (100,100,0,0);
                    $im->writeImage( 'downloads/'.$gen_file_name );
                }
            if (request( 'img_status' )) {
                $img_status = "on";
            }else{
                $img_status = "off";
            }
				$fileSize = \File::size("downloads/".$profilefile);
				$fileSize = number_format($fileSize / 1048576, 1);
               // dd(request()->all());
                $data[ "title" ] = request( 'title' );
                $data[ "description" ] = request( 'description' );
                $data[ "file" ] = $profilefile;
                $data[ "size" ] = $fileSize." MB";
                $data[ "date" ] = $date;
                $data[ "watermark" ] = request('watermark');
                $data[ "type" ] = request( 'type' );
                $data[ "img_status" ] = $img_status;
                $data[ "user_type" ] = request( 'user_type' );
                $data[ "national" ] = request( 'national' );
                $data[ "province" ] = request( 'province' );
                $data[ "mannual_image" ] = request( 'mannual_image' );
                $data[ "pdf_img" ] = $gen_file_name;
                   // dd("no");
                  $id = DB::table( 'downloads' )->insertGetId( $data );
                  return redirect(route('create-download').'?edit='.$id)->with('success','Download Record Inserted Successfully');

            
        }
        return view('admin.create-download');
    }

    public function downloadList(){
       $username = Auth::user()->username;
        $user = DB::table('admin')->where('username',$username)->first();
        $user_type = Auth::user()->type;
        if($user_type == 'district'){
            return redirect(route('base_url')."/404");
        }
        $dept_id = Auth::user()->dept_id;
        if ($user_type == "admin") {
            $data = DB::table("downloads")->orderBy('id', 'DESC')->paginate(10);
        }elseif ($user_type == "district") {
            $data = DB::table("downloads")->where(['user_type' => $user_type , 'district' => $dept_id ])->orderBy('id', 'DESC')->paginate(10);
        }elseif ($user_type == "province") {
            $data = DB::table("downloads")->where(['user_type' => $user_type , 'province' => $dept_id ])->orderBy('id', 'DESC')->paginate(10);
        }elseif ($user_type == "national") {
            $data = DB::table("downloads")->where(['user_type' => $user_type ])->orderBy('id', 'DESC')->paginate(10);
        }
        return view('admin.download-list' ,compact('data'));
    }
    

        public function icons() {
        return view('admin.icons');
    }
}

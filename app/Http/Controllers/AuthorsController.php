<?php

namespace App\Http\Controllers;

use App\Models\Authors;
use App\blogcats;
use Illuminate\Database\Eloquent\Relations\paginate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AuthorsController extends Controller
{

    public function addAuthors(){
        if(request('edit')){
                $id = request('edit');
                $data = DB::table('authors')->where('id',$id)->first();
                return view('admin.authors',compact('data'));
            }
        if(request('delete')){
                $id = request('delete');
                $data = DB::table('authors')->where('id',$id)->delete();
                return back()->with('flash_message','Author is deleted Successfully');
            }
        if ( request( 'publish' ) ) {
            $id = request( 'publish' );
            DB::table( 'authors' )->where( 'id', $id )->update( [ 'status' => 'publish' ] );
            return redirect( '/' . admin . '/authors/list')->with( 'flash_message', 'Author Status is Changed To Publish Successfully' );
        }
        if ( request( 'draft' ) ) {
            $id = request( 'draft' );
            DB::table( 'authors' )->where( 'id', $id )->update( [ 'status' => 'draft' ] );
            return redirect( '/' . admin . '/authors/list')->with( 'flash_message2', 'Author Status is Changed To Draft Successfully' );
        }
       return view('admin.authors');  
    }
    public function addAuthorsSave(){
       //dd(request()->all());
      request()->validate([
            'name' => ['required']
        ]);
        $icon = request('icon');
        $link = request('link');
        $links = array();
        for($a = 0; $a < count($link); $a++){
            if($link[$a] !=""){
                $links[]= array(
                "link" => $link[$a],
                "icon" => $icon[$a]
            );   
            }     
        }       
        $social_links = (json_encode($links));
        DB::table('authors')->updateOrInsert(
        ['id' => request('id')],
        ['name'=>request('name'),
            'details'=>request('details'),
            'cover'=>request('cover-image'),
            'social_links'=> $social_links
        ]);
        return back()->with('flash_message','Record is Updated successfully');
    }

    public function authorsList(){
        if (request()->has( "st" )) {
            $st = request('st');
            $data = authors::where('status' , '=' , $st)->orderBy('id', 'DESC')->paginate(20);
           
        }else{
            $data = authors::orderBy('id', 'DESC')->paginate(20);
        }
        
        return view('admin.authors_list' ,compact('data'));
    }


}

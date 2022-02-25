<?php
namespace App\ Http\ Controllers\ cms;
use App\ Http\ Controllers\ Controller;

use App\ Models\ News;
use App\ Models\ newscats;
use Illuminate\ Database\ Eloquent\ Relations\ paginate;
use Illuminate\ Http\ Request;
use Illuminate\ Support\ Facades\ DB;
use Illuminate\Support\Str;
use Auth;
class newsController extends Controller {

  public function addnews() {

    if ( request()->isMethod( 'post' ) ) {
       // dd(request()->all());
      request()->validate( [
        'title' => ['required', 'min:5', 'max:255'],
        'meta_title' => [ 'required','min:3','max:200' ],
        'meta_description' => [ 'required','min:3','max:255' ],
        'meta_tags' => [ 'required' ],
        'slug' => [ 'required' ],
        'category' => [ 'required' ],
        'date' => [ 'required' ],
        'content' => [ 'required' ]
      ] );
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
      $related = ( is_array( request( 'related' ) ) ) ? implode( ",", request( 'related' ) ) : request( 'related' );
      $question = request( 'question' );
      $answer = request( 'answer' );
      $num = request( 'num' );
      // dd($num);
      $faqs = array();
      if ( is_array( request( "question" ) ) ) {
        for ( $a = 0; $a < count( $question ); $a++ ) {
          if ( $question[ $a ] != "" ) {
            $faqs[] = array(
              "num" => $num[ $a ],
              "question" => $question[ $a ],
              "answer" => $answer[ $a ],
            );
          }
        }
        $faqs = json_encode( $faqs );
      }
      $gr_body = request( 'gr_body' );
      $green_text = array();
      if ( is_array( request( "gr_body" ) ) ) {
        for ( $a = 0; $a < count( $gr_body ); $a++ ) {
          if ( $gr_body[ $a ] != "" ) {
            $green_text[] = array(
              "gr_body" => $gr_body[ $a ],
            );
          }
        }
        $green_text = json_encode( $green_text );
      }
      $red_body = request( 'red_body' );
      $red_text = array();
      if ( is_array( request( "red_body" ) ) ) {
        for ( $a = 0; $a < count( $red_body ); $a++ ) {
          if ( $red_body[ $a ] != "" ) {
            $red_text[] = array(
              "red_body" => $red_body[ $a ],
            );
          }
        }
        $red_text = json_encode( $red_text );
      }
      $black_body = request( 'black_body' );
      $black_text = array();
      if ( is_array( request( "black_body" ) ) ) {
        for ( $a = 0; $a < count( $black_body ); $a++ ) {
          if ( $black_body[ $a ] != "" ) {
            $black_text[] = array(
              "black_body" => $black_body[ $a ],
            );
          }
        }
        $black_text = json_encode( $black_text );
      }

        if (validate_date(request("date")) and request("date") !="") {
            $date = implode('-', array_reverse(explode('/', request('date'))));
            // $date = explode("/", request('date'));
            // $date = $date[2]."-".$date[1]."-".$date[0];
        }else{
            $date = Null;
        }
      $black_text = (!empty($black_text)) ? $black_text : NULL ; 
      $green_text = (!empty($green_text)) ? $green_text : NULL ; 
      $red_text = (!empty($red_text)) ? $red_text : NULL ; 
		//dd(request( 'date' ));
      if ( request()->has( "submit" ) ) {
        $data = array();
        $data[ "title" ] = request( 'title' );
        $data[ "slug" ] = Str::slug(request( 'slug' ), '-');
        $data[ "meta_title" ] = request( 'meta_title' );
        $data[ "meta_description" ] = request( 'meta_description' );
        $data[ "meta_tags" ] = request( 'meta_tags' );
        $data[ "cover" ] = request( 'cover-image' );
        $data[ "og_image" ] = request( 'og-image' );
        $data[ "status" ] = request( 'status' );
        $data[ "author" ] = request( 'author' );
        $data[ "category" ] = request( 'category' );
        $data[ "user_type" ] = request( 'user_type' );
        $data[ "national" ] = request( 'national' );
        $data[ "province" ] = request( 'province' );
        $data[ "district" ] = request( 'district' );
        $data[ "related" ] = $related;
        $data[ "faqs" ] = $faqs;
        $data[ "green_text" ] = $green_text;
        $data[ "red_text" ] = $red_text;
        $data[ "black_text" ] = $black_text;
        $data[ "status" ] = request( 'submit' );
        $data[ "content" ] = request( 'content' );
        $data[ "date" ] = $date;
        $data[ "microdata" ] = $schema;
        // dd($data);
        if ( request()->has( 'id' ) ) {
          DB::table( 'news' )->where( 'id', request( 'id' ) )->update( $data );
          return back()->with( 'flash_message', 'News Record Updated Successfully' );
        } else {
          $id = DB::table( 'news' )->insertGetId( $data );
          return redirect( route( 'news-create' ) . '?edit=' . $id )->with( 'success', 'News Record Inserted Successfully' );
        }
      }
    } else {
      if ( request( 'edit' ) ) {
        $id = request( 'edit' );
        $data = DB::table( 'news' )->where( 'id', $id )->first();
        return view( 'admin.news.news', compact( 'data' ) );
      }
      if ( request( 'delete' ) ) {
        $id = request( 'delete' );
        $data = DB::table( 'news' )->where( 'id', $id )->delete();
        return back()->with( 'flash_message', 'News Post is deleted Successfully' );
      }
      if ( request( 'publish' ) ) {
        $id = request( 'publish' );
        DB::table( 'news' )->where( 'id', $id )->update( [ 'status' => 'publish' ] );
        return redirect( '/' . admin . '/news/list' )->with( 'flash_message', 'News Post Status is Changed To Publish Successfully' );
      }
      if ( request( 'draft' ) ) {
        $id = request( 'draft' );
        DB::table( 'news' )->where( 'id', $id )->update( [ 'status' => 'draft' ] );
        return redirect( '/' . admin . '/news/list' )->with( 'flash_message2', 'News Post Status is Changed To Draft Successfully' );
      }
      return view( 'admin.news.news' );
    }
  }
  public function newsList() {
    $username = Auth::user()->username;
    $user = DB::table('admin')->where('username',$username)->first();
    // dd($user);
    if ( request()->has( "st" ) ) {
      $st = request( 'st' );
      if($user->type == 'district'){
        $data = News::where( 'status', '=', $st )->where(['user_type'=>$user->type,'district'=>$user->dept_id])->orderBy( 'id', 'DESC' )->paginate( 10 );
      }elseif($user->type == 'province'){
        $data = News::where( 'status', '=', $st )->where(['province'=>$user->dept_id])->orderBy( 'id', 'DESC' )->paginate( 10 );
      }elseif($user->type == 'national'){
        $data = News::where( 'status', '=', $st )->where(['user_type'=>$user->type])->orderBy( 'id', 'DESC' )->paginate( 10 );        
      }else{
        $data = News::where( 'status', '=', $st )->orderBy( 'id', 'DESC' )->paginate( 10 );  
      }

    } else {
      if($user->type == 'district'){
//        DB::enableQueryLog();
        $data = News::where(['user_type'=>$user->type,'district'=>$user->dept_id])->orderBy( 'id', 'DESC' )->paginate(10);
//        dd(DB::getQueryLog());
      }elseif($user->type == 'province'){
        $data = News::where(['province'=>$user->dept_id])->orderBy( 'id', 'DESC' )->paginate(10);
        // dd($data);
      }elseif($user->type == 'national'){
        $data = News::where(['user_type'=>$user->type])->orderBy( 'id', 'DESC' )->paginate(10);        
      }else{
        $data = News::orderBy( 'id', 'DESC' )->paginate(10);  
      }
    }
    return view( 'admin.news.news_list', compact( 'data' ) );
  }
}
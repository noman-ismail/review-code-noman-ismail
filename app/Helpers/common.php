<?php

use Illuminate\Support\Facades\DB;
function abortit() {
    return redirect()->action('Main_Ctrl@index');
}

function script_redirect($url){
	echo "
		<script>
			window.location = '$url';
		</script>
	";
}
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);
  // trim
  $text = trim($text, '-');
  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);
  // lowercase
  $text = strtolower($text);
  if (empty($text)) {
    return '';
  }
  return $text;
}
function sendEmail($Mail, $view, $data){
    if (!array_key_exists('reply_to', $data)) {
        $data['reply_to'] = $data['from']['email'];
    }
	$Mail::send($view, $data, function ($message) use ($data) {
        $newString = str_replace(" ","",$data["to"]["email"]);
        $cc = explode(',', $newString);
		$from_email = $data["from"]["email"];
		$from_label = $data["from"]["label"];
		$to_email = $cc;
		$to_label = $data["to"]["label"];
		$subject = $data["subject"];
		$message->to($to_email)->subject($subject);
        $message->replyTo($data['reply_to'], $from_label);
	});
}
function about_cabinet_short_codes($content='',$data=array() , $check=array(), $panel="")
{
    preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
    $matches = (isset($matches[1])) ? $matches[1] : array();
    $r = "";
    foreach($matches as $k=>$v){
        if($v == 'highlight'){
            $r = get_highligh_box($check,$panel);
        }elseif($v == 'pink-section'){
            $r = get_pink_box($data);
        }
        if($r !=""){
            $content = str_replace("[[$v]]", $r, $content);
        }
    }
     return $content;
}


function get_highligh_box($check = array() , $panel = "")
{
    if($panel == 'cities'){
        if(!empty($check)){
            $data = DB::table('event')->where(['user_type'=>'district','district'=>$check->id])->orderby('id','desc')->paginate(6);
            return view('front.temp.highlight',compact('data'));
        }else{
            return "&nbsp;";
        }
    }elseif($panel == 'province'){
        if(!empty($check)){
            $data = DB::table('event')->where(['user_type'=>'province','province'=>$check->id])->orderby('id','desc')->paginate(6);
            return view('front.temp.highlight',compact('data'));
        }else{
            return "&nbsp;";
        }
    }elseif($panel == 'national'){
        if(!empty($check)){
            $data = DB::table('event')->where(['user_type'=>'national'])->orderby('id','desc')->paginate(6);
            return view('front.temp.highlight',compact('data'));
        }else{
            return "&nbsp;";
        }
    }else{
        return "&nbsp;";
    }
}
function get_pink_box($data='')
{
    if(!empty($data)){
        $body = '<div class="pink-box">
                    <h3 class="text-center">';
        $body .= $data->heading;
        $body .= '<span class="decor-line">
                    <em class="star">
                        <i class="icon-star-full"></i>
                    </em>
                </span>
            </h3>
            <p>';
        $body .= $data->body;
        $body .= '</p>
            </div>';
        return $body;
    }else{
        return "";
    }
}
function get_postid($get = "slug") {
    $segment = request()->segment(1);
    $route = $segment;
    $exp = explode("-", $route);
    $last_id = end($exp);
    $page_id = substr($last_id, 0, 1);
    $post_id = substr($last_id, 1, 1000);
    $cat_id = substr($post_id, 0, 3);
    $slug = str_replace("-" . $last_id, "", $route);
    $seg = array(
        "full" => $route,
        "last_id" => $last_id,
        "page_id" => (is_numeric($page_id)) ? $page_id : 0,
        "post_id" => $post_id,
        "cat_id" => $cat_id,
        "slug" => $slug,
        "type" => ((is_numeric($last_id)) ? "int" : "string"),
    );
    if ($get == "") {
        return "";
    } else {
        return $seg[$get];
    }
}
function get_postid2($get = "slug") {
    $segment = request()->segment(2);
    $route = $segment;
    $exp = explode("-", $route);
    $last_id = end($exp);
    $page_id = substr($last_id, 0, 1);
    $post_id = substr($last_id, 1, 1000);
    $cat_id = substr($post_id, 0, 3);
    $slug = str_replace("-" . $last_id, "", $route);
    $seg = array(
        "full" => $route,
        "last_id" => $last_id,
        "page_id" => $page_id,
        "post_id" => $post_id,
        "cat_id" => $cat_id,
        "slug" => $slug,
        "type" => ((is_numeric($last_id)) ? "int" : "string"),
    );
    if ($get == "") {
        return "";
    } else {
        return $seg[$get];
    }
}
function is_valid_redirect() {
    $slug = get_postid("slug");
    $page_id = get_postid("page_id");
    $last_id = get_postid("post_id");
    $table_id = substr($last_id, 0, 3);
    $post_id = substr($last_id, 3);
    if ($page_id == 1) {
        $result = DB::select('select * from mobile_mobile_phones where id = ' . $post_id);
        if (empty($result)) {
            redirect(abort(404));
            exit();
        }
        $slg = str_slug($result[0]->title);
        $url = "/" . $slg . "-1" . $result[0]->page_id . $post_id;
        if ($slg != $slug) {
            return array($url);
        } elseif ($slg == "") {
            redirect(abort(404));
        }
    }
    if ($page_id == 2) {
        $result = \App\category::find($table_id);
        if (empty($result)) {
            redirect(abort(404));
            exit();
        }
        $slg = $result->slug;
        $url = "/" . $slg . "-2" . $table_id;
        if ($slg != $slug) {
            return array($url);
        } elseif ($slg == "") {
            redirect(abort(404));
        }
    }
	if ($page_id == 3) {
        $result = \App\User::find($table_id);
        if (empty($result)) {
			$url = route("base_url")."/404";
			return $url;
            
        }
        $slg = str_slug($result->name);
        $url = route("base_url")."/" . $slg . "-3" . $table_id;
        if ($slg != $slug) {
            return $url;
        } elseif ($slg == "") {
            redirect(abort(404));
        }
    }
}
function get_cat_name($id){
	$r = DB::table("blogcats")->where('id',$id)->select("title")->first();
	if(is_object($r)){
		return $r->title;
	}
}
function unslash( $value ) {
    if ( is_array( $value ) ) {
        foreach ( $value as $k => $v ) {
            if ( is_array( $v ) ) {
                $value[$k] = unslash( $v );
            } else {
                $value[$k] = stripslashes( $v );
            }
        }
    } else {
        $value = stripslashes( $value );
    }
    return $value;
}
function trim_words( $text, $num_words = 55, $more = null ) {
    if ($more ==null) {
        $more = '&hellip;';
    }
    $original_text = $text;
    $text = strip_tags( $text );
    $text = strip_tags( $text );
    $words_array = preg_split( "/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY );
    $sep = ' ';
    if ( count( $words_array ) > $num_words ) {
        array_pop( $words_array );
        $text = implode( $sep, $words_array );
        $text = $text . $more;
    } else {
        $text = implode( $sep, $words_array );
    }
    return $text;
}
function sort_by_time($a,$b)
{
  $a_time = strtotime($a->created_at);
  $b_time = strtotime($b->created_at);
  return $a_time < $b_time;
}

function sanitize_title($title, $raw_title = '', $context = 'display') {
    $title = strip_tags($title);
    // Preserve escaped octets.
    $title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
    // Remove percent signs that are not part of an octet.
    $title = str_replace('%', '', $title);
    // Restore octets.
    $title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
    $title = strtolower($title);
    $title = preg_replace('/&.+?;/', '', $title); // kill entities
    $title = str_replace('.', '-', $title);
    if ('save' == $context) {
        // Convert nbsp, ndash and mdash to hyphens
        $title = str_replace(array('%c2%a0', '%e2%80%93', '%e2%80%94'), '-', $title);
        // Strip these characters entirely
        $title = str_replace(array(
            // iexcl and iquest
            '%c2%a1', '%c2%bf',
            // angle quotes
            '%c2%ab', '%c2%bb', '%e2%80%b9', '%e2%80%ba',
            // curly quotes
            '%e2%80%98', '%e2%80%99', '%e2%80%9c', '%e2%80%9d',
            '%e2%80%9a', '%e2%80%9b', '%e2%80%9e', '%e2%80%9f',
            // copy, reg, deg, hellip and trade
            '%c2%a9', '%c2%ae', '%c2%b0', '%e2%80%a6', '%e2%84%a2',
            // acute accents
            '%c2%b4', '%cb%8a', '%cc%81', '%cd%81',
            // grave accent, macron, caron
            '%cc%80', '%cc%84', '%cc%8c',
        ), '', $title);
        // Convert times to x
        $title = str_replace('%c3%97', 'x', $title);
    }
    $title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
    $title = preg_replace('/\s+/', '-', $title);
    $title = preg_replace('|-+|', '-', $title);
    $title = trim($title, '-');
    return $title;
}
function full_editor(){
    ?>
    <script src="<?php echo route("base_url"); ?>/admin-assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        function _full_Ed(){
             tinymce.init({
             setup: function(editor) {
                editor.on("init", function(){
                    editor.shortcuts.remove('ctrl+s');
                });
            },
             mode : "specific_textareas",
            editor_selector: "oneditor",
            plugins: [
                 "advlist autolink link image lists charmap preview hr anchor pagebreak spellchecker",
                 "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
                 "table contextmenu directionality emoticons template paste textcolor"
           ],
				 rel_list: [
{title: 'None', value: ''},
{title: 'No Referrer', value: 'noreferrer'},
{title: 'No Opener', value: 'noopener'},
{title: 'No Follow', value: 'nofollow'}
],
target_list: [
{title: 'None', value: ''},
{title: 'Same Window', value: '_self'},
{title: 'New Window', value: '_blank'},
{title: 'Parent frame', value: '_parent'}
	],
           toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | blockquote preview media | forecolor backcolor emoticons", 
           theme_advanced_path : false,
           relative_urls : false,
           remove_script_host : false,
           theme_advanced_resizing: true,
           forced_root_block : 'div',
           formats: {
            blockquote: [
               {block: 'blockquote', attributes: {'class': 'center'}, wrapper: true, remove: 'all'},
               {block: 'blockquote', attributes: {'class': 'pull-left'}},
               {block: 'blockquote', attributes: {'class': 'pull-right'}}
            ],
            cite: {block: 'cite'},
            pullquote_left: {selector: 'blockquote', attributes: {'class': 'pull-left'}, remove: 'all'},
            pullquote_right: {selector: 'blockquote', attributes: {'class': 'pull-right'}, remove: 'all'},
            pullquote_center: {selector: 'blockquote', attributes: {'class': 'center'}, remove: 'all'}
          },
           style_formats: [
                {title: 'Bold text', inline: 'b'},
                {title: 'Header 1', block: 'h1'},
                {title: 'Header 2', block: 'h2'},
                {title: 'Header 3', block: 'h3'},
                {title: 'Header 4', block: 'h4'},
                {title: 'Header 5', block: 'h5'},
                {title: 'Header 6', block: 'h6'},
                {title: 'Blockquote', format: 'blockquote'},
                {title: 'Cite', format: 'cite'}
            ]
         });
        }
        _full_Ed();
    </script>
   <?php    
}
function tiny_editor(){

    ?>
    <script src="<?php echo route("base_url"); ?>/admin-assets/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
        function __tinyEd(){
            tinymce.init({
            mode : "specific_textareas",
            editor_selector: "tinyeditor",
            menubar:false,
            statusbar: false,
            plugins: [
            'advlist autolink lists link image charmap anchor',
            'searchreplace',
            'media table',
            'paste',
            
          ],
          toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link',
         paste_auto_cleanup_on_paste : true,
         paste_remove_styles: true,
         paste_remove_styles_if_webkit: true,
         paste_strip_class_attributes: true,
          forced_br_newline : true,
          force_br_newlines : false,
          force_p_newlines : false,
          forced_root_block : 'div',
         }); 
        }
        __tinyEd();
    </script>
<?php   
}


function nofollow($html, $skip = null) {
    return preg_replace_callback(
        "#(<a[^>]+?)>#is", function ($mach) use ($skip) {
            return (
                !($skip && strpos($mach[1], $skip) !== false) &&
                strpos($mach[1], 'rel=') === false
            ) ? $mach[1] . ' rel="nofollow">' : $mach[0];
        },
        $html
    );
}



/* Start File Functions*/
//Check image type of valid or not.
function is_valid_image($image = ""){
	$s = false;
	if (is_file($image)){
		$allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/webp'];
		$contentType = mime_content_type($image);
		if(in_array($contentType, $allowedMimeTypes) ){
			$s = true;	
		}
	}
	return $s;
}

function no_post_image(){
    $path = base_path();
    $noimage = route("base_url")."/images/default-img.png";
    return $noimage;
}
function is_image($image=""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $image='/images/'."$file";
        if(file_exists($path.$image)){
             return $image;
        }else{
            return no_post_image();
        }
    }
}
function get_image($image=""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        $full='/images/'."$rep.$ext";
        if(file_exists($path.$full)){
            $rep = route("base_url").$full;
        }elseif(file_exists($path.$full)){
            $rep = route("base_url").$full;
        }else{
            $rep = "";
        }
        
        return $rep;
    }
}

function get_post_thumbnail($image="" , $default = ""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{
        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        
        $d = DB::table("media")->whereRaw("images like '%$rep%'")->first();
        $mid = "";
        $thumb = "";
        if(isset($d->id)){
            $images = json_decode($d->images, true);
            $thumb = "/images/".$images["100"];
            $mid = "/images/".$images["300"];
        }else{
            $full = '/images/'.$rep.".$ext";    
        }
        if(file_exists($path.$thumb) and $thumb!=""){
            $rep = url($thumb);
        }elseif(file_exists($path.$mid) and $mid!=""){
            $rep = url($mid);
        }elseif(file_exists($path.$full) and $full!=""){
            $rep = url($full);
        }else{
            $rep = "";
        }
        $rep = ($rep!="") ? $rep : $default;
        $rep = ($rep=="") ? no_post_image() : $rep;
        return $rep;
    }
}
function get_post_mid($image="",  $default = ""){
    $path = base_path();
    if ($image==""){
        return no_post_image();
    }else{

        $exp = explode("/", $image);
        $file = end($exp);
        $exp = explode(".", $file);
        $ext = end($exp);
        $rep = str_replace(".$ext", "",$file);
        
        $d = DB::table("media")->whereRaw("images like '%$rep%'")->first();
        $mid = "";
        $full = "";
        if(isset($d->id)){
            $images = json_decode($d->images, true);
            $mid = (array_key_exists('300', $images))?"/images/".$images["300"]:"";
        }else{
            $full = '/images/'.$rep.".$ext";    
        }
        if(file_exists($path.$mid) and $mid!=""){
            $rep = url($mid);
        }elseif(file_exists($path.$full) and $full!=""){
            $rep = url($full);
        }else{
            $rep = "";
        }
        $rep = ($rep!="") ? $rep : $default;
        $rep = ($rep=="") ? no_post_image() : $rep;
        return $rep;
    }
}


// Sanitize file name
function sanitize_file_name( $filename ) {
	$filename_raw = $filename;
	$special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", "%", "+", chr(0));
	$filename = preg_replace( "#\x{00a0}#siu", ' ', $filename );
	$filename = str_replace( $special_chars, '', $filename );
	$filename = str_replace( array( '%20', '+' ), '-', $filename );
	$filename = preg_replace( '/[\r\n\t -]+/', '-', $filename );
	$filename = trim( $filename, '.-_' );
	$parts = explode('.', $filename);
	$filename = array_shift($parts);
	$extension = array_pop($parts);
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'gif' => 'image/gif',
		'png' => 'image/png',
		'bmp' => 'image/bmp');
	foreach ( (array) $parts as $part) {
		$filename .= '.' . $part;
		if ( preg_match("/^[a-zA-Z]{2,5}\d?$/", $part) ) {
			$allowed = false;
			foreach ( $mimes as $ext_preg => $mime_match ) {
				$ext_preg = '!^(' . $ext_preg . ')$!i';
				if ( preg_match( $ext_preg, $part ) ) {
					$allowed = true;
					break;
				}
			}
			if ( !$allowed )
				$filename .= '_';
		}
	}
	$filename .= '.' . $extension;
	return $filename;
}

// Generate Unique Filename
function unique_filename( $dir, $filename, $dimen="" ) {
	// Sanitize the file name before we begin processing.
    $filename = strtolower(sanitize_file_name(trim($filename)));
	
    // Separate the filename into a name and extension.
    $ext = pathinfo( $filename, PATHINFO_EXTENSION );
    $name = pathinfo( $filename, PATHINFO_BASENAME );
    $org_filename = pathinfo( $filename, PATHINFO_FILENAME);
    if ( $ext ) {
        $ext = '.' . $ext;
    }
 
    // Edge case: if file is named '.ext', treat as an empty name.
    if ( $name === $ext ) {
        $name = '';
    }
	$number = 0;
	$dm = $dimen;
	$file = $dir . "$filename" ;
	while ( file_exists( $dir . "$filename" ) ) {
		$filename = str_replace( array( "-$number$ext", "$ext" ), "-" . ++$number ."". $ext, $filename );
	}
	if ($number==""){
		$filename = $org_filename;	
	}else{
		$filename = $org_filename."-$number";
	}
	return $filename;
}
function  get_catByname($category = array()){
    $res = array();
    $cat = explode("," , $category);
    $id = $cat[0];
    $res =  DB::table('blogcats')->select('id' , 'title' , 'slug')->where('id' , $id)->first();
    return $res->title;  
}
function  get_catUrl($category = array()){
    $res = array();
    $cat = explode("," , $category);
    $id = $cat[0];
    $res =  DB::table('blogcats')->select('id' , 'title' , 'slug')->where('id' , $id)->first();
    $url = route("base_url")."/".$res->slug."-4".$res->id;
    return $url;  
}
function search_toc_pattren($keyword="", $content=""){
    $pattren = "/([[)($keyword+)(]])(.+)(\[\[\/)($keyword+)(\]\])/";
    preg_match_all($pattren, $content, $matches, PREG_OFFSET_CAPTURE);
    return $matches;
}

function table_of_content($content = ""){
    $table = "";
    $pattren = "/([[)(t[0-9]+)(]])(.+)(\[\[\/)(t[0-9]+)(\]\])/";
    $matches = search_toc_pattren("t[0-9]", $content);
  $all_pattren = array();
  if (count($matches[1]) > 0){
      $table.="<ul class='outer'>";
      foreach($matches[1] as $k=>$v){
          $open_tag = "[[".$matches[5][$k][0]."]]";
          $close_tag = "[[/".$matches[5][$k][0]."]]";
          $ft = Str::slug($matches[3][$k][0]);
          $span = "<span id='$ft'></span>";
          $content = str_replace($open_tag,$span,$content);
          $content = str_replace($close_tag,"",$content);
          $main = $matches[3][$k][0];
          $ar_main = explode(" ", $main);
          $li_text = "";
          foreach ($ar_main as $ab => $value) {
            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
            if ($ab< count($ar_main)) {
                    $li_text .=" ";
                }
          }
          $table.="<li class='nav-item'><span class='hvr'><a class='smooth-goto nav-link' href='#$ft'> <span class='no'>".($k+1). "&nbsp;-&nbsp;". "</span>$li_text</a></span>";
          
          $st  = $matches[5][$k][0];
          $st  = "$st-s[0-9]";
          $matches_s = search_toc_pattren($st, $content);
         if (count($matches_s[1]) > 0){
             
             $table .="<ul class='nested-1'>";
             foreach($matches_s[1] as $sk=>$sv){
                  $open_tag = "[[".$matches_s[5][$sk][0]."]]";
                  $close_tag = "[[/".$matches_s[5][$sk][0]."]]";
                  $ft = Str::slug($matches_s[3][$sk][0]);
                  $span = "<span id='$ft'></span>";
                  $content = str_replace($open_tag,$span,$content);
                  $content = str_replace($close_tag,"",$content);
                  $main = $matches_s[3][$sk][0];
                  $ar_main = explode(" ", $main);
                  $li_text = "";
                  foreach ($ar_main as $ab => $value) {
                    $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                    if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                  }
                  //$matches_s[4][$sk][0]."<br>";
                 $table.="<li class='nav-item'><span class='hvr'><a class='smooth-goto nav-link' href='#$ft'> <span class='no'>".($k+1).".".($sk+1)."&nbsp;-&nbsp;". "</span>".$li_text."</a></span>";
                  
                  $ct  = $matches_s[5][$sk][0];
                  $ct  = "$ct-c[0-9]";
                  $matches_c = search_toc_pattren($ct, $content);
                  if (count($matches_c[1]) > 0){
                     $table .="<ul class='third'>";
                    foreach($matches_c[1] as $kc=>$vc){
                        $open_tag = "[[".$matches_c[5][$kc][0]."]]";
                        $close_tag = "[[/".$matches_c[5][$kc][0]."]]";
                        $ft = Str::slug($matches_c[3][$kc][0]);
                        $span = "<span id='$ft'></span>";
                        $content = str_replace($open_tag,$span,$content);
                        $content = str_replace($close_tag,"",$content);
                        $main = $matches_c[3][$kc][0];
                        $ar_main = explode(" ", $main);
                        $li_text = "";
                        foreach ($ar_main as $ab => $value ) {
                            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                            if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                        }
                        $table.="<li class='li-end'><a  href='#$ft' class='flex align-items-start smooth-goto'> <span>".($k+1).".".($sk+1).".".($kc+1). "&nbsp;-&nbsp;"."</span>".$li_text."</a></li>";
                    } 
                      $table .="</ul>";
                  }
                 $table.="</li>";
             }
             $table.="</ul>";
         }
           $table.="</li>";
      }
      $table.="</ul>";
  }
    return array("content"=>$content, "table"=>$table);
}
function table_of_content2($content = ""){
    $table = "";
    $pattren = "/([[)(t[0-9]+)(]])(.+)(\[\[\/)(t[0-9]+)(\]\])/";
    $matches = search_toc_pattren("t[0-9]", $content);
    $all_pattren = array();
    if (count($matches[1]) > 0){
      $table.="<ol class='outer'>";
      foreach($matches[1] as $k=>$v){
          $open_tag = "[[".$matches[5][$k][0]."]]";
          $close_tag = "[[/".$matches[5][$k][0]."]]";
          $ft = Str::slug($matches[3][$k][0]);
          $span = "<span id='$ft'></span>";
          $content = str_replace($open_tag,$span,$content);
          $content = str_replace($close_tag,"",$content);
          $main = $matches[3][$k][0];
          $ar_main = explode(" ", $main);
          $li_text = "";
          foreach ($ar_main as $ab => $value) {
            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
            if ($ab< count($ar_main)) {
                    $li_text .=" ";
                }
          }
          
          $table.="<li><a href='#$ft'class='smooth-goto'>$li_text</a>";
          
          $st  = $matches[5][$k][0];
          $st  = "$st-s[0-9]";
          $matches_s = search_toc_pattren($st, $content);
         if (count($matches_s[1]) > 0){
             
             $table .="<ol  class='nested-1'>";
             foreach($matches_s[1] as $sk=>$sv){
                  $open_tag = "[[".$matches_s[5][$sk][0]."]]";
                  $close_tag = "[[/".$matches_s[5][$sk][0]."]]";
                  $ft = Str::slug($matches_s[3][$sk][0]);
                  $span = "<span id='$ft'></span>";
                  $content = str_replace($open_tag,$span,$content);
                  $content = str_replace($close_tag,"",$content);
                  $main = $matches_s[3][$sk][0];
                  $ar_main = explode(" ", $main);
                  $li_text = "";
                  foreach ($ar_main as $ab => $value) {
                    $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                    if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                  }
                  //$matches_s[4][$sk][0]."<br>";
                  $table.="<li><a href='#$ft' class='smooth-goto'>".$li_text."</a>";
                  
                  $ct  = $matches_s[5][$sk][0];
                  $ct  = "$ct-c[0-9]";
                  $matches_c = search_toc_pattren($ct, $content);
                  if (count($matches_c[1]) > 0){
                     $table .="<ol  class='nested-1'>";
                    foreach($matches_c[1] as $kc=>$vc){
                        $open_tag = "[[".$matches_c[5][$kc][0]."]]";
                        $close_tag = "[[/".$matches_c[5][$kc][0]."]]";
                        $ft = Str::slug($matches_c[3][$kc][0]);
                        $span = "<span id='$ft'></span>";
                        $content = str_replace($open_tag,$span,$content);
                        $content = str_replace($close_tag,"",$content);
                        $main = $matches_c[3][$kc][0];
                        $ar_main = explode(" ", $main);
                        $li_text = "";
                        foreach ($ar_main as $ab => $value ) {
                            $li_text .= (strlen(trim($value)) >3) ? ucwords($value) : $value;
                            if ($ab< count($ar_main)) {
                                $li_text .=" ";
                            }
                        }
                        $table.="<li><a href='#$ft' class='smooth-goto'>".$li_text."</a></li>";
                    } 
                      $table .="</ol>";
                  }
                 $table.="</li>";
             }
             $table.="</ol>";
         }
           $table.="</li>";
      }
      $table.="</ol>";
  }
    return array("content"=>$content, "table"=>$table);
}
    function excape_words(){

        $r = array("is", "am", "are", "might", "a", "an", "the", "what", "it", "this", "that", "those", "there", "i", "my", "me", "mine", "for" , "your" ,"you" ,"of", "for" ,"the" ,"there" ,"will" ,"shall","go","who","in" ,"to" ,"?" ,"should" , "why" , "your" , "," , "-" , ":" , "_" , "|");

        return $r;

    }
    function get_related_post($limit , $tables, $id, $titles = array() , $tags = array()){
        $excape  = excape_words();
        $ts = array();
        $joins = array_merge($titles, $tags);
        foreach($joins as $k=>$v){
            if (!in_array(strtolower($v), $excape)){
                if (trim($v)!=""){
                    $ts[] = " title like '%$v%' OR meta_tags like '%$v%' ";
                }
            }
        }
        $titles = [];
        if (count($ts) > 0){
            $titles = implode(" or ", $ts);
        }
        $titles = " and ($titles)";
        $query  = "select * from $tables WHERE status = 'publish' $titles  order by rand() limit $limit";

        $r = DB::select( $query );
        $d=" ";
        if (count($r) > 0){
            $d = "<h4><i class='icon-pencil'></i> Related Articles</h4>";
            $d .="<ul class='related-post'>";
            foreach($r as $k=>$v){
                    $link = route("base_url")."/".$v->slug."-2".$v->id;
                    $d.="<li><a  href='$link' target='_blank' >$v->title</a></li>";
            }
            $d.="</ul>";
        }
        return $d;

    }
    function get_related_post2($limit , $tables, $id, $titles = array() , $tags = array()){
        $icon = route("base_url")."/amp-img/arrow.svg";
        $excape  = excape_words();
        $ts = array();
        $joins = array_merge($titles, $tags);
        foreach($joins as $k=>$v){
            if (!in_array(strtolower($v), $excape)){
                if (trim($v)!=""){
                    $ts[] = " title like '%$v%' OR meta_tags like '%$v%' ";
                }
            }
        }
        $titles = [];
        if (count($ts) > 0){
            $titles = implode(" or ", $ts);
        }
        $titles = " and ($titles)";
        $query  = "select * from $tables WHERE id !=$id and status = 'publish' $titles  order by rand() limit $limit";

        $r = DB::select( $query );
        $d=" ";
        if (count($r) > 0){
            $d = "<div class='row related-row'>";
            $d .="<h5 class='text-capitalize pl-3'>You may also Like these posts</h5>";
            $d .="<ul class='nav pl-5'>";
            foreach($r as $k=>$v){
                    $link = route("base_url")."/".$v->slug."-2".$v->id;
                    $d.="<li class='nav-item'><a href='$link' target='_blank'  class='nav-link' ><span class='icon'><i class='icon-chright'></i></span><span class='text'>$v->title</span></a></li>";
            }
            $d.="</ul>";
            $d.="</div>";
        }
        return $d;

    }
    function _get_faqs($num , $id , $tables){
        $res =  DB::table($tables)->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("-" , $num);
         $start = $num[0]-1;
         $end = $num[1] - $start;
         $data = array_slice($data, $start, $end);
		//dd($data);
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }    
    function _getFaqs($num , $id , $tables){
         $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("," , $num);
         $ndata = array();
         foreach ($num as $k => $v) {
             $n = $v-1;
           if(array_key_exists($n, $data)){
                $ndata[] = $data[$n];
           }
         }
        $data = $ndata;
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs', compact( 'data' ) );
        }else{
            $d="";
        }
       return $d;
    }
    function get_faqs($num , $id ){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs', compact( 'data' ) );
        }else{
            $d=" ";
        }
       return $d;
    }
     function _get_faqs2($num , $id){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("-" , $num);
         $start = $num[0]-1;
         $end = $num[1] - $start;
         $data = array_slice($data, $start, $end);
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs-amp', compact( 'data' ) );
        }else{
            $d="";
        }
        return $d;
    }
    function get_faqs2($num , $id){
        $res =  DB::table('blogs')->select('faqs')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->faqs , true) : array();
         $num =  explode("," , $num);
         $ndata = array();
         foreach ($num as $k => $v) {
             $n = $v-1;
           if(array_key_exists($n, $data)){
                $ndata[] = $data[$n];
           }
         }
        $data = $ndata;
        if (count($data) > 0 ) {
            $d = view( 'front.temp.faqs-amp', compact( 'data' ) );
        }else{
            $d="";
        }
       return $d;
    }
   function get_green($num , $id , $tables){
        $res =  DB::table($tables)->select('green_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->green_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.green', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function welfare_greenbox($num ){
        $res =  DB::table('welfare_benefits')->select('green_text')->first();
         $data   = isset($res)? json_decode($res->green_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.welfare-greenbox', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function welfare_blackbox(){
        $res =  DB::table('welfare_benefits')->select('black_text' , 'green_text')->first();
         $data   = isset($res)? $res : array();
        if (isset($data)) {
            $data = $data;
            $d = view( 'front.temp.welfare-content', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
     function get_red($num , $id , $table){
        $res =  DB::table($table)->select('red_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->red_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.red', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_black($num , $id , $table){
        $res =  DB::table($table)->select('black_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->black_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.black', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_green2($num , $id){
        $res =  DB::table('blogs')->select('green_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->green_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.green-amp', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
     function get_red2($num , $id){
        $res =  DB::table('blogs')->select('red_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->red_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.red-amp', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_black2($num , $id){
        $res =  DB::table('blogs')->select('black_text')->where('id' , $id)->first();
         $data   = isset($res)? json_decode($res->black_text , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $d = view( 'front.temp.black-amp', compact( 'data' ) );
        }else{
            $d=" ";
        }
        return $d;
    }
    function get_ads($num , $id){
        $res =  DB::table('ads')->select('ads')->first();
         $data   = isset($res)? json_decode($res->ads , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $url = ($data['url'] !="") ? $data['url'] : "";
            $img = ($data['img'] !="") ? $data['img'] : "";
            $title = ($data['title'] !="") ? $data['title'] : "";
            $alt = ($data['alt'] !="") ? $data['alt'] : "";
             $opt = array(
            "image" => $img,
            "type" => "main",
          );
          $img =  get_post_attachment($opt);
            $d = "<div class='ads-img'>";
                $d .="<a href='$url' title ='$title' target='_blank'> <img class='img-fluid w-100 lazy img-thumbnail' src='$img'  alt='$alt'></a>";
            $d .="</div>";
        }else{
           $d = "";
        }
        return $d;
    }
    function get_youtube($num , $id){
        $res =  DB::table('blogs')->where('id' , $id)->select('links')->first();
         $data   = isset($res)? json_decode($res->links , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $url = ($data['u_links'] !="") ? $data['u_links'] : "";
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            $v=$query['v'];
            $d = "<div class='u-wrapper'>";
                $d .="<div class='youtube' data-embed='$v' >";
                $d .="<div class='play-button'></div>";
                $d .="</div>";
            $d .="</div>";
        }else{
           $d = "";
        }
        return $d;
    }
    function get_youtube2($num , $id){
        $res =  DB::table('blogs')->where('id' , $id)->select('links')->first();
         $data   = isset($res)? json_decode($res->links , true) : array();
        if (isset($data[$num-1])) {
            $data = $data[$num-1];
            $url = ($data['u_links'] !="") ? $data['u_links'] : "";
            $parts = parse_url($url);
            parse_str($parts['query'], $query);
            $v=$query['v'];
            $d = "<amp-youtube
                  data-videoid='$v'
                  layout='responsive'
                  width='480'
                  height='270'
                ></amp-youtube>";
        }else{
           $d = "";
        }
        return $d;
    }

    function do_short_code($content,$id, $tables, $titles, $tags = array()){
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
              $matches = (isset($matches[1])) ? $matches[1] : array();
                  foreach($matches as $k=>$v){
                    $exp = explode(":", $v);
                    $r = "";
                    if ($exp[0]=="related"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_related_post("$e" , $tables, $id, $titles, $tags);
                      }
                    }elseif ($exp[0]=="faqs"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and strpos($e, '-') !== false){
                         $r= _get_faqs("$e" , $id , $tables);
                      }elseif(!empty($e) and strpos($e, ',') !== false){
                         $r= _getFaqs("$e" , $id , $tables);
                      }else{
                         $r= get_faqs("$e" , $id , $tables);
                      }
                    }elseif ($exp[0]=="green"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_green("$e" , $id , $tables);
                      }
                    }elseif ($exp[0]=="red"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_red("$e" , $id , $tables);
                      }
                    }elseif ($exp[0]=="black"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_black("$e" , $id , $tables);
                      }
                    }elseif ($exp[0]=="ads"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_ads("$e" , $id);
                      }
                    }elseif ($exp[0]=="youtube"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_youtube("$e" , $id);
                      }
                    }elseif ($v=="gallery"){
                         $r= get_gallery($id);
                    }elseif ($exp[0]=="talk"){
                         $r= talk_start($id);
                    }elseif ($exp[0]=="end-talk"){
                         $r= talk_end($id); 
                    }
                    if($r !=""){
                        $content = str_replace("[[$v]]", $r, $content);
                    }
                  }
         return $content;
    }
    function welfare_shortcode($content){
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
              $matches = (isset($matches[1])) ? $matches[1] : array();
                  foreach($matches as $k=>$v){
                    $exp = explode(":", $v);
                    $r = "";
                    if ($v=="black-green-box"){
                      if (!empty($v)){

                         $r= welfare_blackbox();
                      }
                    }elseif ($exp[0]=="black"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= welfare_blackbox("$e");
                      }
                    }

                    if($r !=""){
                        $content = str_replace("[[$v]]", $r, $content);
                    }
                  }
         return $content;
    }
    function do_short_code2($content,$id, $tables, $titles, $tags = array()){
        preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
              $matches = (isset($matches[1])) ? $matches[1] : array();
                  foreach($matches as $k=>$v){
                    $exp = explode(":", $v);
                    $r = "";
                    if ($exp[0]=="related"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_related_post2("$e" , $tables, $id, $titles, $tags);
                      }
                    }elseif ($exp[0]=="faqs"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and strpos($e, '-') !== false){
                         $r= _get_faqs2("$e" , $id);
                      }elseif(!empty($e) and strpos($e, ',') !== false){
                         $r= get_faqs2("$e" , $id);
                      }else{
                         $r= get_faqs2("$e" , $id);
                      }
                    }elseif ($exp[0]=="green"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_green2("$e" , $id);
                      }
                    }elseif ($exp[0]=="red"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_red2("$e" , $id);
                      }
                    }elseif ($exp[0]=="black"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_black2("$e" , $id);
                      }
                    }elseif ($exp[0]=="youtube"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_youtube2("$e" , $id);
                      }
                    }elseif ($exp[0]=="ads"){
                      $e  = (isset($exp[1])) ? $exp[1] : "";
                      if (!empty($e) and is_numeric($e)){
                         $r= get_ads("$e" , $id);
                      }
                    }elseif ($v=="gallery"){
                         $r= get_gallery($id);
                    }elseif ($exp[0]=="talk"){
                         $r= talk_start($id);
                    }elseif ($exp[0]=="end-talk"){
                         $r= talk_end($id); 
                    }
                    if($r !=""){
                        $content = str_replace("[[$v]]", $r, $content);
                    }
                  }
         return $content;
    }
    function clean_short_code($content = ""){
    // Remove TOC
    $content = str_replace("[[toc]]", "", $content);
    // Remove Table of Content Shortcode
    $content = table_of_content($content);
    $content = $content["content"];
    //Remove Related, download tags
    preg_match_all( '@\[([^<>&/\[\]\x00-\x20=]++)@', $content, $matches );
    $matches = (isset($matches[1])) ? $matches[1] : array();
    foreach($matches as $k=>$v){
        $exp = explode(":", $v);
        $r = "";
        if ($exp[0]=="related"){
          $e  = (isset($exp[1])) ? $exp[1] : "";
          if (!empty($e) and is_numeric($e)){
             $r = "";
          }
        }elseif ($exp[0]=="download"){
          $e  = (isset($exp[1])) ? $exp[1] : "";
          if (!empty($e) and is_numeric($e)){
             $r = "";
          }
        }elseif ($exp[0]=="ads"){
          $e  = (isset($exp[1])) ? $exp[1] : "";
          if (!empty($e) and is_numeric($e)){
             $r = "";
          }
        }
        $content = str_replace("[[$v]]", $r, $content);
    }
    return $content;
}
function clean($str)
{       
    $str = trim($str);
    return $str;
}
    function refresh_views($views = 0, $post_id, $page_id , $full ){
        if($full == ""){
            $full = "home";
             DB::table("homedata")->update(['views' => $views+1]);
            $today = date("y-m-d");
            $row = \App\Models\Views::where([
                        ['post_id', "=",$post_id],
                        ['page_id', "=",$page_id],
                        ['page_name', "=",$full],
                        ['view_date',"=", $today]
                    ])->get();
            if (count($row) == 0){
               \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
            }else{
                 $vid = $row[0]->id;
                 $views = $row[0]->views +1;
                 \App\Models\Views::where('id', $vid)->update(['views' => $views]);
            }
        }elseif($full == "about-us"){
            DB::table("about_us")->update(['views' => $views+1]);
            $today = date("y-m-d");
            $row = \App\Models\Views::where([
                        ['post_id', "=",$post_id],
                        ['page_id', "=",$page_id],
                        ['page_name', "=",$full],
                        ['view_date',"=", $today]
                    ])->get();
            if (count($row) == 0){
               \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
            }else{
                 $vid = $row[0]->id;
                 $views = $row[0]->views +1;
                 \App\Models\Views::where('id', $vid)->update(['views' => $views]);
            }
        }elseif($full == "welfare-benefits"){
            DB::table("welfare_benefits")->update(['views' => $views+1]);
            $today = date("y-m-d");
            $row = \App\Models\Views::where([
                        ['post_id', "=",$post_id],
                        ['page_id', "=",$page_id],
                        ['page_name', "=",$full],
                        ['view_date',"=", $today]
                    ])->get();
            if (count($row) == 0){
               \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
            }else{
                 $vid = $row[0]->id;
                 $views = $row[0]->views +1;
                 \App\Models\Views::where('id', $vid)->update(['views' => $views]);
            }
        }elseif($full == "terms-conditions"){
                DB::table("terms_conditions")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "privacy-policy"){
                 DB::table("privacies")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "faqs"){
                 DB::table("meta")->where("page_name" , "faqs")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "blogs"){
                 DB::table("meta")->where("page_name" , "blogs")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "events"){
                 DB::table("meta")->where("page_name" , "events")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "jobs"){
                 DB::table("meta")->where("page_name" , "jobs")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "news"){
                 DB::table("meta")->where("page_name" , "news")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "notifications"){
                 DB::table("meta")->where("page_name" , "notifications")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($full == "documents"){
                 DB::table("meta")->where("page_name" , "documents")->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['page_name', "=",$full],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 2){  
                $full = "event";  
                \App\Models\Event::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                    ['post_id', "=",$post_id],
                    ['page_id', "=",$page_id],
                    ['view_date',"=", $today]
                ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id , "page_name"=>$full ]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 1){
                $full = "jobs";
                \App\Models\jobs::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id , "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 3){
                $full = "blogs";
                \App\Models\Blogs::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 4){
                $full = "blogcats";
                \App\Models\blogcats::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id , "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }elseif($page_id == 5){
                $full = "news";
                \App\Models\News::where('id', $post_id)->update(['views' => $views+1]);
                $today = date("y-m-d");
                $row = \App\Models\Views::where([
                            ['post_id', "=",$post_id],
                            ['page_id', "=",$page_id],
                            ['view_date',"=", $today]
                        ])->get();
                if (count($row) == 0){
                   \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                }else{
                     $vid = $row[0]->id;
                     $views = $row[0]->views +1;
                     \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                }
            }else{
                if ($full == "pakistan") {
                    $today = date("y-m-d");
                    $row = \App\Models\Views::where([
                                ['post_id', "=",$post_id],
                                ['page_id', "=",$page_id],
                                ['page_name', "=",$full],
                                ['view_date',"=", $today]
                            ])->get();
                    if (count($row) == 0){
                       \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                    }else{
                         $vid = $row[0]->id;
                         $views = $row[0]->views +1;
                         \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                    }
                }else{
                    $check = DB::table('province')->where('slug',$full)->first();
                    if($check){
                        $today = date("y-m-d");
                        $row = \App\Models\Views::where([
                                    ['post_id', "=",$post_id],
                                    ['page_id', "=",$page_id],
                                    ['page_name', "=",$full],
                                    ['view_date',"=", $today]
                                ])->get();
                        if (count($row) == 0){
                           \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                        }else{
                             $vid = $row[0]->id;
                             $views = $row[0]->views +1;
                             \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                        }
                    }else{
                        $check = DB::table('cities')->where('slug',$full)->first();
                        if($check){
                            $today = date("y-m-d");
                            $row = \App\Models\Views::where([
                                        ['post_id', "=",$post_id],
                                        ['page_id', "=",$page_id],
                                        ['page_name', "=",$full],
                                        ['view_date',"=", $today]
                                    ])->get();
                            if (count($row) == 0){
                               \App\Models\Views::create(['post_id' => $post_id, 'views'=>1,'view_date'=>$today, "page_id"=>$page_id, "page_name"=>$full]);
                            }else{
                                 $vid = $row[0]->id;
                                 $views = $row[0]->views +1;
                                 \App\Models\Views::where('id', $vid)->update(['views' => $views]);
                            }
                        }
                    }
                }
            }
        }
    function popular_post($page_id = "" ,  $post_id = "" , $slug = ""){
        if ($page_id == 3) {
              $r = \App\Blogs::where('id','!=',$post_id)->orderBy('views', 'desc')->limit(5)->get();
        }elseif ($page_id == 2) {
              $r = \App\Blogs::orderBy('views', 'desc')->limit(5)->get();
        }elseif ($page_id == 4) {
              $r = \App\Blogs::orderBy('views', 'desc')->limit(5)->get();
        }elseif ($slug == "blogs") {
              $r = \App\Blogs::orderBy('views', 'desc')->limit(5)->get();
        }elseif ($slug == "careers") {
              $r = \App\Blogs::orderBy('views', 'desc')->limit(5)->get();
        }
        $res = "";
        foreach ($r as $kv) {
          $title = unslash( $kv->title );
          $short_title = ( strlen( $title ) > 20 ) ? substr( $title, 0, 40 ) . "...": $title;
          $content = trim(trim_words( html_entity_decode($kv->content), 35 ));
          $image = $kv->cover;
          $date = date("d M Y", $kv->date );
          $opt = array(
            "image" => $image,
            "type" => "thumb",
          );
          $thumb =  get_post_attachment($opt);
          $cover =  get_post_attachment(array("image"=>$image , "type"=>"full"));
          $url = route('base_url')."/".$kv->slug."-3".$kv->id;
           $res .= "<div class='col-lg-12 col-md-6 col-sm-6 latest-border'>
                        <li class='list-item'>
                        <div class='row'>
                             <div class='col-4 col-lg-5 pl-0'>
                               <a href='$url'><img src='$thumb' class='img-fluid' alt='$title'></a>
                            </div>
                            <div class='col-8 col-lg-7 pl-0'>
                                 <a href='$url'>$title</a>
                            </div>
                        </div>
                     </li>
                 </div>";
            }
            if (count($r) >0) {
               echo " <div class='sidebar-ribbon my-3'>
                 <h6 class='side-heading px-2'>Popular</h6>
                 </div>
                 <ul class='nav latest-entries'>"
                . $res.
                 "</ul>"; 
            }

    }
    // Default Image loader 
function default_image_loader(){
    return route("base_url")."/images/Preloader.gif";  
}
function lazy_content($content = ""){
    if ($content==""){
        return $content;
    }else{

        $dom = new DOMDocument;
		@$dom->loadHTML($content, LIBXML_HTML_NODEFDTD | LIBXML_HTML_NOIMPLIED);
        @$images = $dom->getElementsByTagName('img');
        if (isset($images->length) and $images->length > 0){
            foreach($images as $image){
                @$old_src = $image->getAttribute('src');
                @$new_src_url = 'image/catalog/blank.gif';
                @$image->setAttribute('src',  default_image_loader() );
                @$image->setAttribute('data-src', $old_src);
                @$image->setAttribute('class', "lazy");
            }
            @$content= $dom->saveHTML();
            return $content;
        }else{
            return $content;
        }
    }
}  
  function amp_image($content = ""){
    if ($content==""){
        return $content;
    }else{

        $dom = new DOMDocument;
        @$dom->loadHTML($content);
        @$images = $dom->getElementsByTagName('img');
        if (isset($images->length) and $images->length > 0){
            foreach($images as $image){
                @$old_src = $image->getAttribute('src');
                if(file_exists($old_src)){
                    list($width, $height) = getimagesize($old_src);
                }else{                
                    $width = "700";
                    $height = "500";
                 }
                @$image->setAttribute('layout', "responsive");
                @$image->setAttribute('width', $width);
                @$image->setAttribute('height', $height);
            }
            @$content= $dom->saveHTML();
            $content = str_replace("<img", "<amp-img", $content);
            return $content;
        }else{
            return $content;
        }
    }
}
function amp_youtube($content = ""){
    if ($content==""){
        return $content;
    }else{

        $dom = new DOMDocument;
        @$dom->loadHTML($content);
        @$youtube_div = $dom->getElementById('dom_id');
            foreach($youtube_div as $div){
                @$vid = $div->getAttribute('data-vid');
                @$div->setAttribute('layout', "responsive");
                @$div->setAttribute('width', $width);
                @$div->setAttribute('height', $height);
            }
            @$content= $dom->saveHTML();
            $content = str_replace("<img", "<amp-img", $content);
            return $content;
    }
}
function daily_views($id = ""){
    $date= $today = date( "Y-m-d" );
    $sql="select sum(views) as views from views where view_date='$today' and page_id='2' and post_id ='$id' GROUP BY view_date" ;
    $row=DB::select($sql);
    $sum = 0;
    foreach($row as $k){
        $sum += $k->views;
    }
    return $sum;
}
function monthly_views($id = ""){
    $date=( date( "Y" ) . "-" . date("m") . "-" );
    $sql="select sum(views) as views from views where view_date like '%$date%' and page_id='2' and post_id ='$id' GROUP BY view_date" ;
    $row=DB::select($sql);
    $sum = 0;
    foreach($row as $k){
        $sum += $k->views;
    }
    return $sum;
}
function yearly_views($id = ""){
    $date= date( "Y" ) ;
    $sql="select sum(views) as views from views where YEAR(view_date) = '$date' and page_id='2' and post_id ='$id' GROUP BY view_date" ;
    $row=DB::select($sql);
    $sum = 0;
    foreach($row as $k){
        $sum += $k->views;
    }
    return $sum;
}

function total_views($page_id = "" , $id = "" , $page_name = ""){
    $row=DB::table("views")->where("post_id" , $id)->where('page_id' , $page_id)->sum('views');
    return $row;
}

// Encrypt Data
function _encrypt($str=""){
    $key = env('APP_KEY');
    $code = $key."--".$str."--".$key;
    return base64_encode($code);
}

// Decrypt data
function _decrypt($str=""){
    $code = base64_decode($str);
    $exp = explode("--",$code);
    $code = (isset($exp[1])) ? $exp[1] : "";
    return $code;
}
function _slider_img(){
	$home = \App\Homedata::all()->map->toArray();
	$slider = $home[0]['slider_images'];
	$slider = json_decode($slider);
	return count($slider);

}
function get_alt($url = ""){
   if ($url !="") {
        $link = $url;
        $text = explode("/" , $link);
        $alt = end($text);
        $alt = explode(".", $alt);
        $find = array("-" , "_");
        $alt = str_replace($find , " " , $alt[0]);
        echo $alt;
   }
}
   function _getCatPostCount($id = 0){
        $post = DB::table("blogs")->whereRaw("FIND_IN_SET(?, category) > 0", [$id])->get();
        return count($post);
    }
     function updateEnv($data = array()){
        if (!count($data)) {
            return;
        }

        $pattern = '/([^\=]*)\=[^\n]*/';

        $envFile = base_path() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }
            if (!key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
                continue;
            }
            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }
        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }

    function getID_youtube($url)
    {
        parse_str(parse_url($url, PHP_URL_QUERY), $ID_youtube);
        return $ID_youtube['v'];
    }
    function getID_facebook($url)
    {
        parse_str(parse_url($url, PHP_URL_QUERY), $ID_facebook);
        // dd($ID_facebook);
        return $ID_facebook['v'];
    }
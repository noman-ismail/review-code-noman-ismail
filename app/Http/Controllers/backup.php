<?php
namespace App\Http\Controllers;
use App\ContactUser;
use App\generalsetting;
use App\Blogs;
use DB;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Mail;
class AdminAjaxController extends Controller {

    public function Croppie(){
        $image_n = explode("/", $_GET['img']);
        $image_file_old = end($image_n);
        $image_file = end($image_n);
        $imgname = explode(".", $image_file);
        $imge_exe = $imgname[1];

        $nw_name = $imgname[0];
        $image_name = $nw_name.".".$imgname[1];
        $fileType = pathinfo($_GET['img'], PATHINFO_EXTENSION);
        $image_path = getimagesize(base_path("images/".$image_file));
        $old_width = $image_path[0];
        $old_height = $image_path[1];
        $dim = $old_width."x".$old_height;
        $image_width = $_GET['w'];
        $image_height = $_GET['h'];
        if(strpos($imgname[0], $dim)){
            $imgname = str_replace($dim, "",$imgname[0]);
            $dim = round($image_width)."x".round($image_height);
            $image_file = $imgname.$dim.".".$imge_exe;
        }else{
            $dim = round($image_width)."x".round($image_height);
            $image_file = $imgname[0]."-".$dim.".".$imge_exe;
        }
        $dest = ImageCreateTrueColor( $image_width, $image_height );
        $u = DB::table("media")->where([
            ["images", "like", "%$image_file_old%"]
        ])->first();
        if(isset($u->id)){
            $images = json_decode($u->images, true);
            $sizes = json_decode($u->sizes,true);
            $images[$dim] = $image_file;
        }
        switch ($fileType) {
            case "jpg":
            case "jpeg":
                $src = imagecreatefromjpeg($_GET['img']);
                imagecopyresampled($dest, $src, 0, 0, $_GET['x'], $_GET['y'], $image_width, $image_height, $_GET['w'],$_GET['h']);
                    if(isset($_GET["ret"])){
                        return url("images/".$image_file);
                    }
                    header('Content-type: image/jpeg');
                    if(isset($_GET["sv"])){
                        DB::table("media")->where([
                            ["images", "like", "%$image_file_old%"]
                        ])->update(["images"=>json_encode($images)]);
                        imagejpeg($dest, base_path("images/".$image_file));
                    }
                break;
            case "png":
                    $src = imagecreatefrompng($_GET['img']);
                    imagecopyresampled($dest, $src, 0, 0, $_GET['x'], $_GET['y'], $image_width, $image_height, $_GET['w'],$_GET['h']);
                    if(isset($_GET["ret"])){
                        return url("images/".$image_file);
                    };
                    header('Content-type: image/jpeg');
                    if(isset($_GET["sv"])){
                        DB::table("media")->where([
                            ["images", "like", "%$image_file_old%"]
                        ])->update(["images"=>json_encode($images)]);
                        imagepng($dest, base_path("images/".$image_file));
                    }
                break;
            case "gif":
                $src = imagecreatefromgif($_POST['image_path']);
                imagecopyresampled($dest, $src, 0, 0, $_POST['x'], $_POST['y'], $_POST['dimension_x'], $_POST['dimension_y'], $_POST['w'], $_POST['h']);
                imagegif($dest, $_POST['image_destination']. '.gif');
                imagedestroy($dest);
                imagedestroy($src);
                break;
        }
        // $img_r = imagecreatefromjpeg($_GET['img']);
        // $dst_r = ImageCreateTrueColor( $_GET['w'], $_GET['h'] );
        // imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'], $_GET['w'], $_GET['h'], $_GET['w'],$_GET['h']);
        // if(isset($_GET["ret"])){
        //     return url("images/".$image_name);
        // }
        // header('Content-type: image/jpeg');
        // if(isset($_GET["sv"])){
        //     imagejpeg($dst_r, base_path("images/".$image_name));
        // }
        // imagejpeg($dst_r);
        exit;
    }

    public function get_views(){
        if(request('v')  == "daily"){
            $data = array();
            $today = date( "d" ); $d = array();
            $v = array();
            $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            for ( $n = 1; $n<=$days; $n++ )
            {
                $n = ($n<10) ? "0$n" : $n;
                $date=( date( "y" ) . "-" . date( "m" ) . "-$n" );
                $sql="select sum(views) as views from views where view_date='$date' GROUP BY view_date" ;
                $row=DB::select($sql);
                $views=( count( $row )> 0 ) ? $row[ 0 ]->views : 0;
                $d[] = $n ;
                $v[] = $views ; }
                $data["d"] =  $d;
                $data["v"] = $v;
            }elseif(request('v')  == "yearly"){
                $yr = Array (
                        '2019' => '2019',
                        '2020' => '2020',
                        '2021' => '2021',
                        '2022' => '2022',
                        '2023' => '2023',
                        '2024' => '2024',
                        '2025' => '2025',
                        '2026' => '2026',
                        '2027' => '2027',
                        '2028' => '2028',
                        '2029' => '2029',
                        '2030' => '2030',
                );
            $data = array();
            $today = date( "d" ); $d = array();
            $v = array();
            $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
            foreach ( $yr as $y )
            {
                
                $date=("$y" );
                $sql="select sum(views) as views from views where YEAR(view_date) = '$y' " ;
                $row=DB::select($sql);
                $views=( count( $row )> 0 ) ? $row[ 0 ]->views : 0;
                $views=( is_numeric($views) ) ? $views : 0;
                $d[] = $y ;
                $v[] = $views ; }
                $data["d"] =  $d;
                $data["v"] = $v;
            }elseif(request('v')  == "monthly"){
                $mth = Array (
                        '1' => 'January',
                        '2' => 'February',
                        '3' => 'March',
                        '4' => 'April',
                        '5' => 'May',
                        '6' => 'June',
                        '7' => 'July',
                        '8' => 'August',
                        '9' => 'September',
                        '10' => 'October',
                        '11' => 'November',
                        '12' => 'December' 
                );
                $data = array();
                $month = intval(date( "m" ));
                $year = date( "Y" );
                $d = array();
                $v = array();
                for ( $n = 1; $n<=12; $n++ )
                {   
                    $m = ($n<10) ? "0$n" : $n;
                    $date=( date( "Y" ) . "-" . date($m) . "-" );
                     $sql="select sum(views) as views from views where view_date like '%$date%' GROUP BY view_date" ;
                    $row=DB::select($sql);
                    $sum = 0;
                    foreach($row as $k){
                        $sum += $k->views;
                    }
                    $views=( count( $row )> 0 ) ? $row[ 0 ]->views : 0;
                    $d[] = $mth[$n] ;
                    $v[] = $sum;
                }
                    $data["d"] =  $d;
                    $data["v"] = $v;
            }else{
                $data = array();
                $today = date( "d" ); $d = array();
                $v = array();
                $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                for ( $n = 1; $n<=$days; $n++ )
                {
                    $n = ($n<10) ? "0$n" : $n;
                    $date=( date( "y" ) . "-" . date( "m" ) . "-$n" );
                    $sql="select sum(views) as views from views where view_date='$date' GROUP BY view_date" ;
                    $row=DB::select($sql);
                    $views=( count( $row )> 0 ) ? $row[ 0 ]->views : 0;
                    $d[] = $n ;
                    $v[] = $views ; }
                    $data["d"] =  $d;
                    $data["v"] = $v;
                }
        return json_encode($data);
    }
    function get_internalLinks()
    {
        $id = request('id');
        $result = array();
        $result1 = array();
        $res = Blogs::select("internal_links")->get();
        
        foreach ($res as $value) {
            $result[]=$value->internal_links;
        }
        $result = array_filter($result);
        $expected_result = implode(",", $result);
        return $expected_result;
    }
}

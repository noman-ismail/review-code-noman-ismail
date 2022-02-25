<?php 

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Mpdf\Mpdf;
use DB;
class AdsController extends Controller
{
    
	public function index()
    {
    	
		
    	if (request()->has("submit")) {
    		//dd(request()->all());
    		$title = request('title');
    		$ads_id = request('ads_id');
			$alt = request('alt');
			$url = request('url');
			$data = array();
			$mi=0;
			$imgs = array();
			for($a = 0; $a < count($title); $a++){
				$mi = (array_key_exists("img".$mi, request()->all()))?$mi:$mi+1;	
				 $img = (request()->has("img$mi")) ? request("img$mi") : "";
				$data[]= array(
					"ads_id" => $ads_id[$a],
					"title" => $title[$a],
					"img" => $img,
					"alt" => $alt[$a],
					"url" => $url[$a]
				);
				$mi++;			
			}		
		$ads_data = (json_encode($data));
    		 if(request()->has('id')){
            Ads::where('id', request('id'))->update([
                   'ads' => $ads_data,
                ]);
            return back()->with('flash_message', 'Ads settings updated successfully');
    	}else{
    		Ads::insert([
				'ads' => $ads_data,
				]);
    			return back()->with('flash_message', 'Ads settings updated successfully');
    		}
    	}
    	$data = Ads::select('id','ads')->first();
    	
    	return view('admin.ads' , compact('data'));
	}

	function download(Request $request)
	{
		if (file_exists('downloads/'.request('file'))) {

			$get_data = DB::table('downloads')->where('file',request('file'))->first();
			if($get_data){
				$watermark = $get_data->watermark;
			}else{
				$watermark = "";
			}
			try {
				$path = 'downloads/'.request('file');

				$mpdf = new Mpdf([
					'tempDir' => __DIR__,'/downloads',
					'orientation' => 'L'
				]);

				$pagecount = $mpdf->SetSourceFile($path);

				$tplId = $mpdf->ImportPage(1);
				$size = $mpdf->getTemplateSize($tplId);

				//Open a new instance with specified width and height, read the file again
				$mpdf = new Mpdf([
					'tempDir' => __DIR__,'/downloads',
					'format' => [$size['width'], $size['height']]
				]);
				$mpdf->SetSourceFile($path);

				//Write into the instance and output it
				for ($i=1; $i <= $pagecount; $i++) {
					$tplId = $mpdf->ImportPage($i);
					$mpdf->addPage();
					$mpdf->UseTemplate($tplId);
					$mpdf->SetWatermarkText($watermark);
					$mpdf->showWatermarkText = true;
					$mpdf->watermarkTextAlpha = 0.15;
				}
				$mpdf->output();
			} catch (\Exception $e) {
				echo($e->getMessage());
			}
		}else{
			echo("File Not Found");
		}
	}
}
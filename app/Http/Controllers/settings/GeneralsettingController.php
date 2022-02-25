<?php
namespace App\Http\Controllers\settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\generalsetting;
use DB;
class GeneralsettingController extends Controller
{
	
	public function index()
    {
        $settings = generalsetting::first();
        return view('admin.general-settings',compact('settings'));
    }
    public function store()
    {
       // dd(request()->all());
        generalsetting::updateOrCreate(
            ['id'=> request('id') ],
        [
            'logo'=>request('logo'),
            'favicon'=>request('favicon'),
            'og'=>request('og'),
            // 'host_name'=>request('host_name'),
            // 'host_username'=>request('host_username'),
            // 'host_password'=>request('host_password'),
            'google_analytics'=>request('google_analytics'),
            'web_master'=>request('web_master'),
            'bing_master'=>request('bing_master'),
            
        ]);
        // updateEnv(["MAIL_HOST" => request('host_name') , "MAIL_USERNAME" => request('host_username') , "MAIL_PASSWORD" => request('host_password') ]);
        return back()->with('flash_message','Yours settings are updated successfully');
    }
    function distric_cabinet(Request $request)
    {
        if(request()->isMethod('post')){
            $data['meta_title'] = request('meta_title');
            $data['meta_tags'] = request('meta_tags');
            $data['meta_description'] = request('meta_description');
            $data['content'] = request('content');
            DB::table('generalsettings')->where('id','1')->update(['district_cabinet'=>json_encode($data)]);
            return back()->with('success','Distrcit cabinet setting updated successfully');
        }
        $data = DB::table('generalsettings')->select('district_cabinet')->first();
        return view('admin.district-cabinet',compact('data'));
    }
}

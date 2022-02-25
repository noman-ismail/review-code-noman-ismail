<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
class SitemapController extends Controller{
   
	private $links = array();
	private $home = "";
	
	function __construct(){
		$this->home  = route("base_url")."/";
	}
	
	function _commonLinks(){
		$b = ["url"=>$this->home."contact", 
			 "priority" => "0.7", 
			 "frequency"=>"Daily"];
		$c = ["url"=>$this->home."privacy-policy", 
			 "priority" => "0.5", 
			 "frequency"=>"Daily"];
		$d = [
			 "url"=>$this->home."terms-conditions", 
			 "priority" => "0.5", 
			 "frequency"=>"Daily"
			];
		$a = [
			 "url"=>$this->home."faqs", 
			 "priority" => "0.5", 
			 "frequency"=>"Daily"
			];
		$this->links[] = $b;
		$this->links[] = $c;
		$this->links[] = $d;
		$this->links[] = $a;
	}
	function _firstLinks(){
			$b = ["url"=>$this->home, 
				 "priority" => "1.0", 
				 "frequency"=>"Daily"];
			$c = ["url"=>$this->home."about-us", 
				 "priority" => "0.8", 
				 "frequency"=>"Daily"];
			$d = [
				 "url"=>$this->home."welfare-benefits", 
				 "priority" => "0.8", 
				 "frequency"=>"Daily"
				];
			$this->links[] = $b;
			$this->links[] = $c;
			$this->links[] = $d;
		}
	
	function _blogLinks(){
		$this->links[] = [
			"url"=>$this->home."blogs", 
			"priority" => "0.8", 
			"frequency"=>"Daily"
		];
		$r = DB::table("blogs")->get();
		foreach($r as $k=>$v){
			$link = $v->slug;
			$link.="-3".$v->id;
			$lk = array(
				"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
			);
			$this->links[] = $lk;
		}
	}
	function _provinceLinks(){
		$this->links[] = [
			"url"=>$this->home."pakistan", 
			"priority" => "0.8", 
			"frequency"=>"Daily"
		];
		$r = DB::table("province")->get();
		foreach($r as $k=>$v){
			$link = $v->slug;
			$lk = array(
				"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
			);
			$this->links[] = $lk;
			$this->links[] = [
				"url"=>$this->home.$link."/team", 
				"priority" => "0.8", 
				"frequency"=>"Daily"
			];
			$this->links[] = [
				"url"=>$this->home.$link."/news-updates", 
				"priority" => "0.8", 
				"frequency"=>"Daily"
			];
			$this->links[] = [
				"url"=>$this->home.$link."/events", 
				"priority" => "0.8", 
				"frequency"=>"Daily"
			];
			$this->links[] = [
				"url"=>$this->home.$link."/jobs", 
				"priority" => "0.8", 
				"frequency"=>"Daily"
			];
			$this->links[] = [
				"url"=>$this->home.$link."/notifications", 
				"priority" => "0.8", 
				"frequency"=>"Daily"
			];
			$this->links[] = [
				"url"=>$this->home.$link."/contact-us", 
				"priority" => "0.8", 
				"frequency"=>"Daily"
			];
			$c = DB::table("cities")->where("province" , $v->id)->get();
			foreach($c as $k=>$v){
				$link = $v->slug;
				$city = array(
					"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
				);
				$this->links[] = $city;
				$this->links[] = [
					"url"=>$this->home.$link."/team", 
					"priority" => "0.8", 
					"frequency"=>"Daily"
				];
				$this->links[] = [
					"url"=>$this->home.$link."/apjea-members", 
					"priority" => "0.8", 
					"frequency"=>"Daily"
				];
				$this->links[] = [
					"url"=>$this->home.$link."/news-updates", 
					"priority" => "0.8", 
					"frequency"=>"Daily"
				];
				$this->links[] = [
					"url"=>$this->home.$link."/events", 
					"priority" => "0.8", 
					"frequency"=>"Daily"
				];
				$this->links[] = [
					"url"=>$this->home.$link."/jobs", 
					"priority" => "0.8", 
					"frequency"=>"Daily"
				];
				$this->links[] = [
					"url"=>$this->home.$link."/contact-us", 
					"priority" => "0.8", 
					"frequency"=>"Daily"
				];
			}
		}
	}
	function _newsLinks(){
		$this->links[] = [
			"url"=>$this->home."news", 
			"priority" => "0.8", 
			"frequency"=>"Daily"
		];
		$r = DB::table("news")->get();
		foreach($r as $k=>$v){
			$link = $v->slug;
			$link.="-5".$v->id;
			$lk = array(
				"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
			);
			$this->links[] = $lk;
		}
	}
	function _jobsLinks(){
		$this->links[] = [
			"url"=>$this->home."jobs", 
			"priority" => "0.8", 
			"frequency"=>"Daily"
		];
		$r = DB::table("jobs")->get();
		foreach($r as $k=>$v){
			$link = $v->slug;
			$link.="-1".$v->id;
			$lk = array(
				"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
			);
			$this->links[] = $lk;
		}
	}
	function _eventsLinks(){
		$this->links[] = [
			"url"=>$this->home."events", 
			"priority" => "1.0", 
			"frequency"=>"Daily"
		];
		$r = DB::table("event")->get();
		foreach($r as $k=>$v){
			$link = $v->slug;
			$link.="-2".$v->id;
			$lk = array(
				"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
			);
			$this->links[] = $lk;
		}
	}
	function _blogimages(){
		$r = DB::table("blogs")->get();
		$lk = array();
		foreach($r as $k=>$v){
			$link = $v->slug;
			$img = $v->cover;
			$link.="-2".$v->id;
			//dd($link);
			$htmlString = file_get_contents($this->home.$link);
			$htmlDom = new \DOMDocument;
			@$htmlDom->loadHTML($htmlString);
			$imageTags = $htmlDom->getElementsByTagName('img');
			$extractedImages = array();
			foreach($imageTags as $imageTag){
				$imgSrc = $imageTag->getAttribute('src');
				$altText = $imageTag->getAttribute('alt');
				$titleText = $imageTag->getAttribute('title');
				$extractedImages[] = array(
				    'src' => $imgSrc,
				    'alt' => $altText,
				    'title' => $titleText
				);
			}
			$lk[] = array(
					"url" => $this->home.$link, "images" => $extractedImages , "priority" => "0.5", "frequency"=>"Daily"
				);
				}
			
			$this->links[] = $lk;
			//dd($this->links);
	}
	function _blogcatsLinks(){
		
		$r = DB::table("blogcats")->get();		
		foreach($r as $k=>$v){
			$link = $v->slug;
			$link.="-4".$v->id;
			$lk = array(
				"url" => $this->home.$link, "priority" => "0.8", "frequency"=>"Daily"
			);
			$this->links[] = $lk;
		}
	}
	
	function _getLinks(){
		
		$this->_firstLinks();
		$this->_provinceLinks();
		$this->_jobsLinks();
		$this->_eventsLinks();
		$this->_blogLinks();
		$this->_blogcatsLinks();
		$this->_newsLinks();
		$this->_commonLinks();
	}
	
	function _show(){
		$this->_getLinks();
		header('Content-Type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?><?xml-stylesheet type="text/xsl" href="'.$this->home.'assets/sitemap.xsl"?>';
		echo "\n";
		echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		echo "\n";
		foreach ($this->links as $link) {
			echo "\t<url>\n";
			echo "\t\t<loc>" . htmlentities($link['url']) . "</loc>\n";
			//echo "\t\t<lastmod>{$link['lastmod']}</lastmod>\n";
			echo "\t\t<changefreq>{$link['frequency']}</changefreq>\n";
			echo "\t\t<priority>{$link['priority']}</priority>\n";
			echo "\t</url>\n";
		}
		echo '</urlset>';
		exit;
	}
	function _showimages(){
		$this->_blogimages();
		//dd($this->links);
		header('Content-Type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo "\n";
		echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9">';
		echo "\n";
		foreach ($this->links[0] as $k => $link) {
			echo "\t<url>\n";
			echo "\t\t<loc>" . htmlentities($link['url']) . "</loc>\n";
			foreach ($link['images'] as $key => $v) {
				echo "\t\t<image:image> \n ";
				echo "\t\t<image:loc>" . $v['src'] . "</image:loc>\n";
				if ($v['title'] !="") {
					echo "\t\t<image:title>" . $v['title'] . "</image:title>\n";
				}if ($v['title'] !="") {
					echo "\t\t<image:caption>" . $v['alt'] . "</image:caption>\n";
				}
				echo "\t\t</image:image>\n";
			}
			//echo "\t\t<lastmod>{$link['lastmod']}</lastmod>\n";
			echo "\t\t<changefreq>{$link['frequency']}</changefreq>\n";
			echo "\t\t<priority>{$link['priority']}</priority>\n";
			echo "\t</url>\n";
		}
		echo '</urlset>';
		exit;
	}
	
}
@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.blog.css') }}">
  <style>
    .isLoading{
        min-height:100vh;
        margin-bottom:80px;
        height:100%;
        width:100%;
      }
      .isLoading>div{
        display: none;
      }
	</style>
    <!--Load different Section on scroll-->
    <script>
          window.addEventListener("load", (event) => {["sectionOne"].forEach(name =>{
              handleEachCategory(name);
            });
          }, false);

          function handleEachCategory(category) {
            let target = document.getElementById(category);
            let observer;
            let isVis;
            createObserver();

          function createObserver() {
            let options = {
              root: null,
              rootMargin: '0px',
              threshold: 0.25
            }
            observer = new IntersectionObserver(handleIntersect, options);
            observer.observe(target);
          }  

          function handleIntersect(entries, observer) {
            entries.forEach(entry => {
              if (entry.isIntersecting) {
                entry.target.classList.remove('isLoading');
                entry.target.childNodes[1].display = "block";
              }
            });
          }
      }
    </script>
</head>
<body>
	<div class="wrapper">
    @include('front.layout.top-menu')
    @include('front.layout.main-menu',['segment'=>'news'])
@php
    $post_id = get_postid('post_id');
$title = ($res->title !="" and strlen($res->title) > 60) ? '<h1 class="header-title ">'.substr($res->title , 0,60).'</h1>' : "";
$views = ($res->views !="") ? '<div class="icon"> <i class="icon-eye pr-2"></i>'.total_views($post_id).'</div>' : "";
$date = ($res->date !="") ? '<div class="icon"> <i class="icon-calendar pr-2"></i>'.date("d M Y",strtotime($res->date)).'</div>' : "";
$content = ($res->content !="") ? $res->content : "";


$c_title = isset($cat->title) ? $cat->title : "";
@endphp
<header class="title-header main-header">
  <div class="container">
    <div class="header-text">
      {!! $title !!}
      <ul class="breadcrumb">
        <li><a href="{{ route('base_url') }}">Home</a></li>
        <li><a href="{{ route('news') }}">News & Updates</a></li>
		  @if (!empty($res->title))
            @php
              $title = (strlen($res->title) > 100) ? substr($res->title , 0,100) : $res->title;
            @endphp
            <li><span>{{ $title }}</span></li>
          @endif  
      </ul>
    </div>
  </div>
</header>     
<main class="main-content single-section">
  <div class="container">
    <div class="row">
      <article class="col-lg-8 col-xl-9 article-column" id="article-column">
        <div class="blog-content">
          @if (!empty($res->title))
            @php
              $title = (strlen($res->title) > 100) ? substr($res->title , 0,100) : $res->title;
            @endphp
            <h2 class="main-title">{{ $title }}</h2>
          @endif          
        </div>
        <div class="blog-bottom">
          <ul class="blog-feat" style="display: flex;justify-content: flex-end;">
             @if ($res->date)
              <li><i class="icon-calendar"></i><a>{{ date("d M Y", strtotime($res->date) ) }}</a></li>
            @endif
            <li><i class="icon-eye"></i><a href="#">{{ total_views( 5 , $post_id)}}</a></li>
          </ul>
        </div>
        <div class="blog-content" id="related-post">
          <div class="isLoading" id="sectionOne">
            <div class="section-child">
           @php
                $tags = explode(",", $res->meta_tags);
                $titles = explode(" ", $res->title);
                $content = do_short_code($content, $res->id , "news",$titles, $tags);
                $ct = table_of_content($content);
                $content = $ct["content"];
                $tc = array("ct"=>$ct["table"]);
                $table = View::make('front/temp/table-of-content', $tc)->render();
                $content = str_replace("[[toc]]", $table, $content);
               // $content = lazy_content($content);        
          @endphp
          {!! $content !!}
            </div>
          </div>
          <hr class="bottom-line"/>
          <div class="detail-bottom">
            <h4>Share This Post</h4>
            <div class="addthis_inline_share_toolbox" id="add-this"></div>
          </div>
        </div>
        </article>
         @include('front.sidebar.common')
        <div class="col-sm-12 col-lg-8 col-xl-9 bg-white comment-column order-lg-2">
          <div class="blog-comments text-left">
            <div class="fb-comments" data-href="{{ route('base_url') }}/{{ get_postid('full')}}"  data-width="100%" data-numposts="5" data-order-by="reverse_time"></div>
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('front.layout.footer')
<!-- ===Pop up Alert== -->
<!--Alert Success-->
<div class="message-box success-box" style="display: none;">
<div class="message-content">
  <h3 class="message-head">Success!! <span class="close">&times;</span></h3>
  <div class="message-text">
    <div class="icon">
      <i class="icon-info"></i>
    </div>
    <p>User Subscribed Sucessfully</p>
  </div>
  <button class="btn-close">OK</button>
</div>
</div>
  @php
      $views = $res->views;
      refresh_views($views , get_postid('post_id') , get_postid('page_id'), get_postid('full') );
    @endphp
<script>
function loadfiles(filename, filetype){
      if (filetype=="js"){ //if filename is a external JavaScript file
          var fileref=document.createElement('script');
          fileref.setAttribute("type","text/javascript");
          fileref.setAttribute("src", filename);
      }
      else if (filetype=="css"){ //if filename is an external CSS file
          var fileref=document.createElement("link");
          fileref.setAttribute("rel", "stylesheet");
          fileref.setAttribute("type", "text/css");
          fileref.setAttribute("href", filename);
      }
      if (typeof fileref!="undefined")
          document.getElementsByTagName("head")[0].appendChild(fileref);
  }
  document.getElementsByClassName("fb-page")[0].style.textAlign = "center !important";
    loadfiles("{{ asset('assets/style/icomoon.css') }}","css");
    loadfiles("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap","css");
</script>

		<script>
      jQuery.event.special.touchstart = {
        setup: function( _, ns, handle ){
            this.addEventListener("touchstart", handle, { passive: true });
        }
    };
    $(document).ready(function(){
      $('.section-child img').css('max-width','100%');
      $('.recent-post .post-detail a').css('overflow','hidden');
      $("#scroll-div button").click(function(){
      	$("html").animate({ scrollTop: 0 }, "slow");
      })
    });
    $(".main-menu li.logo").hide();
    $(window).on("scroll",function(){
      if($(window).scrollTop()>160 && $(window).width()>768){
      	$(".nav-container").addClass("fixed-top");
      	$(".sticky-container").addClass("container");
      	$(".main-menu").css({"margin":"0px auto"});
      	$(".main-menu li.logo").show();
      }
      else{
      	$(".nav-container").removeClass("fixed-top");
      	$(".sticky-container").removeClass("container");
      	$(".main-menu").css({"margin":"0px"});
      	$(".main-menu").find("li.logo").hide();
      }

    if($(window).scrollTop()<=400){
    	$("#scroll-div").hide();
    }
    else{
    	$("#scroll-div").show();
    }
    });
            
  if($(window).width() <768){
      $("li.dropdown").click(function(){
        if($(this).find(".dropdown-content").hasClass("slideUp")){
            $(this).find(".icon-md i").addClass("icon-plus");
            $(this).find(".icon-md i").removeClass("icon-minus");
            $(this).find(".dropdown-content").hide("slow");
            $(this).find(".dropdown-content").removeClass("slideUp");
            $(this).css({"background":"transparent"});
            $(this).find("a").css({"color":"#000"});
            $(this).find(".icon-md i").css({"color":"#000"});

        }
        else{
            $(this).find(".icon-md i").addClass("icon-minus");
            $(this).find(".icon-md i").removeClass("icon-plus");
            $(this).find(".dropdown-content").show("slow");
            $(this).find(".dropdown-content").addClass("slideUp");
            $(this).css({"background":"#257c17"});
            $(this).find("a").css({"color":"#fff"});
            $(this).find(".icon-md i").css({"color":"#fff"});
        }
        $("li.dropdown>a[href='#']").click(function(e){
            e.preventDefault();                         
        });
    });
  }

	$("ul.top-loc li a").click(function(e){
		$(".loc-dropdown").slideToggle();
		$("ul.top-loc li >a:first-child").text($(this).text());
	});

	$(".main-menu >li.dropdown").hover(function(){
		$(this).find(".dropdown-content").addClass("fade");
	},function(){
		$(this).find(".dropdown-content").removeClass("fade");
	});

	showLoader();
	/*===APJEA Page Loading==*/
	$(window).scroll(function(e){
		if($(window).scrollTop() > $("#related-post").offset().top - 10){
			showPage();
			window.onload = function() {
			    FB.Event.subscribe('xfbml.render', function(response) {
			        hideLoader();
			    });
			};
			$(this).off(e);
		}
	});

	function showPage(){
		var js = document.createElement('script');
		js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0';
          document.getElementById("related-post").appendChild(js);
		document.getElementsByClassName("fb-page")[0].style.height ="auto";
	}

	function showLoader(){
		$(".fb-page").css({"height":"500px","background":"white url('compress/preloader.gif') no-repeat center center"});
	}
	function hideLoader(){
		$(".fb-page").css({"height":"auto","background":"transparent"});
	}
        
	/*function loadPlugin(){
		var js = document.createElement('script');
		js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0';
         document.getElementById("related-post").appendChild(js);
	}*/
  @php
    $link = get_postid("full");
  @endphp
	function loadAddThis() {
         var js = document.createElement('script');
         js.src = '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e0c95b0a38613d1';
         document.getElementById("add-this").appendChild(js);
         js.setAttribute("data-url" , "{{ route('base_url') }}/{{ $link }}");
    }
    
        // Message Box Alert
        $(".message-box").hide();
        $(".btn-subscribe").click(function(){
            $(".message-box").fadeIn("slow");
        });
        $("span.close,button.btn-close").click(function(){
            $(".message-box").fadeOut("slow");
        });
        
        $(".mobile-menu li.calc-item").click(function(){
            $(this).find(".mobile-dropdown").toggle(200);
        });
        
        $(window).on("resize load",function(){
            if($(window).width() < 440){
                $(".mobile-menu li.calc-item>a").text("Pension")
            }
            else{
                $(".mobile-menu li.calc-item>a").text("Pension Calculations");
            }
        });

	$(".ex-faqs-item:not(.visible)").find(".ex-faqs-body").hide();
	$(".ex-faqs-header").click(function(){
			var current = $(this).next(".ex-faqs-body");
			$(".ex-faqs-body").not(current).slideUp(500);
			$(".ex-faqs-body").not(current).parent(".ex-faqs-item").removeClass("visible");
			if ($(this).parent().is('.visible')){
            $(this).closest('.ex-faqs-item').find('.ex-faqs-body').slideUp(500);
            $(this).closest('.ex-faqs-item').removeClass('visible');
            $(".ex-faqs-header .faqs-icon i").addClass("icon-chevron-down");
            $(".ex-faqs-header .faqs-icon i").removeClass("icon-chevron-up");
          }
          else{
              $(this).closest('.ex-faqs-item').find('.ex-faqs-body').slideDown(500);
              $(this).closest('.ex-faqs-item').addClass('visible');
              $(".ex-faqs-header .faqs-icon i").addClass("icon-chevron-down");
            $(".ex-faqs-header .faqs-icon i").removeClass("icon-chevron-up");
				$(this).find(".faqs-icon i").addClass("icon-chevron-up");
				$(this).find(".faqs-icon i").removeClass("icon-chevron-down");
          }
	});

	$(window).scroll(function(e){
		if($(window).scrollTop() > $("#article-column").offset().top - 10){
                loadAddThis();
			$(this).off(e);
		}
	});
		</script>
	</div>
</body>
</html>
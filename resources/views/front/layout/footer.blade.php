<footer class="crt-footer" id="court-footer">
  <div class="container footer-top">
    <div class="row">
      @php
        $r = DB::table('homedata')->select('footer','social_links')->first();
        $footer = (isset($r->footer)) ? json_decode($r->footer) : array();
        $s_lnk = (isset($r->social_links)) ? json_decode($r->social_links) : array();
      @endphp
      <div class="col-md-6 col-lg-4 col-xl-4">
        <h3 class="title-head">Contact Info</h3>
        <p>We are always available for you to pass & get back on the right track.</p>
        <div class="footer-contact">
          @isset ($footer->address)
           <div class="contact-item row">
            <div class="contact-icon col-1">
              <i class="icon-location"></i>
            </div>
            <div class="contact-detail col-11">
              <p>{{ $footer->address }}</p>
            </div>
          </div>    
          @endisset
          @isset ($footer->email)
          <div class="contact-item row">
            <div class="contact-icon col-1">
              <i class="icon-envelope" style="font-size: 18px;"></i>
            </div>
            <div class="contact-detail col-11">
              <p>Tell Us The Reason For Your Query</p>
              <a href="mailto:{{$footer->email}}">{{ $footer->email }}</a>
            </div>
          </div>    
          @endisset
          @isset ($footer->office_time)
          <div class="contact-item row">
            <div class="contact-icon col-1">
              <i class="icon-alarm"></i>
            </div>
            <div class="contact-detail col-11">
              <p>{{ $footer->office_time}}</p>
            </div>
          </div>    
          @endisset
          @isset ($footer->phone)
          <div class="contact-item item-lg row">
            <div class="contact-lg-icon col-2 col-lg-3 col-xl-2">
              <i class="icon-headphones"></i>
            </div>
            <div class="contact-lg-detail col-10 col-lg-9 col-xl-10 pl-0">
              <h3>{{$footer->phone}}</h3>
            </div>
          </div>    
          @endisset
        </div>
      </div>
      <div class="col-md-6 col-lg-4 col-xl-3 form-column">
        <div class="facebook-page mx-auto">
          <div id="fb-root"></div>
          <div class="fb-page" data-href="https://www.facebook.com/APJEA.Pakistan/" data-tabs="timeline" data-width="" data-height="420" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false" style="float: right; margin: 10px;"><blockquote cite="https://www.facebook.com/APJEA.Pakistan/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/APJEA.Pakistan/">APJEA Pakistan</a></blockquote></div>
        </div>
      </div>
      <div class="col-md-12 col-lg-4 col-xl-5">
        <div class="row">
          <div class="col-md-6 col-lg-12">
            <h3 class="title-head">Quick Links</h3>
            <div class="footer-links row">
              <ul class="col-12 col-sm-6">
                <li><a href="#">Make Appointments</a></li>
                <li><a href="#">Corporate Law</a></li>
                <li><a href="{{ route('base_url') }}/terms-conditions">Terms & Conditions</a></li>
                <li><a href="{{ route('base_url') }}/faqs">FAQs</a></li>
              </ul>
              <ul class="col-12 col-sm-6">
                <li><a href="{{ route('base_url') }}/privacy-policy">Privacy Policy</a></li>
                <li><a href="#">Advertisements</a></li>
                <li><a href="#">Criminal Law</a></li>
                <li><a href="#">Cabinets</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-6 col-lg-12">
            <div class="newletter-box">
              <h3 class="title-head">Newsletter</h3>
              <p>Subscribe to our newsletter to receive latest news & notification on our services.</p>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="Email Address">
                <button type="button" class="btn-subscribe">
                <i class="icon-compass"></i>
                </button>
              </div>
              @isset ($footer->copyrights)
               <p>{{ $footer->copyrights }}</p>   
              @endisset
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <hr class="footer-hr">
  <div class="container footer-bottom">
    <div class="row bottom-row">
      <div class="col-md-6 rights-column">
          @php
          if(Request::segment(1)==""){
            $follow = "";
          }else{
            $follow = "rel=nofollow";
          }
          @endphp
        <p>Design & Developed By: <a href="https://dgaps.com" target="_blank" {{ $follow }}> Digital Applications</a></p>
      </div>
      <div class="col-md-6 social-flex">
        <ul class="footer-social">
          @foreach ($s_lnk as $k => $v)
            <li><a href="{{$v->link}}" rel="nofollow noopener" target="_blank">{!! $v->icon !!}</a></li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</footer>
<!-- Move to Top -->
<div id="scroll-div" style="display:none;">
  <button type="button"><i class="icon-arrow-up2"></i></button>
</div>
<!-- ===Pop up Alert== -->
<!--Alert Success-->
<div class="message-box success-box" style="display: none;">
  <div class="message-content">
    <h3 class="message-head">Success!! <span class="close">&times;</span></h3>
    <div class="message-text">
      <div class="icon">
        <i class="icon-info"></i>
      </div>
      <p></p>
    </div>
    <button class="btn-close">OK</button>
  </div>
</div>
<!--
<div class="message-box error-box">
          <div class="message-content">
              <h3 class="message-head">Error!! <span class="close">&times;</span></h3>
    <div class="message-text">
      <div class="icon">
        <i class="icon-info"></i>
      </div>
      <p>OOPs!!User cannot Subscribe at this time</p>
    </div>
    <button class="btn-close">OK</button>
          </div>
      </div>
-->
<!-- Footer Scripts -->
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
  $(".btn-toggle").click(function(){
    $("ul.main-menu").slideToggle();
  });
  $(".main-menu >li.dropdown").hover(function(){
    $(this).find(".dropdown-content").addClass("fade");
  },function(){
    $(this).find(".dropdown-content").removeClass("fade");
  });
  showLoader();
  /*===APJEA Page Loading==*/
  $(window).scroll(function(e){
    if($(window).scrollTop() > $("#court-footer").offset().top - 2000){
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
    var script = document.createElement("script");
    script.setAttribute("src","https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v8.0&appId=555490605063467&autoLogAppEvents=1");
    async = document.createAttribute("async");
    defer = document.createAttribute("defer");
    script.setAttributeNode(async);
    script.setAttributeNode(defer);
    script.setAttribute("nonce","KCY9qike");
    document.getElementsByClassName("facebook-page")[0].appendChild(script);
    document.getElementsByClassName("fb-page")[0].style.height ="auto";
  }
  function showLoader(){
    $(".fb-page").css({"height":"500px","background":"white url('{{ asset('compress/preloader.gif') }}') no-repeat center center"});
  }
  function hideLoader(){
    $(".fb-page").css({"height":"auto","background":"transparent"});
  }

// Message Box Alert
$(".message-box").hide();
$(".btn-subscribe").click(function(){
$(".message-box").find('p').html('User Subscribed Sucessfully');
$(".message-box").fadeIn("slow");
});
// console.log($('.message-head span.close'));
$(".message-head span.close").on('click',function(){
  $(".message-box").fadeOut("slow");
  $(".message-box2").fadeOut("slow");
});
$(".message-content button.btn-close").on('click',function(){
  $(".message-box").fadeOut("slow");
  $(".message-box2").fadeOut("slow");
});

$(".col-md-12 .message .close").click(function(){
    $(this).parent(".message").fadeOut("slow");
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
</script>

  <script>
    loadfiles("{{ asset('assets/style/chosen.css') }}","css");
    loadfiles("{{ asset('assets/js/chosen.js') }}","js");
    $(document).ready(function(){
            // $(".ui-dropdown").chosen();
      $('.btn-search').click(function(){
        var value = $('.ui-dropdown').val().trim();
        if(value != ""){
            window.location.href = value;
        }
      });
    })
        $( window ).on("load",function(){
            $(".ui-dropdown").chosen();
        });
  </script>
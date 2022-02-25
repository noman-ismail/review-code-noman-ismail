@include('front.layout.header')
	<style>
    .loader-section{
          height:500px;
          background:white url('{{ asset('compress/preloader.gif') }}') no-repeat center center;
      }
    .map-image-col .map-column{
      width:100%;
      height:400px;
      margin-top:30px;
    }
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
          window.addEventListener("load", (event) => {["sectionTwo","sectionThree","sectionFour","sectionFive","sectionSix","sectionSeven"].forEach(name =>{
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
              }
          });
        }
      }
    </script>
    <link rel="stylesheet" href="{{ asset('assets/style/all.index.css') }}"> 
</head>
 <body> 
     <div class="wrapper"> 
     @include('front.layout.top-menu') 
     @include('front.layout.main-menu') 
 		<header class="main-header" id="sectionOne">
			<div class="container-fluid  padding-0 sectionChild">
				<div class="top-map">
					<div class="container">
						<div class="row">
							<div class="col-md-5 col-lg-4">
								<h3>We Have The Largest Network In Pakistan</h3>
								<ul>
									<li class="pak">
                      <a href="cabinet-province.php"><span>Pakistan</span></a>
                    </li>
                    <li class="punjab">
                        <a href="cabinet-province.php"><span>Punjab</span></a>
                    </li>
                    <li class="sindh">
                      <a href="cabinet-province.php"><span>Sindh</span></a>
                    </li>
                    <li class="kpk">
                      <a href="cabinet-province.php"><span>Khyber Pakhtunkhwa</span></a>
                    </li>
                    <li class="baloch">
                      <a href="cabinet-province.php"><span>Balochistan</span></a>
                    </li>
                    <li class="gilgit">
                      <a href="cabinet-province.php"><span>Gilgit Baltistan</span></a>
                    </li>
                    <li class="ajk">
                        <a href="cabinet-province.php"><span>Azad Kashmir</span></a>
                    </li>
								</ul>
							</div>
							<div class="col-md-7 col-lg-8 map-image-col" id="country-map">
                  <div class="map-column">
                    @include('front.layout.new-map')
                  </div>
							</div> 
						</div>
					</div>
				</div>
			</div>
		</header>
         
        <div class="isLoading" id="sectionTwo">
           <div class="container about-intro">
              <div class="row show-section align-items-center sectionChild">
                  <div class="col-lg-8 col-xl-7 about-col intro-col-one">
                      <h2>We Always Fight For The Justice</h2>
                      <p>These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice when nothing prevents our being able to do what we like best to every pain avoided.</p>

                      <p>These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice when nothing prevents our being able to do what we like best, every pleasure is to be welcomed and every pain avoided. Ut enim ad minim veniam, quis nostrud exercitation. Duis aute irure dolor in reprehen derit in voluptate velit esse cillum dolore nulla pariatur</p>

                      <ul>
                          <li>100% Success Rate</li>
                          <li>Highly Recommend</li>
                          <li>Expert Legal Services</li>
                          <li>Expert Attorneys</li>
                      </ul>
                  </div>

                  <div class="col-lg-4 col-xl-5 about-col">
                      <img src="{{ asset('compress/post-three-md.jpg') }}" srcset="{{ asset('compress/post-three-sm.jpg') }} 400w,{{ asset('compress/post-three-md.jpg') }} 992w,{{ asset('compress/post-three-lg.jpg') }} 1920w" width=""
                      height="" class="img-fluid" alt="about-img">
                  </div>
              </div>
           </div>
        </div>

		<!-- Our Grants -->
        <div class="isLoading" id="sectionThree">
           <div class="grants-section grCarousel-section">
			<div class="show-section sectionChild">
				<div class="grant-overlay"></div>
				<div class="container grant-container">
					<h3 class="main-head text-center">Our Grants</h3>
					<div class="row">
						<div class="col-md-11 mx-auto">
							<div class="owl-carousel grant-carousel">
								<div class="item">
									<div class="grant-column hvr-overline-from-left">
										<div class="grant-icon">
											<img src="compress/death.png" width="100%" height="50" alt="icon-one">
										</div>
										<div class="grant-text">
											<h3>Death Funeral</h3>
											<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
											<a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="grant-column hvr-overline-from-left">
										<div class="grant-icon">
											<img src="compress/accident.png" width="100%" height="50" alt="icon-one">
										</div>
										<div class="grant-text">
											<h3>Accidental Injury</h3>
											<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
											<a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
										</div>
									</div>
								</div>
								<div class="item">
									<div class="grant-column hvr-overline-from-left">
										<div class="grant-icon">
											<img src="compress/healthcare.png" width="100%" height="50" alt="icon-one">
										</div>
										<div class="grant-text">
											<h3>Major Diseases</h3>
											<p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
											<a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
										</div>
									</div>
								</div>
                                <div class="item">
                                  <div class="grant-column hvr-overline-from-left">
                                    <div class="grant-icon">
                                      <img src="compress/umrah.png" width="100%" height="50" alt="icon-one">
                                    </div>
                                    <div class="grant-text">
                                      <h3>Umrah</h3>
                                      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
                                      <a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
                                    </div>
                                  </div>
                                </div>
                                
                                <div class="item">
                                  <div class="grant-column hvr-overline-from-left">
                                    <div class="grant-icon">
                                      <img src="compress/public_welfare.png" width="100%" height="50" alt="icon-one">
                                    </div>
                                    <div class="grant-text">
                                      <h3>Public Welfare</h3>
                                      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
                                      <a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- What We Offer -->
       <div class="isLoading" id="sectionFour">
            <div class="offer-section">
                <div class="container">
                    <div class="row">
                      <div class="col-md-12 col-lg-6">
                        <div class="offer-column">
                            <h3 class="main-head text-center">Latest News</h3>
                            <div class="row dashboxes">
                              <div class="col-lg-12">
                                <div class="dash-box dash-success">
                                  <div class="dash-flex">
                                    <div class="dash-icon bg-grdgreen">
                                      <i class="icon-check_circle_outline"></i>
                                    </div>
                                    <div class="dash-date">
                                      <h4 style="">17 <span>Nov</span></h4>
                                    </div>
                                    <div class="dash-detail">
                                      <h3><a href="blog-detail.php">Conference on Data Sciences March 11,2020</a></h3>
                                      <p>Lorem ipsum dolor sit amet consectetur.Lorem ipsum dolor sit amet consectetur.Lorem ipsum dolor sit amet consectetur.</p>
                                    </div>
                                  </div>
                                </div>

                                <div class="dash-box dash-warn">
                                  <div class="dash-flex">
                                    <div class="dash-icon bg-grdorange">
                                      <i class="icon-info"></i>
                                    </div>
                                    <div class="dash-date">
                                      <h4 style="">20 <span>Nov</span></h4>
                                    </div>
                                    <div class="dash-detail">
                                      <h3><a href="blog-detail.php">
                                        Your PC can Be at risk due to certain Softwares</a>
                                      </h3>
                                      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad nostrum.</p>
                                    </div>
                                  </div>
                                </div>

                                <div class="dash-box dash-info">
                                  <div class="dash-flex">
                                    <div class="dash-icon bg-info">
                                      <i class="icon-info"></i>
                                    </div>
                                    <div class="dash-date">
                                      <h4 style="">17 <span>Nov</span></h4>
                                    </div>
                                    <div class="dash-detail">
                                      <h3><a href="blog-detail.php">Conference on Data Sciences March 11,2020</a></h3>
                                      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                    </div>
                                  </div>
                                </div>

                                <div class="dash-box dash-error dash-hide-lg">
                                  <div class="dash-flex">
                                    <div class="dash-icon bg-grdred">
                                      <i class="icon-cancel-circle"></i>
                                    </div>
                                    <div class="dash-date">
                                      <h4 style="">30 <span>Aug</span></h4>
                                    </div>
                                    <div class="dash-detail">
                                      <h3><a href="#">Your PC can Be at risk Due to certain Softwares</a>
                                      </h3>
                                      <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ad nostrum</p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-12 col-lg-6">
                          <h3 class="main-head text-center">Our Success</h3>
                          <div class="success-row">
                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-library"></i>
                                      <span>05</span>
                                  </div>
                                  <h3 class="text-center">Provinces</h3>
                              </div>
                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-office"></i>
                                      <span>90</span>
                                  </div>
                                  <h3 class="text-center">Districts</h3>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-user"></i>
                                      <span>5,000</span>
                                  </div>
                                  <h3 class="text-center">Members</h3>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-calendar"></i>
                                      <span>100</span>
                                  </div>
                                  <h3 class="text-center">Events</h3>
                              </div>

                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-sphere"></i>
                                      <span>24/7</span>
                                  </div>
                                  <h3 class="text-center">Availability</h3>
                              </div>
                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-gift"></i>
                                      <span>10</span>
                                  </div>
                                  <h3 class="text-center">Grants</h3>
                              </div>
                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-calculator"></i>
                                      <span>100</span>
                                  </div>
                                  <h3 class="text-center">Pension Calculations</h3>
                              </div>
                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-file-pdf"></i>
                                      <span>10</span>
                                  </div>
                                  <h3 class="text-center">Pension Paper</h3>
                              </div>
                              <div class="col-6 col-sm-4 col-lg-6 col-xl-4 success-item">
                                  <div class="success-icon dash-flex">
                                      <i class="icon-bell"></i>
                                      <span>40</span>
                                  </div>
                                  <h3 class="text-center">Notifications</h3>
                              </div>
                          </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
       <!-- Our Grants -->
       <div class="isLoading" id="sectionFive">
           <div class="initiative-section grants-section">
              <div class="grant-overlay"></div>
              <div class="container grant-container">
                  <h3 class="main-head text-center">Initiatives</h3>
                  <div class="row">
                      <div class="col-md-11 mx-auto">
                          <div class="owl-carousel grant-carousel">
                            <div class="item">
                                <div class="grant-column hvr-outline-corner">
                                    <span class="border-tl"></span>
                                    <span class="border-tr"></span>
                                    <div class="grant-icon">
                                        <img src="compress/icon-one.png" width="100%" height="50" alt="icon-one">
                                    </div>
                                    <div class="grant-text">
                                        <h3>Emergency Help</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
                                        <a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
                                    </div>
                                    <span class="border-rb"></span>
                                    <span class="border-lb"></span>
                                </div>
                            </div>
                            <div class="item">
                                <div class="grant-column hvr-outline-corner">
                                      <span class="border-tl"></span>
                                      <span class="border-tr"></span>
                                        <div class="grant-icon">
                                            <img src="compress/icon-two.png" width="100%" height="50" alt="icon-one">
                                        </div>
                                        <div class="grant-text">
                                            <h3>Gifts</h3>
                                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
                                            <a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
                                        </div>
                                      <span class="border-rb"></span>
                                      <span class="border-lb"></span>
                                    </div>
                            </div>
                            <div class="item">
                                <div class="grant-column hvr-outline-corner">
                                    <span class="border-tl"></span>
                                    <span class="border-tr"></span>
                                    <div class="grant-icon">
                                        <img src="compress/icon-three.png" width="100%" height="50" alt="icon-one">
                                    </div>
                                    <div class="grant-text">
                                        <h3>Brotherhood</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse numquam laborum ea nulla eum iusto blanditiis magnam impedit aliquam quae.</p>
                                        <a href="#">Read More&nbsp;<i class="icon-arrow-right2"></i></a>
                                    </div>
                                    <span class="border-rb"></span>
                                    <span class="border-lb"></span>
                                </div>
                            </div>
                          </div>
                      </div>
                  </div>
             </div>
          </div>
       </div>
        
       <div class="isLoading" id="sectionSix">
         <div class="blog-section">
            <div class="container">
                <h3 class="main-head text-center">Our Latest Posts</h3>
                <div class="row">
                    <div class="col-sm-6 col-md-6 col-lg-4 col-exl-3 outer-col">
                        <div class="blog-column">
                            <div class="blog-image">
                                <a href="blog-detail.php">
                                  <img src="compress/post-one-md.jpg" width="100%" height="555" class="img-fluid" srcset="compress/post-one-sm.jpg 400w,compress/post-one-md.jpg 992w,compress/post-one-lg.jpg 1920w" sizes="100vw" alt="blog-image">
                                  <div class="img-hvr"></div>
                                  <div class="blog-date">
                                      <span class="date">17</span>
                                      <span class="month">Oct</span>
                                  </div>
                               </a>
                            </div>
                            <div class="blog-bottom">
                                <ul class="blog-feat">
                                    <li><i class="icon-user"></i><a href="#">Admin</a></li>
                                    <li><i class="icon-price-tags"></i><a href="#">Family Law</a></li>
                                </ul>
                                <h3>
                                    <a href="blog-detail.php">Do You Think, You Know Your Civil Rights? Get consultancy from our top Attorneys</a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-exl-3 outer-col">
                        <div class="blog-column">
                            <div class="blog-image">
                                <a href="blog-detail.php">
                                  <img src="compress/post-two.jpg" class="img-fluid" width="650" srcset="compress/post-two-sm.jpg 400w,compress/post-two-md.jpg 992w,compress/post-two-lg.jpg 1920w" height="555" alt="blog-image">
                                  <div class="img-hvr"></div>
                                  <div class="blog-date">
                                      <span class="date">17</span>
                                      <span class="month">Oct</span>
                                  </div>
                                </a>
                            </div>
                            <div class="blog-bottom">
                                <ul class="blog-feat">
                                    <li><i class="icon-user"></i><a href="#">Admin</a></li>
                                    <li><i class="icon-price-tags"></i><a href="#">Family Law</a></li>
                                </ul>
                                <h3>
                                    <a href="blog-detail.php">Rules Against Domestic Violence of Labour Child & Steps To Handle</a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-exl-3 outer-col">
                        <div class="blog-column">
                            <div class="blog-image">
                                <a href="blog-detail.php">
                                  <img src="compress/post-three.jpg" class="img-fluid" alt="blog-image">
                                  <div class="img-hvr"></div>
                                  <div class="blog-date">
                                      <span class="date">17</span>
                                      <span class="month">Oct</span>
                                  </div>
                                </a>
                            </div>
                            <div class="blog-bottom">
                                <ul class="blog-feat">
                                    <li><i class="icon-user"></i><a href="#">Admin</a></li>
                                    <li><i class="icon-price-tags"></i><a href="#">Family Law</a></li>
                                </ul>
                                <h3>
                                    <a href="blog-detail.php">Internship & The Best Practice For Law Students</a>
                                </h3>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6 col-lg-4 col-exl-3 outer-col">
                        <div class="blog-column">
                            <div class="blog-image">
                                <a href="blog-detail.php">
                                  <img src="compress/post-three-md.jpg" srcset="compress/post-three-sm.jpg 400w,compress/post-three-md.jpg 992w,compress/post-three-lg.jpg 1920w" width="650" height="555" class="img-fluid" alt="blog-image">
                                  <div class="img-hvr"></div>
                                  <div class="blog-date">
                                      <span class="date">17</span>
                                      <span class="month">Oct</span>
                                  </div>
                                </a>
                            </div>
                            <div class="blog-bottom">
                                <ul class="blog-feat">
                                    <li><i class="icon-user"></i><a href="#">Admin</a></li>
                                    <li><i class="icon-price-tags"></i><a href="#">Family Law</a></li>
                                </ul>
                                <h3>
                                    <a href="blog-detail.php">Do You Think, You Know Your Civil Rights? Get consultancy from our top Attorneys</a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
         
       <div class="isLoading" id="sectionSeven">
         <div class="partner-section">
            <div class="container">
                <div class="client-box row">
                    <div class="col-4 col-sm-3 col-md-2 client-item">
                        <img src="{{ asset('compress/client-01.png') }}" width="200px" height="80px" class="img-fluid" alt="client-image">
                    </div>
                    <div class="col-4 col-sm-3 col-md-2 client-item">
                        <img src="{{ asset('compress/client-02.png') }}" width="200px" height="80px" class="img-fluid" alt="client-image">
                    </div>
                    <div class="col-4 col-sm-3 col-md-2 client-item">
                        <img src="{{ asset('compress/client-03.png') }}" width="200px" height="80px" class="img-fluid" alt="client-image">
                    </div>
                    <div class="col-4 col-sm-3 col-md-2 client-item">
                        <img src="{{ asset('compress/client-04.png') }}" width="200px" height="80px" class="img-fluid" alt="client-image">
                    </div>
                    <div class="col-4 col-sm-3 col-md-2 client-item">
                        <img src="{{ asset('compress/client-05.png') }}" width="200px" height="80px" class="img-fluid" alt="client-image">
                    </div>
                    <div class="col-4 col-sm-3 col-md-2 client-item">
                        <img src="{{ asset('compress/client-03.png') }}" width="200px" height="80px" class="img-fluid" alt="client-image">
                    </div>
                </div>
            </div>
        </div>
       </div>
       @include('front.layout.footer')
      </div>
      
      <!--  Owl Carousel -->
      <script src="{{ asset('assets/js/owl.js') }}"></script>
      <script type="text/javascript">
          $(".grant-carousel").owlCarousel({
              loop:true,
              margin:15,
              nav:true,
              dots:true,
              autoplay:true,
              autoplayTimeout:3000,
              autoplayHoverPause:true,
              navText : ['<i class="icon-arrow-left2"></i>','<i class="icon-arrow-right2"></i>'],
              responsive:{
                  0:{
                      items:1
                  },
                  576:{
                      items:1
                  },
                  768:{
                      items:2
                  },
                  992:{
                      items:3
                  },
                  1200:{
                      items:3
                  }
              }
          });
          
          
          
          
          $("svg #punjab-map path,svg #text32,#isl-map path").hover(function(){
               $("#isl-map path").css({"fill":"#ccc"});
               $("svg #punjab-map path").css({"fill":"#ccc"});
            },function(){
               $("#isl-map path").css({"fill":"#C6E7F8"});
               $("svg #punjab-map path").css({"fill":"#C6E7F8"});
          });
          $("svg #sindh-map path,svg #text30").hover(function(){
               $("svg #sindh-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #sindh-map path").css({"fill":"#F2EC8A"});
          });
          $("svg #balochistan-map path,svg #text28").hover(function(){
               $("svg #balochistan-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #balochistan-map path").css({"fill":"#FEEAC9"});
          });
          $("svg #fata-map path,svg #text34").hover(function(){
               $("svg #fata-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #fata-map path").css({"fill":"#d5c2db"});
          });
          $("svg #kpk-map path,svg #text36").hover(function(){
               $("svg #kpk-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #kpk-map path").css({"fill":"#E9DCCB"});
          });
          $("svg #gilgit-map path,svg #text38").hover(function(){
               $("svg #gilgit-map path").css({"fill":"#ccc"});
            },function(){
               $("svg #gilgit-map path").css({"fill":"#D9E6D2"});
          });
          $("svg #kashmir-map path").hover(function(){
               $(this).css({"fill":"#ccc"});
            },function(){
               $(this).css({"fill":"#ffffd0"});
          });

          $(window).on("resize load",function(){
              equalizeColumn();
          });

          function equalizeColumn(){
              $(".dash-box").each(function(){
                  var elem = $(this).find(".dash-detail p");
                  if($(window).width() >1440){
                      if (elem.text().length > 60){
                          elem.text(elem.text().substr(0,55)+'...');
                      }
                  }
                  if(($(window).width()<1440) && ($(window).width()>1199)){
                     if (elem.text().length > 120){
                          elem.text(elem.text().substr(0,115)+'...');
                      }
                  }
                  if(($(window).width()<1199) && ($(window).width()>991)){
                     if (elem.text().length > 65){
                          elem.text(elem.text().substr(0,60)+'...');
                      }
                  }
              });
          }
      </script>
</body>
</html>
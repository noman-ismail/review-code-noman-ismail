@include('front.layout.header')
<link rel="stylesheet" href="{{asset('assets/style/all.content.css') }}">
</head>
<body>
	<style>
	.content-section {
	    background: #fff;
	}
	.notfound-content {
	    padding-top: 30px;
	    padding-bottom: 30px;
	}
	</style>
	@if (session()->has('back_url'))
		@php
		 	$back_url = session()->get('back_url');
		@endphp
	@else
		@php
			$back_url = route('base_url');
		@endphp
	@endif
<div class="wrapper">
  @include('front.layout.top-menu')
  @include('front.layout.main-menu')
	<main class="main-content content-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 mx-auto">
					<div class="notfound-content">
						<h3 class="text-green text-uppercase text-center">Page Not Found</h3>
						<div class="row">
							<div class="col-md-6 mx-auto">
								
								<div class="d-flex bottom-button text-center">
									<a href="{{ route('base_url') }}"><button class="btn btn-home">Home</button></a>
									<a href="{{ $back_url }}"><button class="btn btn-back">Go Back</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	@include('front.layout.footer')
</div>
</body>
</html>
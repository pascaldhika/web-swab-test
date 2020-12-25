<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'Laravel') }} | Home Page</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/assets/owl.carousel.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css?ver=1.0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" />
<link rel="stylesheet" href="{{url('css/front.css')}}">

<section class="banner">
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light custom_header navbar-toggler py-3">
		<a class="navbar-brand" href="#">Logo</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarTogglerDemo02">
			<ul class="navbar-nav ml-auto my-lg-0 mt-2 mt-lg-0">
				<li class="nav-item active">
					<a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">About</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">Support</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="{{ route('login') }}">Sign In</a>
				</li>
			</ul>
		</div>
	</nav>
	
	<div class="owl-carousel owl-theme main_banner">
		<div class="item"><img src="https://pbs.twimg.com/media/EGHYvttU4AAYKb7?format=jpg&name=large" alt="" /></div>
		<div class="item"><img src="https://pbs.twimg.com/media/EGHYvtkUcAAuc8T?format=jpg&name=large" alt="" /></div>
		<div class="item"><img src="https://pbs.twimg.com/media/EGHYvtjU0AAO8w1?format=jpg&name=large" alt="" /></div>
	</div>

	<div class="search-sec bg-transparent d-none d-sm-block" style="top:30%;">
		<div class="container text-center tag_line">
			<h3>Book unique experiences</h3>
			<p>Expolore top rated tours, hotels and restaurants around the world</p>
		</div>
	</div>
	<div class="search-sec">
		<div class="container text-center tag_line">
			<img src="{{url('adminlte/dist/img/qrcode.png')}}" style="height:150px;width:150px;margin-top:10px" alt="" />
		</div>
		<div class="container text-center tag_line">
			<p>Scan me to register Test Covid 19</p>
		</div>
		<br>
		<div class="container text-center tag_line">
			<form method="GET" action="{{ route('registrasi.form') }}">
				<button type="submit" class="btn_search btn btn-danger wrn-btn ripple" style="width:150px;margin-bottom:10px"><span>Registrasi Test</span></button>
			</form>
		</div>
	</div>
</section>

<!-- <section class="container-fluid container-custom margin_80_0 py-4">
	<div class="main_title_2 py-4 text-center">
		<span><em></em></span>
		<h2>Our Popular Tours</h2>
		<p>Cum doctus civibus efficiantur in imperdiet deterruisset.</p>
	</div>
	<div id="places" class="owl-carousel owl-theme places pt-4 position-relative">
		<div class="item">
			<div class="box_grid">
				<figure>
					<a href="#!" class="wish_bt"></a>
					<a href="#!"><img src="http://www.ansonika.com/panagea/img/tour_3.jpg" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
					<small>Historic</small>
				</figure>
				<div class="wrapper">
					<h3><a href="#!">Arc Triomphe</a></h3>
					<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
					<span class="price">From <strong>$54</strong> /per person</span>
				</div>
				<ul>
					<li><i class="fa fa-clock-o"></i> 1h 30min</li>
					<li><div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div></li>
				</ul>
			</div>
		</div>
		
		<div class="item">
			<div class="box_grid">
				<figure>
					<a href="#!" class="wish_bt"></a>
					<a href="#!"><img src="http://www.ansonika.com/panagea/img/tour_2.jpg" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
					<small>Churches</small>
				</figure>
				<div class="wrapper">
					<h3><a href="#!">Notredam</a></h3>
					<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
					<span class="price">From <strong>$124</strong> /per person</span>
				</div>
				<ul>
					<li><i class="fa fa-clock-o"></i> 1h 30min</li>
					<li><div class="score"><span>Good<em>350 Reviews</em></span><strong>7.0</strong></div></li>
				</ul>
			</div>
		</div>
		
		<div class="item">
			<div class="box_grid">
				<figure>
					<a href="#!" class="wish_bt"></a>
					<a href="#!"><img src="http://www.ansonika.com/panagea/img/tour_1.jpg" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
					<small>Historic</small>
				</figure>
				<div class="wrapper">
					<h3><a href="#!">Versailles</a></h3>
					<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
					<span class="price">From <strong>$25</strong> /per person</span>
				</div>
				<ul>
					<li><i class="fa fa-clock-o"></i> 1h 30min</li>
					<li><div class="score"><span>Good<em>350 Reviews</em></span><strong>7.0</strong></div></li>
				</ul>
			</div>
		</div>
		
		<div class="item">
			<div class="box_grid">
				<figure>
					<a href="#!" class="wish_bt"></a>
					<a href="#!"><img src="http://www.ansonika.com/panagea/img/tour_4.jpg" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
					<small>Historic</small>
				</figure>
				<div class="wrapper">
					<h3><a href="#!">Versailles</a></h3>
					<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
					<span class="price">From <strong>$25</strong> /per person</span>
				</div>
				<ul>
					<li><i class="fa fa-clock-o"></i> 1h 30min</li>
					<li><div class="score"><span>Good<em>350 Reviews</em></span><strong>7.0</strong></div></li>
				</ul>
			</div>
		</div>
		
		<div class="item">
			<div class="box_grid">
				<figure>
					<a href="#!" class="wish_bt"></a>
					<a href="#!"><img src="http://www.ansonika.com/panagea/img/tour_3.jpg" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
					<small>Museum</small>
				</figure>
				<div class="wrapper">
					<h3><a href="#!">Pompidue Museum</a></h3>
					<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
					<span class="price">From <strong>$45</strong> /per person</span>
				</div>
				<ul>
					<li><i class="fa fa-clock-o"></i> 2h 30min</li>
					<li><div class="score"><span>Superb<em>350 Reviews</em></span><strong>9.0</strong></div></li>
				</ul>
			</div>
		</div>
		
		<div class="item">
			<div class="box_grid">
				<figure>
					<a href="#!" class="wish_bt"></a>
					<a href="#!"><img src="http://www.ansonika.com/panagea/img/tour_1.jpg" class="img-fluid" alt="" width="800" height="533"><div class="read_more"><span>Read more</span></div></a>
					<small>Walking</small>
				</figure>
				<div class="wrapper">
					<h3><a href="#!">Tour Eiffel</a></h3>
					<p>Id placerat tacimates definitionem sea, prima quidam vim no. Duo nobis persecuti cu.</p>
					<span class="price">From <strong>$65</strong> /per person</span>
				</div>
				<ul>
					<li><i class="fa fa-clock-o"></i> 1h 30min</li>
					<li><div class="score"><span>Good<em>350 Reviews</em></span><strong>7.5</strong></div></li>
				</ul>
			</div>
		</div>
	</div>
</section> -->

<div class="backdrop" style="display: none;"></div>
		
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://owlcarousel2.github.io/OwlCarousel2/assets/owlcarousel/owl.carousel.js"></script>
<script src="https://www.jqueryscript.net/demo/Customizable-Animated-Dropdown-Plugin-with-jQuery-CSS3-Nice-Select/js/jquery.nice-select.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$('.main_banner').owlCarousel({
		    loop:true,
			autoplay: true,
		    margin:0,
		    nav:false,
		    center: true,
		    lazyLoad:true,
		    autoWidth:false,
		    responsiveClass:true,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:1
		        },
		        1000:{
		            items:1
		        }
		    }
		});

		$('#city').niceSelect();
	});

	$(document).ready(function() {
		$('.places').owlCarousel({
		    loop:true,
			autoplay: true,
		    margin:0,
		    nav:true,
		    center: true,
		    lazyLoad:true,
		    autoWidth:false,
		    responsiveClass:true,
		    responsive:{
		        0:{
		            items:1
		        },
		        600:{
		            items:2
		        },
		        1000:{
		            items:5	
		        }
		    }
		});
	});

	/********** Panel_Dropdown ***********/
	function close_panel_dropdown() {
		$(".panel-dropdown").removeClass("active")
	}

	$(".panel-dropdown a").on("click", function (event) {
		if ($(this).parent().is(".active")) {
			close_panel_dropdown()
		} else {
			close_panel_dropdown();
			$(this).parent().addClass("active")
		};
		event.preventDefault()
	});

	var mouse_is_inside = false;
	$(".panel-dropdown").hover(function () {
		mouse_is_inside = true
	}, function () {
		mouse_is_inside = false
	});

	$("body").mouseup(function () {
		if (!mouse_is_inside) {
			close_panel_dropdown()
		}
	});

	/********** Quality ***********/
	function qtySum(){
	var arr = document.getElementsByName('qtyInput');
	var tot=0;
	for(var i=0;i<arr.length;i++){
		if(parseInt(arr[i].value))
		tot += parseInt(arr[i].value);
	}
	var cardQty = document.querySelector(".qtyTotal");
	cardQty.innerHTML = tot;
	} 
	qtySum();

	$(function() {
	$(".qtyButtons input").after('<div class="qtyInc"></div>');
	$(".qtyButtons input").before('<div class="qtyDec"></div>');
	$(".qtyDec, .qtyInc").on("click", function() {

		var $button = $(this);
		var oldValue = $button.parent().find("input").val();

		if ($button.hasClass('qtyInc')) {
			var newVal = parseFloat(oldValue) + 1;
		} else {					 
			if (oldValue > 0) {
				var newVal = parseFloat(oldValue) - 1;
			} else {
				newVal = 0;
			}
		}

		$button.parent().find("input").val(newVal);
		qtySum();
		$(".qtyTotal").addClass("rotate-x");
	});

	function removeAnimation() { $(".qtyTotal").removeClass("rotate-x"); }
	const counter = document.querySelector(".qtyTotal");
	counter.addEventListener("animationend", removeAnimation);
	});

	$(function() {
		'use strict';
		$('input[name="dates"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
		$('input[name="dates"]').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('MM-DD-YYYY') + ' > ' + picker.endDate.format('MM-DD-YYYY'));
		});
		$('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});
	});

	/********** Side_Menu ***********/
	$(function(){var e=$("body"),i=$(".navbar-collapse");e.append('<div class="side-menu-overlay"></div>');var s=$(".side-menu-overlay");e.append('<div id="side-menu"></div>');var n=$("#side-menu");n.append('Logo <button class="close"><span aria-hidden="true">x</span></button>');var o=n.find(".close");n.append('<div class="contents"></div>');var a=n.find(".contents");function d(){e.removeClass("side-menu-visible"),s.fadeOut(),setTimeout(function(){n.hide(),e.removeClass("overflow-hidden")},400)}i.on("show.bs.collapse",function(i){i.preventDefault();var o=$(this).html();a.html(o),e.addClass("overflow-hidden"),n.show(),setTimeout(function(){e.addClass("side-menu-visible"),s.fadeIn()},50)}),o.on("click",function(e){e.preventDefault(),d()}),s.on("click",function(e){d()}),$(window).resize(function(){!i.is(":visible")&&e.hasClass("side-menu-visible")?(n.show(),s.show()):(n.hide(),s.hide())})});
</script>
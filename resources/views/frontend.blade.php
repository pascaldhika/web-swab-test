<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'Laravel') }} | Web Test Covid 19</title>
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

<div style="background-image: url('adminlte/dist/img/frontend-min.jpg');background-size:cover;">
<section class="banner">
	<nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light custom_header navbar-toggler py-3">
		<img src="{{url('adminlte/dist/img/logo.jpeg')}}" style="height:60px;width:60px;" alt="" /><a class="navbar-brand" href="#" style="margin-left:10px;"> <h5> PT Taishan Alkes Indonesia</h5></a>
	</nav>
	
	<div class="container text-center tag_line">
		<img src="{{url('adminlte/dist/img/qr-code.png')}}" style="height:200px;width:200px;margin-top:13%;margin-bottom:3%; alt="" />
		</div>
		<div class="container text-center tag_line">
			<h5>Scan me to register Test Covid 19</h5>
			<br><h6>OR</h6><br>
		</div>
		<div class="container text-center tag_line">
			<form method="GET" action="{{ route('registrasi.form') }}">
				<button type="submit" class="btn_search btn btn-danger wrn-btn ripple" style="width:77%;margin-bottom:13%;"><span>
				<h5>Click to Registration Test</h5></span></button>
			</form>
		</div>
</section>
</div>


		
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
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('meta')

    <title>
        @section('title')
            PODREC Laravel
        @show
        {{--@yield('title', 'Laravel')--}}

    </title>

    <!-- Bootstrap Core CSS -->
    {{--<link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">--}}
    {{--<link href="assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">--}}
    {{--<link href="assets/css/bootstrap-theme.css" rel="stylesheet" type="text/css">--}}
    {{--<link href="assets/css/jquery.validate.css" rel="stylesheet" type="text/css">--}}

    {{--{!! HTML::style( asset('assets/css/bootstrap.min.css')) !!}--}}




    {!! Html::style('assets/css/bootstrap.min.css') !!}
    {!! Html::style('assets/css/bootstrap-theme.min.css') !!}
    {!! Html::style('assets/css/font-awesome.min.css') !!}
    {!! Html::style('assets/css/jquery.validate.css') !!}


    {{--{{ Html::style('laravelfiles/assets/css/bootstrapValidator.min.css') }}--}}



<!-- Custom CSS -->
    {{--<link href="assets/css/simple-sidebar.css" rel="stylesheet" type="text/css">--}}

    {!! Html::style('assets/css/simple-sidebar.css') !!}
    {!! Html::style('assets/css/custom.css') !!}



<!-- Custom Notifications -->
    {!! Html::style('assets/css/jquery.noty.css') !!}
    {!! Html::style('assets/css/noty_theme_default.css') !!}
    {!! Html::style('assets/css/noty_theme_twitter.css') !!}


<!-- Kendo CSS -->

    {!! Html::style('assets/css/kendo.dataviz.default.min.css') !!}
    {!! Html::style('assets/css/kendo.bootstrap.min.css') !!}
    {!! Html::style('assets/css/kendo.common-bootstrap.min.css') !!}
    {!! Html::style('assets/css/kendo.dataviz.min.css') !!}
    {!! Html::style('assets/css/kendo.common.min.css') !!}

<!-- End of Kendo CSS -->


    <!-- Ui Dialog CSS -->


    {!! Html::style('assets/css/jquery-confirm.min.css') !!}
    {!! Html::style('assets/css/jquery-ui.min.css') !!}

<!-- End of Ui Dialog CSS -->

    <!-- Colorbox CSS -->

    {!! Html::style('assets/css/colorbox.css') !!}

<!-- End of Colorbox CSS -->


    @yield('styles')
<!-- Html5 Shim and Respond.js IE8 support of Html5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>

    <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>-->
    <!--<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>-->

    {{--<![endif]-->--}}


    {!! Html::script('assets/js/respond.min.js') !!}
    {!! Html::script('assets/js/html5shiv.js') !!}


<!-- jQuery -->

    {{--<script src="assets/js/jquery.js"></script>--}}


    {{--<script src="assets/js/jquery-1.11.0.min.js" type="text/javascript" ></script>--}}
    {{--<script src="assets/js/jquery.validate.js" type="text/javascript" ></script>--}}
    {{--<script src="assets/js/jquery.validation.functions.js" type="text/javascript" ></script>--}}

    {{--{{ Html::script('laravelfiles/assets/js/jquery.js') }}--}}
    {!! Html::script('assets/js/jquery-3.3.1.min.js') !!}
    {!! Html::script('assets/js/jquery.validate.js') !!}
    {!! Html::script('assets/js/jquery.validation.functions.js') !!}



<!-- Bootstrap Core JavaScript -->

    {{--<script src="assets/js/bootstrap.min.js" type="text/javascript" ></script>--}}

    {!! Html::script('assets/js/bootstrap.min.js') !!}
    {!! Html::script('assets/js/app.js') !!}


    {{--@yield('scripts')--}}


    {{--{{ Html::script('laravelfiles/assets/js/bootstrapValidator.min.js') }}--}}

<!-- Menu Toggle Script -->

    <!-- Custom Notifications -->

    {!! Html::script('assets/js/jquery.noty.js') !!}



<!-- Kendo JS -->



    {!! Html::script('assets/js/kendo.all.min.js') !!}
    {!! Html::script('assets/js/jszip.min.js') !!}
    {!! Html::script('assets/js/jquery.metisMenu.js') !!}
    {!! Html::script('assets/js/jquery.slimscroll.min.js') !!}
    {{--{!! Html::script('assets/js/inspinia.js') !!}--}}
    {!! Html::script('assets/js/pace.min.js') !!}




<!-- End of Kendo JS -->


    <!-- Ui Dialog JS -->

    {!! Html::script('assets/js/jquery-confirm.min.js') !!}
    {!! Html::script('assets/js/jquery-ui.min.js') !!}


<!-- End of Ui Dialog JS -->


    <!-- Colorbox JS -->

    {!! Html::script('assets/js/jquery.colorbox-min.js') !!}

<!-- End of Colorbox JS -->


    <!-- Ajax File upload -->

    {!! Html::script('assets/js/rajax.js') !!}

<!-- End of Ajax File upload -->


    {{--@yield('javascript')--}}
    {{--@yield('head')--}}
    @yield('script')

    <script>
		$("#menu-toggle").click(function (e) {
			e.preventDefault();
			$("#wrapper").toggleClass("toggled");
		});

		// To Display Multiple Modal

		$(document).on('show.bs.modal', '.modal', function (event) {
			var zIndex = 1040 + (10 * $('.modal:visible').length);
			$(this).css('z-index', zIndex);
			setTimeout(function () {
				$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
			}, 0);
		});


		// End of Display Multiple Modal
    </script>


</head>





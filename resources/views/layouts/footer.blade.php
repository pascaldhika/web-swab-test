<footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="#">{{ config('app.name', 'Laravel') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
    	<b><a href="#" id="homeoutlet">{{ (session('outlet')) ? App::make('App\Http\Controllers\HomeController')->cekOutlet(session('outlet')) : ''}}</a></b>
      	<b>Version</b> {{ config('app.version', '1.0.0-beta') }}
    </div>
</footer>
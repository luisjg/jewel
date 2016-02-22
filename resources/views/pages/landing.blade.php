@extends('layouts.master')

@section('title') Welcome @stop

@section('content')
	<div class="main-banner">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<div class="brand-logo">
						<img src="{{ asset('imgs/logo-thin.png') }}" alt="Jewel HTML Web Service">
					</div>
					<div class="brand-message">	
						<p class="text-yellow">A <span class="emphasis">RESTful</span> &lt;HTML/&gt; Web Service <span class="emphasis">interface</span> that customizes all of your favorite Web Services.</p>
						<div class="brand-action">						
							<button class="btn btn-default"><a href="{{ url('/docs')}}">Learn More</a></button>
							<button class="btn btn-primary">Get Started</button>
							<div class="version text-right">Version 2.1.0</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop
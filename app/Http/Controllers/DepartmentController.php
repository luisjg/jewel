<?php namespace Jewel\Http\Controllers;

use Jewel\Http\Requests;
use Jewel\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Jewel\Department;
use Jewel\Person;
use Jewel\Http\Controllers\Response;


class DepartmentController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{	
		// $dept_id = \Request::get('department_id');

		// // RETURN PEOPLE WHO HAVE DEPARTMENT
		// $persons = Person::whereHas('departmentUser', function($q) use ($dept_id) {
		// 	$q->where('department_id', 'academic_departments:'.$dept_id);
		// })
		// // ONLY LOAD THE DEPARTMENT REQUESTED (makes using first() ok below)
		// ->with(['departmentUser' => function($q) use ($dept_id) {
		// 	$q->where('department_id', 'academic_departments:'.$dept_id);
		// }])
		// ->get();

		// // Separate Data By Role
		// $roles = [
		// 	'chair'=>'',
		// 	'faculty' =>'',
		// 	'lecturer'=>'',
		// 	'emeritus'=>''
		// ];
		
		// foreach ($persons as $person) {

		// 	// Grab Person Role Name
		// 	$role_name = $person->departmentUser->first()->role_name; 

		// 	// Interpolate & Append Markup
		// 	if (array_key_exists($role_name, $roles)) {
		// 		$roles[$role_name] .= "
		// 		<h3 class='jewel-common-name'>{$person->common_name}</h3>
		// 		<ul>
		// 			<li class='jewel-role-name'><strong>Role: </strong>{$person->departmentUser->first()->role_name}</li>
		// 			<li class='jewel-email'><strong>Email: </strong><a href='mailto:{$person->email}'>{$person->email}</a></li>
		// 			<li class='jewel-bio'><strong>Biography: </strong>{$person->biography}</li>
		// 			<li class='jewel-url'><a href='https://faculty-demo.sandbox.csun.edu/people/{$person->getEmailURIAttribute()}'>View Profile</a></li>
		// 		</ul>";
		// 	}
		// }

		// // Build Department Listing
		// $deptList = "";
		// foreach ($roles as $role => $data) {
		// 	$deptList .= "<h2 id='{$role}'>".ucwords($role)."</h2>${data}<hr>";
		// }
		
		// // Remove Newline & Tabs
		// $deptList = preg_replace('/(\\n)|(\\t)/', '', $deptList);

		// // Optional HTML Formatting
		// if (\Request::get('format') === 'html') {
		// 	return $deptList;
		// }

		$deptList = '
<!DOCTYPE HTML>
<html class="no-js" lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="pragma" content="no-cache">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="csrf-token" content="iTcDej2rJy1oReSKxxueOQjVaV2tIG9rZ9J6HABh" />
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">

			<title>Faculty - people/trevor.greenleaf</title>

        <meta name="description" content="">
		<link rel="icon" href="https://faculty-demo.sandbox.csun.edu/favicon.png" type="image/x-icon">
        <!--[if lt IE 9]>
            <script src="https://faculty-demo.sandbox.csun.edu/js/html5shiv.min.js"></script>

        <![endif]-->

		        
				<script src="https://faculty-demo.sandbox.csun.edu/js/museo-sans-typekit.js"></script>

		<link media="all" type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,700">

		<link media="all" type="text/css" rel="stylesheet" href="https://faculty-demo.sandbox.csun.edu/css/components.css">

				<link media="all" type="text/css" rel="stylesheet" href="https://faculty-demo.sandbox.csun.edu/css/app.css">

	</head>
	<body>
	
				<div class="header">
		<div class="web-one">
	<nav class="navbar navbar-default" role="navigation">
		<div class="container hidden-xs">
			<div class="row">
				<div class="col-sm-7">
					<a class="navbar-brand hidden-xs" href="http://www.csun.edu">
						<img src="https://faculty-demo.sandbox.csun.edu/imgs/logoCSUN.jpg" alt="California State University, Northridge - CSUN">
					</a>
									</div>
				<img src="https://faculty-demo.sandbox.csun.edu/imgs/nav.jpg" class="pull-right mini-nav" alt="">
								<a class="admin-access btn btn-default hidden-xs pull-right" href="https://faculty-demo.sandbox.csun.edu/login?return=https%3A%2F%2Ffaculty-demo.sandbox.csun.edu%2Fpeople%2Ftrevor.greenleaf">Faculty Access &nbsp;<i class="fa fa-user"></i></a>
						</div>
		</div>
		<div class="navbar-bg">
	
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand hidden-sm hidden-md hidden-lg" style="margin-top: 3px;" href="https://faculty-demo.sandbox.csun.edu"><img src="https://faculty-demo.sandbox.csun.edu/imgs/mobile-logo.png" alt="CSUN Faculty Logo"></a>
			</div>

			<div class="navbar-body">
				<div class="container">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-center">
							<li><a href="http://www.csun.edu/node/98186">Home</a></li>
							<!-- <li class=""><a href="http://www.csun.edu/node/98186/stories">Stories</a></li> -->
							<li class=""><a href="https://faculty-demo.sandbox.csun.edu/stories">Stories</a></li>
							<li class="active"><a href="https://faculty-demo.sandbox.csun.edu/people">Faculty</a></li>
							<li class=""><a href="https://faculty-demo.sandbox.csun.edu/expertise">Expertise</a></li>
							<li class=""><a href="http://www.csun.edu/node/98186/resources">Resources</a></li>
																					<li class="hidden-sm hidden-md hidden-lg "><a href="https://faculty-demo.sandbox.csun.edu/login">Faculty Access &nbsp;<i class="fa fa-user"></i></a></li>
							
						</ul>
					</div><!-- /.navbar-collapse -->					
				</div>
			</div>
		</div>
	</nav>
</div>	
</div>			<div class="wrapper-main">
				<div class="wrapper">
					
<div class="section-mini">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
						<style>
				.profile-avatar{
					position: relative;
					display: block;
				}
				.edit-img{
					position: absolute;
					background-color: rgba(255,255,255,0);
					z-index: -1;
					right: 0;
					left: 0;
					bottom: 0px;
					text-align: center;
					padding: 10px 0 15px;
					font-weight: bold;
					color: #4a4a4a;
					font-size: 14px;
				}
				.profile-avatar:hover .edit-img{
					background-color: rgba(255,255,255,0.75);
					z-index: 10;
				}				
			</style>
				<a href="https://faculty-demo.sandbox.csun.edu/people/trevor.greenleaf/profile-info/edit" class="profile-avatar pull-left">
						<img class="img-circle" src="https://faculty-demo.sandbox.csun.edu/uploads/imgs/person_1432323214.jpg" alt="Trevor M Greenleaf">
					<div class="edit-img">Edit Image</div>
				</a>
				<div class="profile-info pull-left">
					<h1>Trevor M Greenleaf</h1>
					<p class="profile-role">Lecturer</p>
					<ul class="list-unstyled list-inline">
						<li><strong>Email: </strong><a href="mailto:trevor.greenleaf@csun.edu">trevor.greenleaf@csun.edu</a></li>
						<li><strong>Phone: </strong><a href="tel:Not Available">Not Available</a></li>
					</ul>
									</div>
			</div>
		</div>
	</div>
</div>
<div class="section-mini light-gray">
	<div class="container">
		<div class="row ">
			<div class="col-sm-8">
				<!-- <div class="row">
					<div class="col-sm-12">
			    		<h2 class="page-header">Basic Information</h2>
									    		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corrupti cumque perspiciatis voluptas minima veritatis nihil molestias, pariatur obcaecati odit earum hic facilis aut quae debitis quia molestiae minus, commodi accusamus quo, reprehenderit vitae! Dolorum provident odio repellat tempore rerum veniam maiores vel officiis facere ullam reiciendis asperiores quasi ut eos sunt quia necessitatibus magni, ipsam autem nesciunt repellendus consequatur illum! Quod libero dignissimos sed perferendis?</p>
					</div>
				</div> -->
				<div class="row">

					<div class="col-sm-12">
						<h2 class="page-header">Courses</h2>
												<br>
						<div class="table-responsive">
							<table class="table table-striped table-hover table-bordered" style="background-color: #fff;">
						        <thead>
									<tr>
										<th>Course #</th>
										<th>Catalog #</th>
										<th>Title</th>
										<th>Days</th>
										<th>Time (Start-End)</th>
										<th>Location</th>
										<th>Syllabus</th>
									</tr>
						        </thead>
						        <tbody>
																			<tr><td data-title="Information:" colspan="7">Trevor\'s courses are currently unavailable.</td></tr>
															        </tbody>
						      </table>
						</div>			
					</div>


					<div class="col-sm-12">
						<h2 class="page-header">Office Hours</h2>
												<br>
						<div class="table-responsive">
						  	<table class="table table-striped table-hover table-bordered" style="background-color: #fff;">
						        <thead>
									<tr>
										<th>Day</th>
										<th>Hours</th>
										<th>Location</th>
										<th>Description</th>
									</tr>
						        </thead>
						        <tbody>
																	<tr><td data-title="Information:" colspan="4">Trevor\'s office hours are currently unavailable.</td></tr>
														        </tbody>
						    </table>
						</div>					
					</div>
				
					<div class="col-sm-12">

						<h2 class="page-header">Connections</h2>
						<br>

						
										</div>

				</div>
				</div>


				<div class="col-sm-4">
					<h2>Get Started</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa debitis doloremque sunt, officia dicta itaque maiores exercitationem rerum distinctio provident, sed delectus odio, porro hic at voluptatem minima nam aliquid.</p>
				</div> 


				<div class="col-sm-4">
					<h2>Expertise</h2>
										
																<a class="exp label label-info" href="https://faculty-demo.sandbox.csun.edu/expertise/search?query=career+coaching">Career coaching</a>
											<a class="exp label label-info" href="https://faculty-demo.sandbox.csun.edu/expertise/search?query=moodzer">moodzer</a>
														</div> 

		</div>

	</div>
</div>
				</div>
				<footer>
	<div class="container">
		<div class="row">
			<div class="col-sm-5">
				<div class="row">
					<div class="col-sm-3 footer-seal">
						<img src="https://faculty-demo.sandbox.csun.edu/imgs/footer-seal.png" alt="Seal for California State University, Northridge">						
					</div>
					<div class="col-sm-9">
						<ul class="list-unstyled">
							<li><strong>Faculty</strong> <br>&copy; California State University, Northridge</li>
							<li>18111 Nordhoff Street, Northridge, CA 91330</li>
							<li>Phone: (818) 677-1200 / <a href="http://www.csun.edu/contact/" target="_blank">Contact Us</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-7">
				<div class="row">
					<div class="col-sm-4">
						<ul class="list-unstyled">
							<li><a href="http://www.csun.edu/emergency/" target="_blank">Emergency Information</a></li>
							<li><a href="http://www.csun.edu/afvp/university-policies-procedures/" target="_blank">University Policies &amp; Procedures</a></li>
						</ul>
					</div>
					<div class="col-sm-4">
						<ul class="list-unstyled">
							<li><a href="http://www.csun.edu/sites/default/files/900-12.pdf" target="_blank">Terms and Conditions for Use</a></li>
							<li><a href="http://www.csun.edu/sites/default/files/500-8025.pdf" target="_blank">Privacy Policy</a></li>
							<li><a href="http://www.csun.edu/it/document-viewers" target="_blank">Document Reader</a></li>
						</ul>
					</div>
					<div class="col-sm-4">
						<ul class="list-unstyled">
							<li><a href="http://www.calstate.edu/" target="_blank">California State University</a></li>
						</ul>
						<a class="btn btn-primary-outline btn-sm" href="https://faculty-demo.sandbox.csun.edu/feedback" target="_blank">Give Us Feedback</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>			</div>

			
		<div class="metalab-footer">
	<div class="metalab-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-sm-6">
					<div class="metalab-branding">
						<img src="https://faculty-demo.sandbox.csun.edu/imgs/meta-logo-horz.png" alt="CSUN META Lab Logo">
						<ul class="list-unstyled">
							<li><a href="http://metalab.csun.edu">metalab.csun.edu</a></li>
						</ul>
					</div>
				</div>
				<div class="col-sm-6">
					<ul class="list-unstyled metalab-tagline">
						<li>Learn. Create. Experiment.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
						<script src="https://faculty-demo.sandbox.csun.edu/js/app.js"></script>

			</body>
</html>';
		$deptList = preg_replace('/(\\n)|(\\t)/', '', $deptList);

		// Dumb Web-One Needs A Double Casted Array
		return response()->json([['data' => $deptList]])->setCallback('jsonp_received');

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}

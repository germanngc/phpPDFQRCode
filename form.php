<?php
require_once dirname(__FILE__) . '/config/config.php';
?><html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
		<meta name="title" content="Zogen Generate PDF - by Nina Code">
		<meta name="author" content="Nina Code">
		<meta name="theme-color" content="#7952b3">

		<title>Zogen Generate PDF - by Nina Code</title>

		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">

		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
					font-size: 3.5rem;
				}
			}
		</style>

		<!-- Custom styles for this template -->
    <link href="offcanvas.css" rel="stylesheet">
	</head>

	<body class="bg-light">
		<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
			<div class="container-fluid">
				<a class="navbar-brand" href="#">Offcanvas navbar</a>
				<button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
					<ul class="navbar-nav me-auto mb-2 mb-lg-0">
						<li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Dashboard</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Notifications</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
						<li class="nav-item"><a class="nav-link" href="#">Switch account</a></li>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Settings</a>

							<ul class="dropdown-menu" aria-labelledby="dropdown01">
								<li><a class="dropdown-item" href="#">Action</a></li>
								<li><a class="dropdown-item" href="#">Another action</a></li>
								<li><a class="dropdown-item" href="#">Something else here</a></li>
							</ul>
						</li>
					</ul>

					<form class="d-flex">
						<input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
						<button class="btn btn-outline-success" type="submit">Search</button>
					</form>
				</div>
			</div>
		</nav>

		<div class="nav-scroller bg-body shadow-sm">
			<nav class="nav nav-underline" aria-label="Secondary navigation">
				<a class="nav-link active" aria-current="page" href="#">Dashboard</a>
				<a class="nav-link" href="#">
					Friends
					<span class="badge bg-light text-dark rounded-pill align-text-bottom">27</span>
				</a>
				<a class="nav-link" href="#">Explore</a>
				<a class="nav-link" href="#">Suggestions</a>
				<a class="nav-link" href="#">Link</a>
				<a class="nav-link" href="#">Link</a>
				<a class="nav-link" href="#">Link</a>
				<a class="nav-link" href="#">Link</a>
				<a class="nav-link" href="#">Link</a>
			</nav>
		</div>

		<main class="container">
			<div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
				<img class="me-3" src="/docs/5.0/assets/brand/bootstrap-logo-white.svg" alt="" width="48" height="38">
				<div class="lh-1">
					<h1 class="h6 mb-0 text-white lh-1">Bootstrap</h1>
					<small>Since 2011</small>
				</div>
			</div>

			<div class="my-3 p-3 bg-body rounded shadow-sm">
                <form>
                    <div class="mb-3">
                        <h2>Personal Information </h2>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">1.Type of test</label>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            COVID-19 Antigen Test (Free of charge)
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            COVID-19 PCR Test (USD $116)
                        </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">2.Names</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">As stated in your passport.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">3.Last Names</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                        <div id="emailHelp" class="form-text">As stated in your passport.</div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">5.Birthdate</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">6.Sex</label>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Female
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Male
                        </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">7.Passport Number</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">8.Villa Number</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">9.Departure dater</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">10.Are you booking as a Family/Group member or as an Individual member?</label>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Individual
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Family/Group
                        </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">11.Are you the main member of Family/Group and/or booking the appointment on behalf of all of them?</label>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Yes - Please book your appointment on next link
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                        <label class="form-check-label" for="flexRadioDefault2">
                            No - Don't book any appointment
                        </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
			</div>
		</main>

		<!-- JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	</body>
</html>
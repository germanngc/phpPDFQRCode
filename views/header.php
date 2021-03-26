<nav id="mainNavigation"
	class="navbar navbar-expand-lg fixed-top navbar-light bg-white"
	aria-label="Main navigation">
	<div class="container-fluid">
		<a class="navbar-brand" href="<?php echo $phpPDFQRConfig::$rootURL; ?>">zogen | Laboratorio Salazar</a>
		<button class="navbar-toggler p-0 border-0" type="button" data-bs-toggle="offcanvas" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
			<?php if (isset($_SESSION["labsal_user"])): ?> 
			<ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item"><a class="nav-link active" aria-current="page" href="<?php echo $phpPDFQRConfig::$rootURL; ?>">Dashboard</a></li>
				<li class="nav-item"><a class="nav-link active" aria-current="page" href="<?php echo $phpPDFQRConfig::$rootURL; ?>/form.php">Crear Registro</a></li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="javascript:void(0);" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Usuarios</a>

					<ul class="dropdown-menu" aria-labelledby="dropdown01">
						<li><a class="dropdown-item" href="<?php echo $phpPDFQRConfig::$rootURL; ?>/users.php?action=list">Ver Usuarios</a></li>
						<li><a class="dropdown-item" href="<?php echo $phpPDFQRConfig::$rootURL; ?>/users.php?action=create">Crear Usuario</a></li>
					</ul>
				</li>

				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="javascript:void(0);" id="dropdown01" data-bs-toggle="dropdown" aria-expanded="false">Configuración</a>

					<ul class="dropdown-menu" aria-labelledby="dropdown01">
						<li><a class="dropdown-item" href="<?php echo $phpPDFQRConfig::$rootURL; ?>/logout.php">Cerrar Sesión</a></li>
					</ul>
				</li>
			</ul>

			<!--<form class="d-flex mb-0">
				<input class="form-control me-2" type="search" placeholder="Búsqueda" aria-label="Búsqueda">
				<button class="btn btn-outline-success" type="submit">Búsqueda</button>
			</form>-->
			<?php endif; ?> 
		</div>
	</div>
</nav>

<div class="clear-fix mt-4"></div>

<?php /* ?><div class="nav-scroller bg-body shadow-sm">
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
</div><?php /*/ ?>
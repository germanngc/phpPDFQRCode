		<!-- Footer -->
		<footer id="pagefooter" class="bg-light text-center text-lg-start">
			<!-- Grid container -->
			<div class="container p-4">
				<!--Grid row-->
				<div class="row">
					<!--Grid column-->
					<div class="col-lg-12 col-md-12 mb-4 mb-md-0 text-muted fst-italic small">
						<h5 class="text-upper case">Administrador de Pruebas SARS COVID 19</h5>

						<p style="text-align: justify;"><strong>Sus datos están protegidos:</strong> Cualquier información que se recabe en este mini-sitio será solo usada exclusivamente para las pruebas de laboratorio correspondiente. Nunca proporcione contraseñas, cuentas bancarias o acceso de ningun tipo. // <strong>Your data is protected: </strong> Any information collected on this mini-site will only be used exclusively for the corresponding laboratory tests. Never provide passwords, bank accounts, or access of any kind.</p>
					</div>
					<!--Grid column-->
				</div>
				<!--Grid row-->
			</div>
			<!-- Grid container -->

			<!-- Copyright -->
			<div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
				&copy; <?php echo date('Y'); ?> Copyright:
				<a class="text-dark" href="https://www.zogen.mx/">Zogen</a> //
				<a class="text-dark" href="https://laboratoriosalazar.com.mx/">Laboratorio Salazar</a> //
				<a class="text-dark" href="https://www.ninacode.mx/">Nina Code</a>
			</div>
			<!-- Copyright -->
		</footer>
		<!-- Footer -->

		<!-- JavaScript Bundle with Popper -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<script>
			document.addEventListener("DOMContentLoaded", function(event) {
				let footerHeight = document.getElementById('pagefooter').offsetHeight;
				let bodyElement = document.getElementsByTagName('body')[0].style.paddingBottom = (footerHeight + 56) + "px";

				var bootstrapButton = $.fn.button.noConflict() // return $.fn.button to previously assigned value
				$.fn.bootstrapBtn = bootstrapButton // give $().bootstrapBtn the Bootstrap functionality
			});
		</script>
	</body>
</html>
<?php $phpPDFQRConfig::dbClose(); ?> 

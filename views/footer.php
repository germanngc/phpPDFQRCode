		<!-- Footer -->
		<footer id="pagefooter" class="bg-light border-top text-center text-lg-start">
			<!-- Grid container -->
			<div class="container-fluid py-2 px-4">
				<!--Grid row-->
				<div class="row">
					<!--Grid column-->
					<div class="col-lg-12 col-md-12 mb-4 mb-md-0 text-muted fst-italic small">
						<h5 class="text-upper case">Administrador de Pruebas SARS-CoV-2 (COVID 19)</h5>

						<p style="text-align: justify;">
							<strong>Sus datos están protegidos.</strong> Cualquier información que se recabe en este mini-sitio será solo usada exclusivamente para las pruebas de laboratorio correspondiente. Nunca proporcione contraseñas, cuentas bancarias o acceso de ningun tipo.
							|
							<strong>Your data is protected.</strong> Any information collected on this form will be used exclusively for the corresponding laboratory tests. Do not provide sensitive information such as passwords, bank account number, or any other.
						</p>
					</div>
					<!--Grid column-->
				</div>
				<!--Grid row-->
			</div>
			<!-- Grid container -->

			<!-- Copyright -->
			<div id="CopyFooter" class="text-center p-3">
				&copy; <?php echo date('Y'); ?> Copyright:
				<a href="https://www.zogen.mx/" target="_backlink">zogen</a> /
				<a href="https://laboratoriosalazar.com.mx/" target="_backlink">Laboratorio Salazar</a> /
				<a href="https://www.ninacode.mx/" target="_backlink">Nina Code</a>
			</div>
			<!-- Copyright -->
		</footer>
		<!-- Footer -->

		<!-- Loading -->
		<div class="loading">Loading&#8230;</div>

		<!-- JavaScript Bundle with Popper -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
		<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous"></script>

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

<?php
require_once dirname(__FILE__) . '/config/config.php';
require_once dirname(__FILE__) . '/config/forms.php';

$pageTitle = "Thanks for register";

include dirname(__FILE__) . '/views/body.php';
?> 
<main class="container">
	<?php $phpPDFQRConfig::flashGet(); ?> 

	<div class="my-3 p-3 bg-labsal text-labsal rounded shadow-sm">
		<h2>Thanks!</h2>
		<?php if (isset($_SESSION["tmp_expedient"])): ?> 
		<p>Your expedient number is: <?php echo $_SESSION["tmp_expedient"];?> </p>
		<?php endif; ?> 
	</div>

	<?php if (isset($_SESSION["tmp_expedient"])): ?> 
	<div class="my-3 p-3 bg-body rounded shadow-sm">
		<p>You are about to schedule your Individual or Family/Group appointment.</p>
		
		<p>Please click here:</p>
		
		<hr>
		
		<p><a href="https://outlook.office365.com/owa/calendar/COVID19zogenRoyalISlander@NETORGFT1596937.onmicrosoft.com/bookings/" target="_appointment">https://outlook.office365.com/owa/calendar/COVID19zogenRoyalISlander@NETORGFT1596937.onmicrosoft.com/bookings/</a></p>

		<hr>

		<p>If you are not an Individual or the Main family member, please don't book any appointment.</p>
	</div>
	<?php endif; ?> 
	<?php unset($_SESSION["tmp_expedient"]); ?> 
</main>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 

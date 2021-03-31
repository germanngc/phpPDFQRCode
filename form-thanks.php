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
		<p>Your expedient number is: <mark class="small"><?php echo $_SESSION["tmp_expedient"];?></mark></p>
		<?php   if (isset($_SESSION["tmp_expedient_result"]) && is_array($_SESSION["tmp_expedient_result"])): ?> 
		<?php     if (sizeof($_SESSION["tmp_expedient_result"]["success"]) > 0): ?> 
		<p>Also below member are the expedient numbers for your family or group:</p>
		<p>
		<?php       foreach ($_SESSION["tmp_expedient_result"]["success"] AS $fid => $success): ?> 
			<mark class="small"><?php echo $fid; ?></mark>
		<?php       endforeach; ?> 
		</p>
		<?php     endif; ?> 
		<?php     if (sizeof($_SESSION["tmp_expedient_result"]["errors"]) > 0): ?> 
		<p>Unfurtanatelly we couldn't create a expedient for:</p>
		<p>
		<?php       foreach ($_SESSION["tmp_expedient_result"]["errors"] AS $fid => $errors): ?> 
			<?php echo $errors["first_name"]; ?><br>
		<?php       endforeach; ?> 
		</p>
		<?php     endif; ?> 
		<?php   endif; ?> 
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
		<p><mark class="small p-2 d-block"><strong class="text-danger">PLEASE NOTE: </strong> If you book an appointment please be advised on doing it 48 to 72 hours prior your departure date, otherwise your results may not come in time.</mark></p>
	</div>
	<?php endif; ?> 
	<?php unset($_SESSION["tmp_expedient"], $_SESSION["tmp_expedient_result"]); ?> 
</main>

<?php include dirname(__FILE__) . '/views/footer.php'; ?> 

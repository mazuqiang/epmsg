<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<div id="main-content">
		<div class="k_inp">
		<form action="<?php echo $do_url ;?>" name="submitForm" id="merchant_form" method="post">
			<fieldset>
					<input type='hidden' name='app_id' value='<? echo $smsapp->get_app_id(); ?>' />
					<p>
						<label for="drappdown" style="width:74px;">
								应用名称：
						</label>
						<input class="mf" name="app_name" type="text" value="<? echo $smsapp->get_app_name(); ?>" />
						<br />					
					</p>
					<input type="hidden" value="<?php echo $rurl; ?>" name="rurl" />
					<input class="button" type="submit" value="确定提交" />
				</fieldset>
				<!-- End of fieldset -->
			</form>
			<!-- End of Form -->
		</div>
<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
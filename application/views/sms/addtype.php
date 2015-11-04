<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<div id="main-content">
		<div class="k_inp">
		<form action="<?php echo(site_url('sms/types/doaddtype'));?>" name="submitForm" id="merchant_form" method="post">
			<fieldset>
					<p>
						<label for="drappdown" style="width:74px;">
								名称：
						</label>
						<input class="mf" name="data[name]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:74px;">
								简述：
						</label>
						<textarea class="mf" name="data[desc]" style="width: 300px; height: 60px;"></textarea>
						<br />
					</p>
					
					<input class="button" type="submit" value="确定提交" />
				</fieldset>
				<!-- End of fieldset -->
			</form>
			<!-- End of Form -->
		</div>
<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
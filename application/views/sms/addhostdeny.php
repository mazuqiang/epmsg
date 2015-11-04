<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<div id="main-content">
		<div class="k_inp">
		<form action="<?php echo(site_url('sms/hostdeny/doadd'));?>" name="submitForm" id="merchant_form" method="post">
			<fieldset>
					<p>
						<label for="drappdown" style="width:74px;">
								号码：
						</label>
						<input class="mf" name="data[mobileNo]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:74px;">
								添加者：
						</label>
						<input class="mf" name="data[author]" type="text" value="" />
						<br />
					</p>
					<input class="button" type="submit" value="确定提交" />
				</fieldset>
				<!-- End of fieldset -->
			</form>
			<!-- End of Form -->
		</div>
<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
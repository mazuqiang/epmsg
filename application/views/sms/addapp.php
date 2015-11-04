<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<div id="main-content">
		<div class="k_inp">
		<form action="<?php echo(site_url('sms/applications/doaddapp'));?>" name="submitForm" id="merchant_form" method="post">
			<fieldset>
					<input type='hidden' name='app_id' value='' />
					<p>
						<label for="drappdown" style="width:74px;">
								应用 ID：
						</label>
						<input class="mf" name="data[appId]" type="text" value="" />
						<br />					
						<label for="drappdown" style="width:74px;">
								应用名称：
						</label>
						<input class="mf" name="data[name]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:74px;">
								应用作者：
						</label>
						<input class="mf" name="data[author]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:74px;">
								应用简述：
						</label>
						<textarea class="mf" name="data[desc]" style="width: 300px; height: 60px;"></textarea>
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
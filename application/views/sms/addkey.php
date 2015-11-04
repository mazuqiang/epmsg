<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<div id="main-content">
		<div class="k_inp">
		<form action="<?php echo(site_url('sms/applications/doaddkey'));?>" name="submitForm" id="merchant_form" method="post">
			<fieldset>
					<input type='hidden' name='data[appId]' value='<?php echo($appId);?>' />
					<p>
						<label for="drappdown" style="width:120px;">
								秘钥：
						</label>
						<input class="mf" name="data[key]" type="text" value="" />
						<br />					
						<label for="drappdown" style="width:120px;">
								每天可以发几条：
						</label>
						<input class="mf" name="data[sentsperday]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:120px;">
								发送间隔(秒)：
						</label>
						<input class="mf" name="data[ablesendperseconds]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:120px;">
								验证码过期时间(秒)：
						</label>
						<input class="mf" name="data[expire]" type="text" value="" />
						<br />
						<label for="drappdown" style="width:120px;">
								选择所属接口(秒)：
						</label>
						<select class="mf" name="interface_id">
							<option value=''>暂时不选</option>
							<?php foreach($interfaces as $k => $v) echo('<option value="'.$k.'">'.$v.'</option>');?>
						</select>
						<br />
						<label for="drappdown" style="width:220px;">
								ip白名单(以半角逗号分隔)：
						</label>
						<textarea class="mf" name="data[allow_ips]" style="width: 300px; height: 60px;"></textarea>
						<br />
						<label for="drappdown" style="width:120px;">
								秘钥简述：
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
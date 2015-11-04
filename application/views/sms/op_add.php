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
					<input type='hidden' name='op_id' value='<? echo $smsop->get_op_id(); ?>' />
					<p>
						<label for="dropdown" style="width:74px;">
								运营商名称：
						</label>
						<input class="mf" name="op_name" type="text" value="<? echo $smsop->get_op_name(); ?>" />
						<br />
						<label for="dropdown" style="width:74px;">
								AppID：
						</label>
						<input class="mf" name="op_appid" type="text" value="<? echo $smsop->get_op_appid(); ?>" />
						<br />
						<label for="dropdown" style="width:74px;">
								账户名：
						</label>
						<input class="mf" name="op_username" type="text" value="<? echo $smsop->get_op_username(); ?>" />
						<br />
						<label for="dropdown" style="width:74px;">
								密码：
						</label>
						<input class="mf" name="op_pwd" type="text" value="<? echo $smsop->get_op_pwd(); ?>" />
						<br />
						<label for="dropdown" style="width:74px;">
								通信密钥：
						</label>
						<input class="mf" name="op_key" type="text" value="<? echo $smsop->get_op_key(); ?>" />
						<br />
						<label for="dropdown" style="width:74px;">
								权重：
						</label>						
						<select  class="dropdown" name="op_weight">
							<option <? if($smsop->get_op_weight()==1 or $smsop->get_op_weight()==''){echo 'selected';}?> value='1'>1</option>
							<option <? if($smsop->get_op_weight()==2){echo 'selected';}?> value='2'>2</option>
							<option <? if($smsop->get_op_weight()==3){echo 'selected';}?> value='3'>3</option>
							<option <? if($smsop->get_op_weight()==4){echo 'selected';}?> value='4'>4</option>
							<option <? if($smsop->get_op_weight()==5){echo 'selected';}?> value='5'>5</option>
							<option <? if($smsop->get_op_weight()==6){echo 'selected';}?> value='6'>6</option>
							<option <? if($smsop->get_op_weight()==7){echo 'selected';}?> value='7'>7</option>
							<option <? if($smsop->get_op_weight()==8){echo 'selected';}?> value='8'>8</option>
							<option <? if($smsop->get_op_weight()==9){echo 'selected';}?> value='9'>9</option>
							<option <? if($smsop->get_op_weight()==10){echo 'selected';}?> value='10'>10</option>
						</select>
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
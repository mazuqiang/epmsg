<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrloger">
	<!-- Wrloger for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
		$(document).ready(function(){
			$("#log_appid").change(function (){
				form1.submit();
			});
		});
		$(document).ready(function(){
			$("#log_opid").change(function (){
				form1.submit();
			});
		});
	</script>
	<div id="main-content">
		<div class="clear">
		</div>
		<!-- End .clear -->
		<div class="content-box" style="width: 1070px;">
			<!-- End .content-box-header -->
			<form method="get" name="form1">
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1" style="width: 1040px;">
						<!-- This is the target div. id must match the href of this div's tab
						-->
						<p>
						搜索方式：
						<select name="sms_search_type" id="sms_search_type" style="width: 100px;">
							<option value="1" <?php if($this->input->get("sms_search_type")== '1') echo 'selected';?>>
								手机号
							</option>
							<option value="2" <?php if($this->input->get("sms_search_type")== '2') echo 'selected';?>>
								短信内容
							</option>
						</select>
							<input class="text-input small-input" type="text" id="small-input" title="输入短信内容的关键字即可" name="log_keywords" value="<?php echo $this->input->get("log_keywords");?>" />
							<input class="button" type="submit" value="模糊搜索" />
						</p>
						<table class='table1' style="width: 1040px;">
							<thead>
								<tr>
									<th width='5%'>
										ID
									</th>
									<th  width='10%'>
										<select name="log_appid" id="log_appid">
											<option value="0">
												--全部应用--
											</option>
											<?php foreach( $app_list as $k => $value ) { ?>
												<option value="<?php echo $value->app_id?>" <?php if($this->input->get("log_appid")== $value->app_id) echo 'selected';?>>
													<?php echo $value->app_name;?>
												</option>
											<?php } ?>
										</select>
									</th>
									<th  width='10%'>
										<select name="log_opid" id="log_opid">
											<option value="0">
												--全部运营商--
											</option>
											<?php foreach( $op_list as $k => $value ) { ?>
												<option value="<?php echo $value->op_id?>" <?php if($this->input->get("log_opid")== $value->op_id) echo 'selected';?>>
													<?php echo $value->op_name;?>
												</option>
											<?php } ?>
										</select>
									</th>
									<th  width='20%'>
										流水号
									</th>
									<th  width='40%'>
										短信内容
									</th>
									<th  width='10%'>
										手机号
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $list as $k => $value ){ ?>
								<tr>
									<td>
										<?php echo $value->log_id;?>
									</td>
									<td>
										<?php echo $value->app_name;?>
									</td>
									<td>
										<?php echo $value->op_name;?>
									</td>
									<td>
										<?php echo $value->log_orderno;?>
									</td>
									<td>
										<?php echo mb_substr($value->log_msg,0,50,'utf-8')."...";?>
									</td>
									<td>
										<?php echo mb_substr($value->log_mobileno,0,11,'utf-8')."...";?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<div class="bulk-actions align-left">
											总数：<?php echo $count;?>
										</div>
										<div class="pagination">
											<?php echo $pages ;?>
										</div>
										<!-- End .pagination -->
										<div class="clear">
										</div>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</form>
			<!-- End .content-box-content -->
		</div>

<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
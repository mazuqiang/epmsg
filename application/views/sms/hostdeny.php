<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(id) {
	var answer = confirm("删？")
	if (answer){
	    window.location.href="<?php echo(site_url('sms/hostdeny/dodel'));?>/"+id; 
	}
	else{
		return false;
	}
	}
	</script>
	<div id="main-content">
		<div class="clear">
		</div>
		<!-- End .clear -->
		<div class="content-box" style="width: 870px;">
			<!-- End .content-box-header -->
			<form method="get" name="form1">
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1" style="width: 840px;">
						<!-- This is the target div. id must match the href of this div's tab
						-->
						<p>
							　所有号码
							<!--<input class="text-input small-input" type="text" id="small-input" title="输入短信应用名称的关键字即可" name="app_name" value="<?php echo $this->input->get("app_name");?>" />-->
							<input class="button" onClick="location.href='<?php echo(site_url('sms/hostdeny/add'));?>'" type="button" value="添加新禁发号码" />
						</p>
						<table class='table1' style="width: 840px;">
							<thead>
								<tr>
									<th width='20%'>
										号码
									</th>
									<th width='20%'>
										添加者
									</th>
									<th width='20%'>
                                                                                                                         添加时间
									</th>
									<th>
										<div align="center">操作</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
						        <?php foreach($list as $k=>$v) {?>
									<td>
										<?php echo($v->mobileNo);?>
									</td>
									<td>
										<?php echo($v->author);?>
									</td>
									<td>
									<div align="center"><?php echo($v->time);?></div>
									</td>
									<td>
										<div align="center">
											<a href="javascript:void(0)" onClick="Delete(<?php echo($v->id);?>)">删除</a>
										</div>
									</td>
									
								</tr>
								<?php }?>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="5">
										<div class="bulk-actions align-left">
											总数：<?php echo $count;?>
										</div>
										<div class="pagination">
											页数 <?php echo $pages;?>
										</div>
										<div class="clear">
										</div>
									</td>
								</tr>
							</tfoot>
							<!--<tfoot>
								<tr>
									<td colspan="5">
										<div class="bulk-actions align-left">
											<input class="button" type="button" value="添加新类型" onClick="location.href='<?php echo site_url('sms/types/addtype'); ?>'" />
										</div>
									</td>
								</tr>
							</tfoot>-->
						</table>
					</div>
				</div>
			</form>
			<!-- End .content-box-content -->
		</div>

<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
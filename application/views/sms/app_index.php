<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(app_id) {
	var answer = confirm("您确定要删除该 短信应用 吗?")
	if (answer){
	 window.location.href="<?php echo site_url("sms/app_index/delete"); ?>"+"/"+app_id; 
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
							短信应用名称：
							<input class="text-input small-input" type="text" id="small-input" title="输入短信应用名称的关键字即可" name="app_name" value="<?php echo $this->input->get("app_name");?>" />
							<input class="button" type="submit" value="模糊搜索" />
						</p>
						<table class='table1' style="width: 840px;">
							<thead>
								<tr>
									<th width='5%'>
										ID
									</th>
									<th  width='20%'>
										名称
									</th>
									<th  width='20%'>
										Key
									</th>
									<th  width='5%'>
										状态
									</th>	
									<th  width='10%'>
										<div align="center">操作</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $list as $k => $value ){ ?>
								<tr>
									<td>
										<?php echo $value->app_id;?>
									</td>
									<td>
										<?php echo $value->app_name;?>
									</td>
									<td>
										<?php echo $value->app_key;?>
									</td>
									<td>
									<div align="center"><?php 
									   echo $smsapp->get_status($value->app_status);
										?></div>
									</td>
									<td>
										<div align="center"><a href="<?php echo site_url("sms/app_add/edit/".$value->app_id);?>">编辑</a>
										| 
										<span class='pmenu'  >
											操作
											<ul class='ulmenu'>
												<?php foreach ($smsapp->get_action_status($value->app_status) as $key => $value2) { ?>
													<li style="background: none;padding:1px 5px;"><a class="button"  href="<?php echo site_url("sms/app_index/set/".$value->app_id.'/'.$key);?>"><?php echo $value2; ?></a></li>
												<?php } ?>
												    <li style="background: none;padding:1px 5px;"><a class="button" href="javascript:;" onClick="return Delete(<?echo $value->app_id; ?>)" >删除</a></li>
											</ul>
										</span>
										</div>
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
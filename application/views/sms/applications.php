<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(app_id) {
	var answer = confirm("及其不推荐这么做！\n确实要删除该应用吗？这样会删除其下所有秘钥！")
	if (answer){
	    window.location.href="<?php echo(site_url('sms/applications/dodelapp'));?>/"+app_id; 
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
							　所有应用
							<!--<input class="text-input small-input" type="text" id="small-input" title="输入短信应用名称的关键字即可" name="app_name" value="<?php echo $this->input->get("app_name");?>" />
							<input class="button" type="submit" value="模糊搜索" />-->
						</p>
						<table class='table1' style="width: 840px;">
							<thead>
								<tr>
									<th width='20%'>
										appID
									</th>
									<th width='30%'>
										名称
									</th>
									<th  width='15%'>
										作者
									</th>
									<th width='20%'>
                                                                                                                         时间
									</th>
									<th  width='15%'>
										<div align="center">操作</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
						        <?php foreach($apps as $k=>$v) {?>
									<td>
										<?php echo($v->appId);?>
									</td>
									<td>
										<?php echo($v->name);?>
									</td>
									<td>
										<?php echo($v->author);?>
									</td>
									<td>
									<div align="center"><?php echo($v->time);?></div>
									</td>
									<td>
										<div align="center"><a href="<?php echo site_url("sms/applications/keys/".$v->appId);?>">所属秘钥</a>
										| 
										<span class='pmenu'  >
											操作
											<ul class='ulmenu'>
												    <li style="background: none;padding:1px 5px;"><a class="button" href="javascript:;" onClick="return Delete(<?php echo($v->id); ?>)" >删除</a></li>
											</ul>
										</span>
										</div>
									</td>
									
								</tr>
								<?php }?>
							</tbody>
							<!--<tfoot>
								<tr>
									<td colspan="5">
										<div class="bulk-actions align-left">
											总数：
										</div>
										<div class="pagination">
											页数
										</div>
										<div class="clear">
										</div>
									</td>
								</tr>
							</tfoot>-->
							<tfoot>
								<tr>
									<td colspan="5">
										<div class="bulk-actions align-left">
											<input class="button" type="button" value="添加新应用" onClick="location.href='<?php echo site_url('sms/applications/addapp'); ?>'" />
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
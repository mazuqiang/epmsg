<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(id) {
	var answer = confirm("警告！极其不推荐这么做！\n每一个模板都是经过备案的，最好不要删除其中任何一个！！！\n如果你确信一定要删除该模板的话，请点确定。")
	if (answer){
	    window.location.href="<?php echo(site_url('sms/module/dodel'));?>/"+id; 
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
							　短信模板列表 <font color='red'>注 : 因为每个短信模板都是经过备案的  , 所以不提供编辑功能 !</font>
							<!--<input class="text-input small-input" type="text" id="small-input" title="输入短信应用名称的关键字即可" name="app_name" value="<?php echo $this->input->get("app_name");?>" />-->
							<input class="button" onClick="location.href='<?php echo(site_url('sms/module/add'));?>'" type="button" value="添加新模板" />
						</p>
						<table class='table1' style="width: 840px;">
							<thead>
								<tr>
									<th width='10%'>
										id
									</th>
									<th width='80%'>
										内容
									</th>
									<th  width='10%'>
										<div align="center">操作</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
						        <?php foreach($list as $k=>$v) {?>
						        	<td>
										<?php echo($v->id);?>
									</td>
									<td>
										<?php echo($v->cnt);?>
									</td>
									<td>
										<a href='javascript:void(0)' onClick="Delete(<?php echo($v->id);?>)">删除</a>
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
						</table>
					</div>
				</div>
			</form>
			<!-- End .content-box-content -->
		</div>

<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(op_id) {
	var answer = confirm("您确定要删除该 游戏区 吗?")
	if (answer){
	 window.location.href="<?php echo site_url("sms/op_index/delete"); ?>"+"/"+op_id; 
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
		<div class="content-box" style="width: 1270px;">
			<!-- End .content-box-header -->
			<form method="get" name="form1">
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1" style="width: 1240px;">
						<!-- This is the target div. id must match the href of this div's tab
						-->
						<p>
							运营商列表：
							<!--<input class="text-input small-input" type="text" id="small-input" title="输入运营商名称的关键字即可" name="op_name" value="<?php echo $this->input->get("op_name");?>" />
							<input class="button" type="submit" value="模糊搜索" />-->
						</p>
						<table class='table1' style="width: 1240px;">
							<thead>
								<tr>
									<th width='15%'>
										ID
									</th>
									<th  width='15%'>
										接口缩写
									</th>
									<th width='50%'>
										运营商简介
									</th>
									<th>
										添加时间
									</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach( $list as $k => $value ){ ?>
								<tr>
									<td>
										<?php echo $value['id'];?>
									</td>
									<td>
										<?php echo $value['name'];?>
									</td>
									<td>
										<?php echo $value['desc'];?>
									</td>
									<td>
										<?php echo $value['time'];?>
									</td>									
								</tr>
								<?php } ?>
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
						</table>
					</div>
				</div>
			</form>
			<!-- End .content-box-content -->
		</div>

<?php $this->load->view(CURRENT_RS_STYLE."_common/footer.php"); ?>
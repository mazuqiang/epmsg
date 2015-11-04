<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(passport_id) {
	var answer = confirm("强烈不建议这么做!\n确定要删除该秘钥吗?")
	if (answer){
	    window.location.href="<?php echo(site_url('sms/applications/dodelkey'));?>/"+passport_id; 
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
		<div class="content-box" style="width: 1070px;">
			<!-- End .content-box-header -->
			<form method="get" name="form1">
				<div class="content-box-content">
					<div class="tab-content default-tab" id="tab1" style="width: 1040px;">
						<!-- This is the target div. id must match the href of this div's tab
						-->
						<p>
							　应用 <?php echo($appId);?> 下面的所有秘钥，如果您想返回应用列表
							<input class="button" type="button" onClick="location.href='<?php echo site_url("sms/applications/"); ?>'" value="请点这里" />
							<!--<input class="text-input small-input" type="text" id="small-input" title="输入短信应用名称的关键字即可" name="app_name" value="<?php echo $this->input->get("app_name");?>" />
							<input class="button" type="submit" value="模糊搜索" />-->
						</p>
						<table class='table1' style="width: 1040px;">
							<thead>
								<tr>
									<th width='20%'>
										秘钥
									</th>
									<th width='10%'>
										描述
									</th>
									<th  width='10%'>
										每天限发(条)
									</th>
									<th width='10%'>
                                        发信间隔(秒)
									</th>
									<th  width='10%'>
										验证码过期间隔(秒)
									</th>
									<th  width='10%'>
										所允许IP
									</th>
									<th width='10%'>
										接口提供商
									</th>
								    <th>
								    	操作
								    </th>
								</tr>
							</thead>
							<tbody>
								<tr>
						        <?php foreach($keys as $k=>$v) {?>
									<td>
										<?php echo($v->key);?>
									</td>
									<td title="<?php echo($v->desc);?>">
										<?php echo(mb_substr($v->desc, 0, 5));?>
									</td>
									<td>
										<?php echo($v->sentsperday);?>
									</td>
									<td>
										<?php echo($v->ablesendperseconds);?>
									</td>
									<td>
									    <?php echo($v->expire);?>
									</td>
									<td>
										<?php echo(trim($v->allow_ips) === '' ? '不限' : $v->allow_ips);?>
									</td>
									<td>
										<?php echo($v->interface_desc);?>
									</td>
									<td>
										<a href='<?php echo(site_url('sms/applications/editkey').'/'.$v->id);?>'>编辑</a> | <a href='javascript:void(0)' onClick='Delete(<?php echo($v->id);?>)'>删除</a>
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
											<input class="button" type="button" value="为应用 <?php echo($appId);?> 添加秘钥" onClick="location.href='<?php echo site_url('sms/applications/addkey').'/'.$appId; ?>'" />
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
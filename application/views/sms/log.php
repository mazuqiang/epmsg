<?php $this->load->view(CURRENT_RS_STYLE."_common/header.php"); ?>
<!-- End of Header -->
<div id="body-wrapper">
	<!-- Wrapper for the radial gradient background -->
	<?php $this->load->view(CURRENT_RS_STYLE."_common/left_menu.php"); ?>
	<!-- End #sidebar -->
	<script type="text/javascript">
	function Delete(app_id) {
	var answer = confirm("你确实要删除该应用吗？\n这样会删除其下所有秘钥！\n请注意该操作的安全性！")
	if (answer){
	    //window.location.href=""+"/"+app_id; 
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
						<p style='line-height: 40px;'>
							　短信日志<br />
							　<input class="text-input" type="text" id="small-input" title="输入手机号码搜索" style='width: 120px' name="mobileNo" value="<?php echo $this->input->get("mobileNo");?>" />
							<input class="button" type="submit" value="按手机号搜索" />
							　<input class="text-input" type="text" id="small-input" title="输入手机号码搜索" style='width: 120px' name="content" value="<?php echo $this->input->get("content");?>" />
							<input class="button" type="submit" value="搜索验证码" />
							　<select name='interface_id' onchange="form1.submit();"><option value=''>所有接口</option><?php foreach($interfaces as $k => $v) echo('<option value="'.$k.'" '.(intval(trim($this->input->get('interface_id'))) === intval(trim($k)) ? 'selected':'').'>'.$v.'</option>'); ?></select>
							　<select name='status' onchange="form1.submit();"><option value=''>所有状态</option><option <?php if(intval(trim($this->input->get("status"))) === 1) echo('selected');?> value='1'>成功</option><option <?php if(intval(trim($this->input->get("status"))) === 2) echo('selected');?> value='2'>失败</option></select>
							　<select name='appId' onchange="form1.submit();"><option value=''>所有应用</option><?php foreach($apps as $k=>$v) echo('<option value="'.$v->appId.'" '.(intval(trim($this->input->get('appId')))===intval(trim($v->appId))?'selected':'').'>'.$v->name.'</option>'); ?></select>
							　<select name='type' onchange="form1.submit();"><option value=''>所有类型</option><?php foreach($types as $k=>$v) echo('<option value="'.$v->name.'" '.(trim($this->input->get('type'))===trim($v->name)?'selected':'').'>'.$v->name.'</option>'); ?></select><br />
							　开始时间：<input class="text-input" style="width:90px;" type="text" name="start_time" id="start_time" value="<?php echo $this->input->get("start_time");?>" />
							结束时间：<input class="text-input" style="width:90px;" type="text"  name="end_time" id="end_time" value="<?php echo $this->input->get("end_time");?>" />
							<input class="button" type="submit" value="按时间搜索" />
						</p>
						<table class='table1' style="width: 1240px;">
							<thead>
								<tr>
									<th width='10%'>
										appID / <br />
										passportID
									</th>
									<th width='15%'>
										接口描述
									</th>
									<th  width='15%'>
										手机号码
									</th>
									<th width='20%'>
                                                                                                                         短信模板ID(非验证码) /<br />内容
									</th>
									<th  width='5%'>
										应用<br />类型
									</th>
									<th  width='5%'>
										短信<br />类型
									</th>
									<th  width='15%'>
										是否发送成功 / <br />短信商返回码
									</th>
									<th >
										验证码生成时间 / <br />
										短信发送时间
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
						        <?php foreach($list as $k=>$v) {?>
									<td>
										<?php echo($v->appId);?> / <br /><?php echo($v->passport_id);?>
									</td>
									<td>
										<?php
            							if(isset($pi[intval(trim($v->passport_id))])) {
											$tid = $pi[intval(trim($v->passport_id))];
											echo($interfaces[$tid]);
										} else {
											echo('<font color="#ff0000">未绑定短信接口！</font>');
										}
										?>
									</td>
									<td>
										<?php echo($v->mobileNo);?>
									</td>
									<td>
										<?php if(intval(trim($v->tpid))!==0)echo($v->tpid.' / ');?><?php echo($v->content);?>
									</td>
									<td>
										<?php echo($v->type); ?>
									</td>
									<td>
										<?php if(intval(trim($v->is_validate))===1)echo('验证码'); else echo('短消息');?>
									</td>
									<td>
										<?php if(intval(trim($v->status))===1)echo('发送成功'); else echo('发送失败');?> / <br />
										<?php echo($v->retmessage); ?>
									</td>
									<td>
										<?php if(trim($v->generate_time) === '0000-00-00 00:00:00') echo('---'); else echo($v->generate_time); ?> / <br />
										<?php echo($v->time); ?>
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
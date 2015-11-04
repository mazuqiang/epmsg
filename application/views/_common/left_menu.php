	<div id="sidebar">
		<div id="sidebar-wrapper">
			<!-- Sidebar with logo and menu -->
			<div class="k_tit">
				快捷菜单
			</div>
			<ul id="main-nav">
				<?php 
					foreach($admin_permissions_left as $key1=>$menu1){
						if($key1==$current_first_level || $current_first_level==0){
							foreach($menu1['sub2'] as $key2=>$menu2){
				?>
				<li>
					<a href='#' class="nav-top-item <?php if($key2 == $current_second_level){?>current no-submenu<?php }else{?>no-submenu<?php }?>">
						<?php echo $menu2['caption'];?>
					</a>   
					<ul>
						<?php foreach($menu2['sub3'] as $key3=>$menu3){ ?>
						<li><a <?php if($key3==$current_third_level){?>class="current"<?php }?> href="<?php echo site_url($menu3['url']) ;?>"><?php echo $menu3['caption'];?></a></li>
						<?php }?>
					</ul>						
				</li>
				<?php } } }?>
			</ul>
			<!-- End #main-nav -->
		</div>
	</div>
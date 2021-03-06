<div class="sidebar">

	<div class="detail-profile">
		<img src="<?php img($Idea->image, $Idea->default_image())?>" alt="<?php echo $Idea->title?>" width="180" height="135"/>
		<p><?php echo $Idea->title?></p>
		<p>金额：<span class="price"><?php output_money($Idea->budget)?>万元</span></p>
		<?php if(!empty($Idea->cat_name)){?>
		<p>类别：<?php echo $Idea->cat_name?> <?php echo $Idea->subcat_name?></p>
		<?php }?>
		<p>发布时间：<?php echo get_date($Idea->time)?></p>
		<p>最后修改时间：<?php echo get_date($Idea->lastmodify)?></p>
		<?php if(isset($Idea->deadline)){?>
		<p><?php output_deadline($Idea->deadline)?></p>
		<?php }?>
		<?php if($Idea->one){?>
		<p>一等奖：<?php echo $Idea->one?>人 <span class="price"><?php output_money($Idea->one_m)?>万元</span></p>
		<?php }?>
		<?php if($Idea->two){?>
		<p>二等奖：<?php echo $Idea->two?>人 <span class="price"><?php output_money($Idea->two_m)?>万元</span></p>
		<?php }?>
		<?php if($Idea->three){?>
		<p>三等奖：<?php echo $Idea->three?>人 <span class="price"><?php output_money($Idea->three_m)?>万元</span></p>
		<?php }?>
	</div><!--end for detail-profile-->
	
	<div class="side-section">
		<div class="title">发起者</div>
		<div class="content">
			<p><a target="_blank" href="<?php echo COMPANY_HOME.'/profile?id='.$Company->id?>">
				<?php output_username($Idea)?></a></p>
		</div>
		
	</div><!--end for tag-->
	
	<div class="side-section">
		<div class="title">领域标签</div>
		<div class="content">
			<?php foreach($tags as $tag){?>
			<span class="item"><?php echo $tag->name?></span>
			<?php }?>
		</div>
	</div>
	
	<?php if(is_company_object($User, $Idea) || $solver){?>
	<div class="side-section">
		<div class="title">操作</div>
		<div class="content">
		<?php if($Idea->status == 0){?>
			<a href="javascript:void(0)" class="idea_finish">结束提交</a>
		<?php }?>
		<?php if($Idea->status == 1){?>
			<a href="javascript:void(0)" class="idea_done">结束评奖</a>
		<?php }?>
		<?php if($solver){?>
		<a href="<?php echo $home.'/score?id='.$Idea->id?>">评分</a>
		<?php }?>
		</div>
	</div>
	<?php }?>
	
	
</div><!--end for sidebar-->

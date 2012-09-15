<?php include('sidebar.php')?>

<div class="main-content">
	<div class="section">
		<h3>项目状态
			<?php if(is_expert($User) && $Problem->status <= 1){?>
			<a href="<?php echo $home.'/submit?id='.$Problem->id?>" class="join-btn btn">我要竞标</a>
			<?php }?>
			<?php if(is_company($User) && $User->id == $Problem->company && $Problem->status == 0){?>
			<a href="<?php echo $home.'/edit?id='.$Problem->id?>" class="edit">编辑</a>
			<?php }?>
		</h3>
		<div class="content status clearfix">
			<div class="status-item <?php $HTML->current($Problem->status, 0)?>">发布蓝图</div>
			<div class="status-item <?php $HTML->current($Problem->status, 1)?>">竞标中</div>
			<div class="status-item <?php $HTML->current($Problem->status, 2)?>">选定合作专家</div>
			<div class="status-item last  <?php $HTML->current($Problem->status, 3)?>">交付互评</div>
		</div>
	</div><!--end for section-->
	
	<?php 
		if(isset($Solver)){
			$expert = $experts[$Solver->expert];
	?>
	<div class="section">
		<h3>中标专家
			<?php if($Problem->status >= 2){
					if(is_company_object($User, $Problem)){
			?>
			<a href="<?php echo $home.'/score?id='.$Problem->id?>" class="edit">给中标专家评分</a>
			<?php 	}else if(is_expert_object($User, $Solver)){?>
			<a href="<?php echo $home.'/score?id='.$Problem->id?>" class="edit">给发布难题企业评分</a>
			<?php }
				}?>
		</h3>
		<div class="content line-list">
			<div class="item clearfix">
				<div class="pic">
					<a target="_blank" href="<?php echo EXPERT_HOME.'/profile?id='.$expert->id?>">
					<img src="<?php img($expert->image)?>" alt="<?php echo $expert->name?>"
						 width="100" height="100"/>
					</a>
					<span class="name">
						<a target="_blank" href="<?php echo EXPERT_HOME.'/profile?id='.$expert->id?>">
						<?php echo $expert->name?>
						</a>
					</span>
				</div>
				<div class="des">
					<a href="<?php echo $home."/item?problem=$Problem->id&item=$Solver->id"?>">
					<?php echo $Solver->title?>
					</a>
					<?php echo $Solver->description?>
				</div>
			</div><!--end for item-->
		</div><!--end for list-->
	</div><!--end for section-->
	<?php }?>

	<div class="section">
		<h3>竞标专家（<?php echo count($solutions)?>）</h3>
		<div class="content line-list">
			<?php 
				foreach($solutions as $solution){
					$expert = $experts[$solution->expert];
			?>
			<div class="item clearfix">
				<div class="pic">
					<a target="_blank" href="<?php echo EXPERT_HOME.'/profile?id='.$expert->id?>">
					<img src="<?php img($expert->image)?>" alt="<?php echo $expert->name?>"
						 width="100" height="100"/>
					</a>
					<span class="name">
						<a target="_blank" href="<?php echo EXPERT_HOME.'/profile?id='.$expert->id?>">
						<?php echo $expert->name?>
						</a>
					</span>
				</div>
				<div class="des">
					<?php if(is_expert_object($User, $solution)){?>
					<a href="<?php echo $home."/item?problem=$Problem->id&item=$solution->id"?>">
					<?php echo $solution->title?>
					</a>
					<?php 
						}else{
							echo $solution->title;
						}
					?>
					
					<?php echo $solution->description?>
				</div>
			</div><!--end for item-->
			<?php }?>
		</div><!--end for list-->
	</div><!--end for section-->
	
	<div class="section">
		<h3>难题介绍</h3>
		<div class="content">
			<?php echo $Problem->description?>
		</div>
		<div class="content">
			<?php if($Problem->file){?>
			附件：<a target="_blank" href="<?php echo UPLOAD_HOME."/$Problem->file"?>">点击下载</a>
			<?php }?>
		</div>
	</div>
	
	<?php comment_div($comments, $links, $Problem, BelongType::PROBLEM, $User)?>
	
</div><!--end for main-content-->

<?php comment_js()?>
<?php 
	if($error){
		output_error($error, $home);
	}
	else{
		output_edit_succ();
?>
<h2>用户中心</h2>
<form action="<?php echo $home.'/edit?id='.$expert->id?>" method="post" <?php $HTML->file_form_need()?>>
	<div class="edit-left">
	
<div class="row">
	<label for="name">姓名</label>
	<input size="50" type="text" class="text" name="name" value="<?php echo $expert->name?>" />
	<span class="error"><?php echo $errors['name']?></span>
</div>
<div class="row">
	<label for="name">邮箱</label>
	<input size="50" type="text" class="text"  name="email" value="<?php echo $expert->email?>" />
	<span class="error"><?php echo $errors['email']?></span>
</div>
<div class="row">
	<label for="name">电话</label>
	<input size="50" type="text" class="text"  name="phone" value="<?php echo $expert->phone?>" />
	<span class="error"><?php echo $errors['phone']?></span>
</div>
<div class="row">
	<label for="name">手机</label>
	<input size="50" type="text" class="text"  name="mobile" value="<?php echo $expert->mobile?>" />
	<span class="error"><?php echo $errors['mobile']?></span>
</div>
<div class="row">
	<label for="name">网址</label>
	<input size="50" type="text" class="text"  name="url" value="<?php echo $expert->url?>" />
	<span class="error"><?php echo $errors['url']?></span>
</div>
<div class="row">
	<label for="name">职业</label>
	<input size="50" type="text" class="text"  name="job" value="<?php echo $expert->job?>" />
	<span class="error"><?php echo $errors['job']?></span>
</div>
<div class="row">
	<label for="name">工作单位</label>
	<input size="50" type="text" class="text"  name="workplace" value="<?php echo $expert->workplace?>" />
	<span class="error"><?php echo $errors['workplace']?></span>
</div>
<div class="row">
	<label for="tag">领域标签</label>
	<input size="20" type="text" class="text"  value="" id="new-tag" /> 
	<a href="javascript:;" id="add-tag">添加</a>
</div>	

<div class="tag row">
	<label for="">标签</label>
	<?php 
	if(is_array($tag_list)){
		foreach($tag_list as $tag){
	?>
		<a href="javascript:;" class="old" count="<?php $tag->count?>" tagid="<?php echo $tag->id?>" id="tag_<?php echo $tag->id?>"><?php echo $tag->name?><img src="<?php echo IMAGE_HOME?>/delete.png"></a>	
	<?php 
		}
	}
	?>
	<input type="hidden" name="new_tag" />
	<input type="hidden" name="old_tag" />
</div>
<div class="hot-tag row">
	<label for="">热门标签</label>
	<?php 
	if(is_array($most_common_tags)){
		foreach($most_common_tags as $tag){
	?>
		<a href="javascript:;" count="<?php echo $tag['count']?>" tagid="<?php echo $tag['id']?>" id="tag_<?php echo $tag['id']?>"><?php echo $tag['name']?></a>	
	<?php 
		}
	}
	?>
</div>
	

</div>	<!--end for edit-left-->
<div class="edit-right">

<div class="row">
	<?php if($expert->image){?>
	<label for="">修改头像</label>
	<?php }else{?>
	<label for="">上传头像</label>
	<?php }?>
	<input type="file" name="image" />
	<?php if($expert->image){?>
	<img width="200" height="150" src="<?php img($expert->image)?>" />
	<?php }?>
</div>
</div>	<!--end for edit-right-->
<div class="row">
	<label for="name">自我介绍</label>
	<textarea name="description" rows="3" cols="80"><?php echo $expert->description?></textarea>
	<span class="error"><?php echo $errors['description']?></span>
</div>
<div class="row">
	<input type="submit" value="保存"  class="btn fl" />
	<a href="<?php echo $home.'/myself'?>" class="back-btn">返回</a>
	<?php echo $HTML->hidden('id', $expert->id)?>
</div>
</form>

<script type="text/javascript">
$(document).ready(function($){
	tagEventInit();
});	
</script>
<?php 
	}
?>
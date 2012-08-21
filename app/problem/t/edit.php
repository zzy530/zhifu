<?php 
	if($error){
		output_error($error);
	}
	else{
		output_edit_succ();
?>

<form action="<?php echo $home.'/edit?id='.$problem->id?>" method="post" <?php $HTML->file_form_need()?> >
	
<div class="row">
	<label for="name">难题名称</label>
	<input size="100" type="text" name="title" value="<?php echo $problem->title?>" />
	<span class="error"><?php echo $errors['title']?></span>
</div>	
<div class="row">
	<label for="cat">所属行业</label>
	<select name="cat">
		<option value="-1">选择行业</option>
	</select>
	<span class="error"><?php echo $errors['cat']?></span>
	<select name="subcat">
		<option value="-1">选择行业</option>
	</select>
	<span class="error"><?php echo $errors['subcat']?></span>
</div>

<div class="row">
	<label for="">地区</label>
	<div class="province_city"></div>
</div>	


<div class="row">
	<label for="budget">预算</label>
	<input size="20" type="text" name="budget" value="<?php echo $problem->budget?>" />万元
	<span class="error"><?php echo $errors['budget']?></span>
</div>


<div class="row">
	<label for="deadline">截止日期</label>
	<input size="20" type="text" name="deadline" class="datepicker" value="<?php echo get_date($problem->deadline)?>" readonly="readonly" />
	<span class="error"><?php echo $errors['deadline']?></span>
</div>

<div class="row">
	<label for="tag">领域标签</label>
	<input size="20" type="text" value="" id="new-tag" /> <a href="javascript:;" id="add-tag">添加</a>
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
	<input type="hidden" name="new_tag" />
	<input type="hidden" name="old_tag" />
</div>



<div class="row">
	<label for="">详细描述</label><br/><br/>
	<textarea class="ckeditor" name="description" rows="10" cols="80"><?php echo $problem->description?></textarea>
	<span class="error"><?php echo $errors['description']?></span>
</div>

<?php if($problem->image){?>
<div class="row">
	<label for="">图像</label>
	<img alt="" src="<?php img($problem->image)?>">
</div>
<?php }?>

<div class="row">
	<label for="">修改图像</label>
	<input type="file" name="image" />
	<span class="error"><?php echo $errors['image']?></span>
</div>

<div class="row">
	<label for="">附件</label>
	<?php if($problem->file){?>
	<a target="_blank" href="<?php echo UPLOAD_HOME."/$problem->file"?>">点击下载</a>
	<?php }else{?>
	还没有附件
	<?php }?>
</div>
<div class="row">
	<label for="">修改附件</label>
	<input type="file" name="file" />
	<span class="error"><?php echo $errors['file']?></span>
</div>


<div class="row">
	<input type="submit" value="修改" />
	<a href="<?php echo $home.'/detail?id='.$problem->id?>">返回</a>
	<?php echo $HTML->hidden('id', $problem->id)?>
</div>

</form>

<div>
	<input type="hidden" name="cat" value="<?php echo $problem->cat?>" />
	<input type="hidden" name="subcat" value="<?php echo $problem->subcat?>" />
	<input type="hidden" name="province" value="<?php echo $problem->province?>" />
	<input type="hidden" name="city" value="<?php echo $problem->city?>" />
	<input type="hidden" name="district" value="<?php echo $problem->district?>" />
</div>

<script type="text/javascript">
<!--
var catList = {<?php 
	$l = array();
	foreach($cat_array as $id => $cat){
		$c = array();
		foreach($cat['c'] as $iid => $subcat){
			$n = $subcat['name'];
			$c[] = "{'id':$iid, 'name':'$n'}";
		}
		$l[] = sprintf("\n%d:{'id':%d, 'n':'%s', 'c':[%s]}", 
						$id, $id, $cat['name'], join(',', $c));
	}
	echo join(',', $l)."\n";
?>
};

//-->
</script>


<script type="text/javascript">
$(document).ready(function($){
	
	dateEventInit();
	provinceEventInit();	
	tagEventInit();
	catEventInit();
	
	
});	
</script>

<?php 
	}
?>


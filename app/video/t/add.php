<h2>发布视频</h2>

<form action="" method="post">

<div class="row">
	<label for="">标题</label>
	<input class="text wide" type="text" name="title" value="<?php echo $video->title?>" />
	<span class="error"><?php echo $errors['title']?></span>
	
</div>
<div class="row">
	<label for="">网址</label>
	<input class="text wide"  type="text" name="url" value="<?php echo $video->url?>" />
	<span class="error"><?php echo $errors['url']?></span>
</div>


<div class="row">
	<input type="submit" class="btn fl" value="添加" />
	<a href="<?php echo $home?>" class="back-btn">返回</a>
</div>


</form>
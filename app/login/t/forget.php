<form action="" method="post" >
<div class="row">
	<label for="">登录名</label>
	<input class="text" type="text" name="user" value="<?php echo $user?>" />
	<span class="error"><?php echo $errors['user']?></span>
</div>
<div class="row">
	<label for="">验证码</label>
	<input class="text" type="text" name="captcha" />
	<img alt="验证码" src="<?php echo ROOT_URL.'/captcha'?>">
	<span class="error"><?php echo $errors['captcha']?></span>
</div>
<div class="row">
	<input type="submit" value="发送邮件" />
	<a href="<?php echo $home?>">返回</a>
</div>
</form>
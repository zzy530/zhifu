<?php

function get_user_id($user){
	return $user->id;
}

function get_user_type($user){
	$array = array('Company', 'Expert', 'Admin');
	foreach($array as $type){
		if(is_a($user, $type)){
			return $type;
		}
	}
}

function img($image, $default = ''){
	if(StringUtils::start_with($image, 'http')){
		echo $image;
	}
	else if(!empty($image) && file_exists(UPLOAD_DIR.'/'.$image)){
		echo UPLOAD_HOME.'/'.$image;
	}
	else{
		echo $default;
	}
}

function download($file){
	echo UPLOAD_HOME.'/'.$file;
}

function output_error($error, $home = ''){
	echo '<p>'.$error.'</p>';
	if($home){
		echo '<a href="'.$home.'">返回</a>';
	}
}

function output_page_list($page_list, $anchor_id = ''){
	if(count($page_list) <= 3){
		return;
	}
	if($anchor_id == ''){
		$anchor = '';
	}
	else{
		$anchor = '#'.$anchor_id;
	}
	echo '<div class="pagenavi">'."\n";
	foreach($page_list as $page){
		list($show, $p, $link, $now) = $page;
		$link = $link.$anchor;
		if($show == '<'){
			echo '<a class="page-prev page-prev-abled" href="'.$link.'" title="'.$show.'"></a>';
		}
		else if($show == '>'){
			echo '<a class="page-next page-next-abled" href="'.$link.'" title="'.$show.'"></a>';
		}
		else if(is_int($show)){
			if($now == 1){
				echo '<span class="current" title="'.$show.'">'.$show.'</span>';
			}
			else {
				echo '<a title="'.$show.'" href="'.$link.'">'.$show.'</a>';
			}
		}
		else if($show == '...'){
			echo '<a>...</a>';
		}
		echo '&nbsp;'."\n";
	}
	echo '</div>'."\n";
	echo '<div id="goodslist2-page" class="pagenavi hidden"></div>'."\n";
}

function output_desc($desc, $length = 100){
	$d = strip_tags($desc);
	echo subString($d, $length);
}

function output_money($money, $zero = 1){
	if($money){
		echo $money;
	}
	else if($zero == 1){
		echo 0;
	}
	else{
		echo '';
	}
}

function output_pcd($o){
	echo "$o->province$o->city$o->district";
}

function output_pcd2($o){
	echo "$o->province2$o->city2$o->district2";
}

function output_district($o){
	echo "$o->dis1 $o->dis2";
}

function output_deadline($datetime){
	if($datetime && $datetime != '0000-00-00'){
		if(!is_expire($datetime)){
			echo '<p>截止日期：<span class="date">'.$datetime.'</span></p>';
		}
		else{
			echo '<p>截止日期：已过期</p>';
		}
	}
	else{
		echo '<p>截止日期：有效</p>';
	}
}

function output_edit_succ($message = ''){
	if($message == ''){
		$message = '修改成功';
	}
	if(isset($_GET['succ'])){
		echo '<div class="success-notice">'.$message.'</div>';
		return 1;
	}
	else{
		return 0;
	}
}

function output_score($o){
	if($o->rate_num == 0){
		echo '未评分';
	}
	else{
		printf('%.1d分', $o->rate_total / $o->rate_num);
	}
}

function output_identity($identity){
	$s = intval($identity);
	if($s == 1){
		echo '领域专家';
	}
	else if($s == 2){
		echo '社会人才';
	}
	else if($s == 3){
		echo '在校学生';
	}
	else if($s == 4){
		echo '不限';
	}
}

function output_degree($degree){
	$s = intval($degree);
	if($s == 1){
		echo '专科';
	}
	else if($s == 2){
		echo '本科';
	}
	else if($s == 3){
		echo '研究生';
	}
	else if($s == 4){
		echo '不限';
	}
}

function output_sex($sex){
	$s = intval($sex);
	if($s == 1){
		echo '男';
	}
	else if($s == 2){
		echo '女';
	}
}

function output_username($o, $type = 1){
	if($type == 1){
		echo $o->username;
	}
	else if($type == 2){
		echo $o->username;
		if($o->author){
			echo '（'.$o->author.'）';
		}
	}
}

function get_user_link($o){
	$type = $o->get_type();
	if($type == BelongType::EXPERT){
		return EXPERT_HOME.'/profile?id='.$o->id;
	}
	else if($type == BelongType::COMPANY){
		return COMPANY_HOME.'/profile?id='.$o->id;
	}
	else{
		return '';
	}
}

function get_author_link($id, $type){
	if($type == BelongType::EXPERT){
		return EXPERT_HOME.'/profile?id='.$id;
	}
	else if($type == BelongType::COMPANY){
		return COMPANY_HOME.'/profile?id='.$id;
	}
	else{
		return '#';
	}
}

function output_author_link($o, $blank = 0){
	output_author_link2($o->id, $o->get_type(), $o->username, $blank);
}

function output_author_link2($id, $type, $username, $blank = 0){
	if($type == BelongType::EXPERT){
		$href = EXPERT_HOME.'/profile?id='.$id;
	}
	else if($type == BelongType::COMPANY){
		$href = COMPANY_HOME.'/profile?id='.$id;
	}
	else{
		echo $username;
		return;
	}
	if($blank == 1){
		$target = 'target="_blank" ';
	}
	echo '<a '.$target.'href="'.$href.'">'.$username.'</a>';
}

function is_expire($datetime, $addend = false){
	if($datetime == '0000-00-00'){
		return false;
	}
	if($addend){
		$datetime .= '23:59:59';
	}
	$ts = strtotime($datetime);
	return $ts < time();
}

function is_company($o){
	if($o && $o->is_company()){
		return true;
	}
	return false;
}

function is_expert($o){
	if($o && is_a($o, 'User') && $o->is_expert()){
		return true;
	}
	return false;
}

function is_admin($o){
	if($o && is_a($o, 'User') && $o->is_admin()){
		return true;
	}
	return false;
}

function is_his_object($u, $o){
	$oid = $o->belong;
	$otype = $o->type;
	if($u && $o){
		if($u->id == $oid && $u->get_type() == $otype){
			return true;
		}
	}
	return false;
}

function is_company_object($u, $o){
	if(isset($o->company)){
		$oid = $o->company;
	}
	else if(isset($o->belong)){
		$oid = $o->belong;
	}
	else{
		return false;
	}
	if($u && $o){
		if($u->id == $oid && $u->get_type() == BelongType::COMPANY){
			return true;
		}
	}
	return false;
}

function is_expert_object($u, $o){
	if(isset($o->expert)){
		$oid = $o->expert;
	}
	else if(isset($o->belong)){
		$oid = $o->belong;
	}
	else{
		return false;
	}
	if($u && $o){
		if($u->id == $oid && $u->get_type() == BelongType::EXPERT){
			return true;
		}
	}
	return false;
}


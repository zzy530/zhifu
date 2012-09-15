<?php

class RecruitController extends AppController {
	
	public $models = array('Recruit', 'Tag', 'TagItem');
	
	public function before(){
		$this->set('home', RECRUIT_HOME);
		parent::before();
		$need_login = array('show', 'add', 'edit');	// either
		$need_company = array();
		$need_expert = array();
		$this->login_check($need_login, $need_company, $need_expert);
	}
	
	public function index(){
		$get = $this->request->get;
		$page = $get['page'];
		$type = $get['type'];
		$fromday = $get['fromday'];
		$cond = array();
		if($type == 'zhaopin'){
			$cond['type'] = BelongType::COMPANY;
		}
		else if($type == 'qiuzhi'){
			$cond['type'] = BelongType::EXPERT;
		}
		if($fromday == '3days'){
			$from_ts = TIMESTAMP - 3600 * 24 * 3;
			$cond['time >='] = date('Y-m-d H:i:s', $from_ts);
		}
		else if($fromday == 'week'){
			$from_ts = TIMESTAMP - 3600 * 24 * 7;
			$cond['time >='] = date('Y-m-d H:i:s', $from_ts);
		}
		$limit = 10;
		$order = array('time'=>'DESC');
		$all = $this->Recruit->count($cond);
		$pager = new Pager($all, $page, $limit);
		$list = $this->Recruit->get_page($cond, $order, $pager->now(), $limit);
		$links = $pager->get_page_links($this->get('home').'/index?');
		$this->set('list', $list);
		$this->set('links', $links);
	}
	
	public function show(){
		$get = $this->request->get;
		$id = get_id($get);
		$has_error = true;
		if($id){
			$recruit = $this->Recruit->get($id);
			if($recruit){
				$has_error = false;
			}
		}
		if($has_error){
			$this->response->redirect_404();
			return;
		}
		
		$recruit->do_available();
		$this->add_tag_data($recruit->id, BelongType::RECRUIT);
		$this->set('$recruit', $recruit);
	}
	
	public function add(){
		if($this->request->post){
			$post = $this->request->post;
			$User = $this->get('User');
			$post['belong'] = $User->id;
			$post['type'] = $User->get_type();
			$post['author'] = $User->name;
			$errors = $this->Recruit->check($post);
			if(count($errors) == 0){
				$old_tag = $post['old_tag'];
				$new_tag = $post['new_tag'];
				unset($post['old_tag'], $post['new_tag']);
				$post['status'] = 1;
				$post['time'] = DATETIME;
				$this->Recruit->escape($post);
				$id = $this->Recruit->save($post);
				$this->do_tag($id, BelongType::RECRUIT, $old_tag, $new_tag);
				$this->redirect('show?id='.$id);
			}
			$this->set('$errors', $errors);
		}
	}
	
	public function edit(){
		$data = $this->get_data();
		$id = get_id($data);
		$User = $this->get('User');
		$has_error = true;
		if($id){
			$recruit = $this->Recruit->get($id);
			if($recruit){
				if($User->id == $recruit->belong 
						&& $User->get_type() == $recruit->type){
					$has_error = false;
				}
			}
		}
		if($has_error){
			$this->response->redirect_404();
			return;
		}
		
		if($this->request->post){
			$post = $this->request->post;
			$User = $this->get('User');
			$recruit = $this->set_model($post, $recruit);
			$errors = $this->Recruit->check($recruit);
			if(count($errors) == 0){
				$old_tag = $post['old_tag'];
				$new_tag = $post['new_tag'];
				unset($post['old_tag'], $post['new_tag']);
				$this->Recruit->escape($post);
				$this->Recruit->save($post);
				$this->do_tag($id, BelongType::RECRUIT, $old_tag, $new_tag);
				$this->redirect('show?id='.$id);
			}
			$this->set('errors', $errors);
		}
		$recruit->do_available();
		$this->add_tag_data($recruit->id, BelongType::RECRUIT);
		$this->set('$recruit', $recruit);
	}
	
	
}
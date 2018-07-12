<?php

class ControllerModuleSmartsupp extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$this->load->language('module/smartsupp');

		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('smartsupp', $this->request->post);		

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$text_strings = array(
			'heading_title',
			'text_enabled',
			'text_disabled',
			'text_content_top',
			'text_content_bottom',
			'text_column_left',
			'text_column_right',
			'entry_layout',
			'entry_limit',
			'entry_image',
			'entry_position',
			'entry_status',
			'entry_sort_order',
			'button_save',
			'button_cancel',
			'button_add_module',
			'button_remove',
			'entry_smartsupp_chat_id'
			);
		
		foreach ($text_strings as $text) {
			$this->data[$text] = $this->language->get($text);
		}

		$config_data = array(
			'smartsupp_chat_id'
			);
		
		foreach ($config_data as $conf) {
			if (isset($this->request->post[$conf])) {
				$this->data[$conf] = $this->request->post[$conf];
			} else {
				$this->data[$conf] = $this->config->get($conf);
			}
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		//SET UP BREADCRUMB TRAIL.
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
			);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
			);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/smartsupp', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
			);
		
		$this->data['action'] = $this->url->link('module/smartsupp', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');


		//This code handles the situation where you have multiple instances of this module, for different layouts.
		$this->data['modules'] = array();
		
		if (isset($this->request->post['smartsupp_module'])) {
			$this->data['modules'] = $this->request->post['smartsupp_module'];
		} elseif ($this->config->get('smartsupp_module')) {
			$this->data['modules'] = $this->config->get('smartsupp_module');
		}		

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		//Choose which template file will be used to display this request.
		$this->template = 'module/smartsupp.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
			);

		//Send the output.
		$this->response->setOutput($this->render());
	}
	
	/*
	 * 
	 * This function is called to ensure that the settings chosen by the admin user are allowed/valid.
	 * You can add checks in here of your own.
	 * 
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/smartsupp')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}


}

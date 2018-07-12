<?php

class ControllerModuleSmartsupp extends Controller {
	protected function index() {

		$this->data['smartsupp_chat_id'] = $this->config->get('smartsupp_chat_id');

		if( isset($this->data['smartsupp_chat_id']) && $this->data['smartsupp_chat_id'] != '' ){
			//Choose which template to display this module with
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/smartsupp.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/module/smartsupp.tpl';
			} else {
				$this->template = 'default/template/module/smartsupp.tpl';
			}

			//Render the page with the chosen template
			$this->render();
		}
	}
}

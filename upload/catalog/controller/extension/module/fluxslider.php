<?php
class ControllerExtensionModuleFluxslider extends Controller {
	public function index($setting) {
		static $module = 0;

		$this->load->model('design/banner');
		$this->load->model('tool/image');
		
		$this->document->addStyle('catalog/view/javascript/fluxslider/flux.css');
		$this->document->addScript('catalog/view/javascript/fluxslider/flux.js');
    $this->document->addScript('catalog/view/javascript/fluxslider/modernizr.js');
    
    $data['autoplay'] = $setting['autoplay'];
    $data['pagination'] = $setting['pagination'];
    $data['controls'] = $setting['controls'];
    $data['captions'] = $setting['captions'];
    $data['delay'] = $setting['delay'];

		$data['banners'] = array();

		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
				);
			}
		}

		$data['module'] = $module++;

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/fluxslider.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/module/fluxslider.tpl', $data);
		} else {
			return $this->load->view('module/fluxslider.tpl', $data);
		}
	}
}
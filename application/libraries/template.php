<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
    class Template
    {
        private $ci;
		private $header = null;
		private $body = null;
		private $search = null;
		private $menu = null;
		
         
        public function __construct()
        {
            $this->ci =& get_instance();
        }
		
		public function setHeader($header_value = '')
		{
			 $this->headerpart = $header_value;
		}
		
		public function setBody($body_value)
		{
			$this->body = $body_value;
		}
		
		
		public function setLeftmenu($menu_value)
		{
			$this->menu = $menu_value;
		}
		
		public function setSearch($search_value)
		{
			$this->search = $search_value;
		}
		
		public function setSiteMap($sitemap_view)
		{
			$this->sitemap = $sitemap_view;
		}
		
		public function view($view_name, $layouts = array(), $param = array(), $default = true)
		{
			 if(is_array($layouts) && count($layouts) >= 1)
			 {
					foreach($layouts as $layouts_key => $layout)
					{
						$param[$layouts_key] = $this->ci->load->view($layout, $param, true);
					}
			 }
			 if($default)
			 {
				$body_param['bodycontent'] =   $this->body;
				$body_param['leftmenu'] =   $this->menu;
				$body_param['header'] =   $this->headerpart;
				
				
			  }
			 $this->ci->load->view($view_name, $body_param);
		}
    }
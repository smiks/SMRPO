<?php

class Controller{
	
	public $_CSRF_TOKEN;


	private function sum($a) {
		return array_sum(str_split($a));
	}

	public function generateCSRF() {
		$ok = false;
		while(!$ok) {
			$num = rand(10000000,90000000);
			if($this->sum($num) % 7 == 0) {
				$ok = true;
				$this->_CSRF_TOKEN = $num;
			}
		}
		return $this -> _CSRF_TOKEN;
	}

	public function checkCSRF($token, $forceStop = false) {
		global $_Domain, $_RefererDomain, $_CSRF;
		$result = $this->sum($token) % 7 == 0 && $_Domain == $_RefererDomain;
		if($_CSRF && !$result && $forceStop) {
			echo"CSRF ERROR";
			exit(1);
		}
		if($_CSRF && !$result && !$forceStop) {
			return false;
		}		
		return true;
	}

	public function show($view, $data = array()){
		$CSRF = $this -> _CSRF_TOKEN;
		$CSRFFORM = "<input type='hidden' name='csrf' value='{$CSRF}'>";
		if(is_array($data)){
			foreach ( $data as $key => $value ) {
				$$key = $value;
			}
		}
	
		// works
		ob_start();
			$file = "app/views/".$view;
			if(file_exists($file)){
				$content = file_get_contents($file);
				$search  = array("{%", "%}", "{{", "}}");
				$replace = array(" <?php ", " ?> ", '<?php echo"{$','}"; ?>'); 
				$content = str_replace($search, $replace, $content);

				$search  = array(
					'@\[(?i)include\](.*?)\[/(?i)include\]@si', 
					'@\@for (.*?) in range\((\w*),(\w*)\)@si', 
					'@\@for (.*?) in range\((\w*)\)@si', 
					'@\@for (.*?) in range\((\w*),(\w*),(.*?)\)@si', 					
					'@\@endfor@si'
					);
				$replace = array(
					"<?php if(file_exists('\\1')){include_once('\\1');} ?>", 
					"<?php for($\\1=\\2; $\\1 < \\3; $\\1++): ?>", 
					"<?php for($\\1=0; $\\1 < \\2; $\\1++): ?>", 
					"<?php for($\\1=\\2; $\\1 < \\3; $\\1 += \\4): ?>",				
					"<? endfor; ?>"
					);

				$content = preg_replace($search, $replace, $content);
				//echo($content);exit();
				$output = eval("?>$content");
			}
			else{
				echo "File [{$file}] not found!";
			}
			$output = ob_get_contents();


		
		ob_end_clean();
	
		// also works
		/*$file = file_get_contents("../app/views/".$view);
			$output = eval("?>$file");*/
	
		echo $output;
	
	}
	
}
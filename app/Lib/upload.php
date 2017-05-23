<?php
class upload_file {
	/**声明**/
	var $upfile_type, $upfile_size, $upfile_name, $upfile;
	var $d_alt, $extention_list, $tmp, $arri;
	var $datetime, $date;
	var $filestr, $size, $ext, $check;
	var $flash_directory, $extention, $file_path, $base_directory;

	function upload_file() {
		/**构造函数**/
		$this->set_extention(); //初始化扩展名列表;
		$this->set_size(50); //初始化上传文件KB限制;
		$this->set_date(); //设置目录名称;
		$this->set_datetime(); //设置文件名称前缀;
		$this->set_base_directory("attachmentFile"); //初始化文件上传根目录名，可修改！;
	}

	/**文件类型**/
	function set_file_type($upfile_type) {
		$this->upfile_type = $upfile_type; //取得文件类型;
	}

	/**获得文件名**/
	function set_file_name($upfile_name) {
		$this->upfile_name = str_replace('@','',$upfile_name);       //取得文件名称;
	}

	/**获得文件**/
	function set_upfile($upfile) {
		$this->upfile = $upfile; //取得文件在服务端储存的临时文件名;
	}

	/**获得文件大小**/
	function set_file_size($upfile_size) {
		$this->upfile_size = $upfile_size; //取得文件尺寸;
	}

	/**获得文件扩展名**/
	function get_extention() {
		$this->extention = preg_replace('/.*\.(.*[^\.].*)*/iU', '\\1', $this->upfile_name); //取得文件扩展名;
	}

	/**设置文件名称**/
	function set_datetime() {
		$this->datetime = date("YmdHis"); //按时间生成文件名;
	}

	/**设置目录名称**/
	function set_date() {
		$this->date = date("Y-m-d"); //按日期生成目录名称;
	}

	/**初始化允许上传文件类型**/
	function set_extention() {
		$this->extention_list = "xls|doc|txt|pdf|gif|png|jpg|jpeg|docx|xlsx|bmp|zip|rar|avi|rmvb|html|htm|mp3|mp4"; //默认允许上传的扩展名称;
	}

	/**设置最大上传KB限制**/
	function set_size($size) {
		$this->size = $size; //设置最大允许上传的文件大小;
	}

	/**初始化文件存储根目录**/
	function set_base_directory($directory) {
		$this->base_directory = $directory; //生成文件存储根目录;
	}

	/**初始化文件存储子目录**/
	function set_flash_directory() {
		$this->flash_directory = $this->base_directory . "/" . $this->date; //生成文件存储子目录;
	}

	/**错误处理**/
	function showerror($errstr) {
		global $lang;
		$errstr = ($errstr == '' ? $lang['unknown_error'] : $errstr);
		echo "<script language=javascript>alert('$errstr');location='javascript:history.go(-1);';</script>";
		exit ();
	}

	/**如果根目录没有创建则创建文件存储目录**/
	function mk_base_dir() {
		//检测根目录是否存在;
		if (!file_exists($this->base_directory)) {
			@ mkdir($this->base_directory, 0777); //不存在则创建;
		}
	}

	/**如果子目录没有创建则创建文件存储目录**/
	function mk_dir() {
		//检测子目录是否存在;
		if (!file_exists($this->flash_directory)) {
			@ mkdir($this->flash_directory, 0777); //不存在则创建;
		}
	}

	/**以数组的形式获得分解后的允许上传的文件类型**/
	function get_compare_extention() {
		$this->ext = explode("|", $this->extention_list); //以"|"来分解默认扩展名;
	}

	/**检测扩展名是否违规**/
	function check_extention() {
		global $lang;
		//遍历数组;
		for ($i = 0; each($this->ext); $i++) {
			//比较文件扩展名是否与默认允许的扩展名相符;
			if ($this->ext[$i] == strtolower($this->extention)) {
				$this->check = true; //相符则标记;
				break;
			}
		}
		if (!$this->check) {
			$this->showerror($lang['correct_extension'] . $this->extention_list . $lang['oneof']);
		}
		//不符则警告
	}

	/**检测文件大小是否超标**/
	function check_size() {
		global $lang;
		if ($this->upfile_size > round($this->size * 1024)) //文件的大小是否超过了默认的尺寸;
			{
			$this->showerror($lang['file_notmorethan'] . $this->size . "KB"); //超过则警告;
		}
	}

	/**文件完整访问路径**/
	function set_file_path() {
		$this->file_path = $this->flash_directory . "/" . $this->datetime . $this->upfile_name; //生成文件完整访问路径;
	}

	/**上传文件**/
	function copy_file() {
		global $lang;
		//上传文件;
		if (copy($this->upfile, $this->file_path)) { 
			$wjpath = $this->flash_directory;
			$att = explode('/', $wjpath);
			$tt = "uploads/" . $att[count($att) - 1];
			$this->file_path = $tt . "/" . $this->datetime . $this->upfile_name; //生成文件完整访问路径;
			return str_replace(' ', '', $this->upfile_name) . '|' . $this->file_path;
		} else {
			$this->showerror($lang['error_tryagain']); //上传失败;
		}
	}

	/**完成保存**/
	function save() {
		$this->set_flash_directory(); //初始化文件上传子目录名;
		$this->get_extention(); //获得文件扩展名;
		$this->get_compare_extention(); //以"|"来分解默认扩展名;
		$this->check_extention(); //检测文件扩展名是否违规;
		$this->check_size(); //检测文件大小是否超限;  
		$this->mk_base_dir(); //如果根目录不存在则创建；
		$this->mk_dir(); //如果子目录不存在则创建;
		$this->set_file_path(); //生成文件完整访问路径;
		return $this->copy_file(); //上传文件;
	}
}
?>
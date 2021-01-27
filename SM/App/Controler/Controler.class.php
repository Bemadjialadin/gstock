<?php 
namespace App\Controler;
use App\Model\Authentification;
/**
 * 
 */
class Controler 
{
	protected $viewsPath;
	
	function __construct()
	{
	}

	public function render($views,$variables=[])
	{
		ob_start();
			extract($variables);
			require ($this->viewsPath.str_replace('.', '/', $views).'.php');
		$contenue = ob_get_clean();
		require ($this->viewsPath.$this->template.'.php');	
	}
	public static function is_int($str){
		$is_obj = (is_integer($str) || is_string($str));
		$val = $is_obj? str_split($str) : str_split('s');
		foreach ($val as $value) {
			if ($value<'0' || $value>'9') {
				return false;
			}
		}
		return true;
	}
}
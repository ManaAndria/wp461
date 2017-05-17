<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AppBook appModule class.
 *
 */
class AppModule
{
	protected $db_name;

	public $app_id = null;

	public $datas = null;

	public function __construct($app_id)
	{
		global $wpdb;
		
		$this->app_id = (int)$app_id;
		$this->db_name = $wpdb->prefix . appBook()->slug . '_module';
		$this->loadDatas();
	}

	public function loadDatas()
	{
		global $wpdb;
		$query = "SELECT * FROM {$this->db_name} WHERE `app_id`={$this->app_id}";
		$this->datas = $wpdb->get_row($query, OBJECT);
	}

	public function generate($folder)
	{
		$prefix = (string)time();
		$folder_name = $folder.$prefix;
		$create_dir = mkdir($_SERVER['DOCUMENT_ROOT'].'/'.$folder_name, 0755);
		$src = $_SERVER['DOCUMENT_ROOT'].'/modele-rdv/rdv.zip';
		$dst = $_SERVER['DOCUMENT_ROOT'].'/'.$folder_name;
		//
		$zip = new ZipArchive;
		if ( $zip->open($src) === true )
		{
			$zip->extractTo($dst);
    		$zip->close();
		}
		else
		{
			rmdir($dst);
			return false;
		}
		//
	    $current_modele = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/modele-rdv/rdv/index.html');
		$current = str_replace('{app_id}', $this->app_id, $current_modele);
		$write = file_put_contents($dst.'/index.html', $current);
		if($write !== false)
			return $folder_name;
		else
			return false;
	}

	public function create($datas)
	{
		global $wpdb;
		
		$fields = array( 
			'app_id' => $this->app_id,
			'folder' => $datas["folder"],
		);
		$format = array(
			'%d', 
			'%s'
		);
		$res = $wpdb->insert( $this->db_name, $fields, $format );
		if ($res)
			$this->loadDatas();

		return $res;
	}

	public static function getFolder($app_id)
	{
		global $wpdb;
		$app_id = (int)$app_id;
		$db_name = $wpdb->prefix.'appbook_module';
		$query = "SELECT folder FROM `{$db_name}` WHERE `app_id`={$app_id}";
		return $wpdb->get_var($query);
	}
	public static function regenerate($app_ids)
	{
		global $wpdb;
		$app = appBook();
		if ($app_ids === 'all')
		{
			$query = "SELECT * FROM `{$wpdb->prefix}appbook_module`";
		}
		else
		{
			$query = "SELECT * FROM `{$wpdb->prefix}appbook_module` WHERE app_id IN ('{$app_ids}')";
		}
		$results = $wpdb->get_results($query, OBJECT);
		$src = $_SERVER['DOCUMENT_ROOT'].'/modele-rdv/rdv.zip';
		foreach ($results as $result) {
			$folder_name = $result->folder;
			$dst = $_SERVER['DOCUMENT_ROOT'].'/'.$folder_name;
			if ( self::recursuveDeleteFolderContent($dst) ){
				// copy
				$zip = new ZipArchive;
				if ( $zip->open($src) === true )
				{
					$zip->extractTo($dst);
		    		$zip->close();
				}
				else
				{
					return false;
				}
				// end copy
			}
		    $current_modele = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/modele-rdv/rdv/index.html');
			$current = str_replace('{app_id}', $result->app_id, $current_modele);
			$write = file_put_contents($dst.'/index.html', $current);
			if($write === false)
				return false;
		}
		return true;
	}

	public static function recursuveDeleteFolderContent($folder)
	{
		$dir_contents = scandir($folder);
		foreach ($dir_contents as $dir_content) {
			if ( $dir_content !== '.' &&  $dir_content !== '..')
			{
				if(is_dir($folder.'/'.$dir_content))
				{
					$ret = self::recursuveDeleteFolderContent($folder.'/'.$dir_content);
					if ( $ret === true )
					{
						rmdir($folder.'/'.$dir_content);
					}
				}
				else
					unlink($folder."/".$dir_content);
			}
		}
		return true;
	}

	public function updateComment($app_id, $module_id, $comment)
	{
		global $wpdb;
		$app_id = (int)$app_id;
		$module_id = (int)$module_id;
		$fields = array('comments' => $comment);
		$format = array('%s');
		$where = array( 'app_id' => $app_id, 'module_id' => $module_id );
		$where_format = array( '%d', '%d' );
		$res = $wpdb->update( $wpdb->prefix.'appbook_module', $fields, $where, $format, $where_format );
		return $res;
	}
}
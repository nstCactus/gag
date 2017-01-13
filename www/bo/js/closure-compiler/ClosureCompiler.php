<?php
// JavaScriptPacker class

class ClosureCompiler
{
	/*
	 * ATTRIBUTES
	 */
	
	// private
	private $_cache;
	private $_filesFromXml;
	private $_files;
	private $_blacklist;
	private $_hash;
	private $_encoding;
	
	// initializer Component
	public function __construct() 
	{
		// valeurs par defaut
		$this->_cache = true;
		$this->_filesFromXml = array();
		$this->_files = array();
		$this->_blacklist = array();
		$this->_encoding = "Normal";
		$this->_hash = '';
	}
	
	/*
	 * PUBLIC METHODS
	 */
	public function setBlacklist($P_blacklist)
	{
		$blacklist = (!is_array($P_blacklist)) ? array($P_blacklist) : $P_blacklist;
		$this->_blacklist = $blacklist;
	}
	
	public function setCache($P_bool)
	{
		$this->_cache = $P_bool;
	}
	
	public function setEncoding($P_encoding)
	{
		// les bons encodages
		$accepted_encoding = array("google","JSMin","", 0, 10, 62, 95, 'None', 'Numeric', 'Normal', 'High ASCII');
		if(in_array($P_encoding,$accepted_encoding))
		{
			$this->_encoding = $P_encoding;
		}
	}
	
	public function display()
	{
		$this->_setDataFromXml();
		
		// recuperer tous les fichiers du ou des dossier(s)
		$this->_generateFiles();
		
		// afficher la source
		return $this->_getJs();
	}
	
	
	/*
	 * PRIVATE METHODS
	 */
	
	private function _setDataFromXml()
	{
		$xml = simplexml_load_file('config.xml');
		// files
		if(isset($xml->files))
		{
			foreach($xml->files->item as $item)
			{
				$name = strval($item);
				if(!empty($name)) array_push($this->_filesFromXml,$name);
			}
		}
		// blacklist
		if(isset($xml->blacklist))
		{
			foreach($xml->blacklist->item as $item)
			{
				$name = strval($item);
				if(!empty($name)) array_push($this->_blacklist,'../'.$name);
			}
		}
		
		// encoding
		if(isset($xml->encoding))
		{
			$encoding = strval($xml->encoding);
			$this->setEncoding($encoding);
		}
		// cache
		if(isset($xml->cache))
		{
			$cache = strval($xml->cache);
			if(!empty($name))
			{
				$cache = ($cache == "true") ? true : false;
				$this->setCache($cache);
			}
		}
	}
	
	private function _getExtention($P_file)
	{
		$ext_search = explode('.',$P_file);
		return strtolower($ext_search[count($ext_search)-1]);
	}
	
	// scanner tous les fichiers
	private function _scanDir($P_dir='..')
	{
		$directory = opendir($P_dir) or die('Erreur');
		while($entry = @readdir($directory))
		{
			$path_entry = $P_dir.'/'.$entry;
			$path_entry = str_replace('//','/',$path_entry);
			if(is_dir($path_entry) && !in_array($path_entry,$this->_blacklist) && $entry != '.' && $entry != '..')
			{
				$this->_scanDir($path_entry);
			}
			elseif($entry != '.' && $entry != '..')
			{
				if($this->_getExtention($entry) == 'js' && !in_array($entry,$this->_filesFromXml) && !in_array($path_entry,$this->_blacklist) && !in_array($path_entry,$this->_files)) array_push($this->_files,$path_entry);
			}
		}
		closedir($directory);
	}
	
	private function _generateFiles()
	{
		// close_compiler to blacklistDir
		array_push($this->_blacklist, basename(dirname(__FILE__)));
		
		// get filesFromXml
		foreach($this->_filesFromXml as $fileFromXml)
		{
			if($fileFromXml == '.')
			{
				$this->_scanDir('..');
			}
			elseif(is_dir('../'.$fileFromXml))
			{
				$this->_scanDir('../'.$fileFromXml);
			}
			else
			{
				array_push($this->_files,'../'.$fileFromXml);
			}
		}
		//$this->_scanDir();
	}
	
	private function _getCurrentHash()
	{
		return @file_get_contents('closure_compiler.hash');
	}
	
	private function _getFileHash()
	{
		$this->_hash = '';
		foreach($this->_files as $file)
		{
			$this->_hash .= filemtime($file);
		}
		$this->_hash .= filemtime('config.xml');
		$this->_hash = md5($this->_hash);
		return $this->_hash;
	}
	
	private function _generateHash()
	{
		file_put_contents('closure_compiler.hash',$this->_hash);
	}
	
	private function _isCache()
	{
		$bool = false;
		if($this->_cache)
		{
			if($this->_getCurrentHash() == $this->_getFileHash())
			{
				$bool = true;
			}
			else
			{
				$this->_generateHash();
			}
		}
		return $bool;
	}
	
	private function _generateSource()
	{
		$output = $this->_getOptimizedSource();
		file_put_contents('closure_compiler.js',$output);
		return $output;
	}
	
	private function _getOptimizedSource()
	{
		$output = '';
		foreach($this->_files as $file)
		{
			$output .= file_get_contents($file).';';
		}
		
		if($this->_encoding != "")
		{
			if($this->_encoding == 'google')
			{
				// GOOGLE COMPILER
				$ch = curl_init('http://closure-compiler.appspot.com/compile');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, 'output_info=compiled_code&output_format=text&compilation_level=SIMPLE_OPTIMIZATIONS&js_code=' . urlencode($output));
				$output = curl_exec($ch);
				curl_close($ch);
			}
			elseif($this->_encoding == 'JSMin')
			{
				require 'JSMin.php';
				$output = JSMin::minify($output);
			}
			else
			{
				require 'JavaScriptPacker.php';
				$packer = new JavaScriptPacker($output, $this->_encoding, true, false);
				$output = $packer->pack();
			}
			
		}
		
		return $output;
	}
	
	private function _getSource()
	{
		return file_get_contents('closure_compiler.js');
	}
	
	private function _getJs()
	{
		if(!$this->_isCache()) 
		{
			//echo '<h1>NON CACHE</h1>';
			return $this->_generateSource();
		}
		else
		{
			return $this->_getSource();
		}
	}
}
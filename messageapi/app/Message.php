<?php

namespace App;

use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model implements SluggableInterface {

	use SoftDeletes;
	use SluggableTrait;

	protected $dates = ['deleted_at'];
    
	protected $guarded  = array('id');

	private $_pass = "EncryptPassworD";
    
	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function title()
	{
		return nl2br($this->title);
	}
    
	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function message()
	{
		return nl2br($this->message);
	}
        
    /**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function password()
	{
		return nl2br($this->password);
	}
        
    /**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function status()
	{
		return nl2br($this->status);
	}
    
    /**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function encrypt($sValue) {
		$sSecretKey = $this->_pass;
	    return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $sSecretKey, $sValue, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
	}
    
    /**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function decrypt($sValue) {
		$sSecretKey = $this->_pass;
	    return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $sSecretKey, base64_decode($sValue), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
	}
	
}

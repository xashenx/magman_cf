<?php

class ShopConf extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'shop_configurations';
	
	protected $guarded = array('id','description');

}
?>
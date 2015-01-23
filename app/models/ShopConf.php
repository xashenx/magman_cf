<?php

class ShopConf extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'bm_shop_configurations';
	
	protected $guarded = array('id','description');

}
?>
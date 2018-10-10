<?php
/**
 * @version            2.3.0
 * @package            Joomla
 * @subpackage         Event Booking
 * @author             Tuan Pham Ngoc
 * @copyright          Copyright (C) 2010 - 2016 Ossolution Team
 * @license            GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die();

/**
 * Stripe payment plugin for Events Booking
 *
 * @author Tuan Pham Ngoc
 *
 */
class austrian_os_stripe extends RADPaymentOmnipay
{

	protected $omnipayPackage = 'Stripe';

	/**
	 * Constructor
	 *
	 * @param JRegistry $params
	 * @param array     $config
	 */
	public function __construct($params, $config = array('type' => 1))
	{
		$config['params_map'] = array(
			'apiKey' => 'stripe_api_key'
		);

		parent::__construct($params, $config);
	}

	/**
	 * Add stripeToken to request message
	 *
	 * @param \Omnipay\Common\Message\AbstractRequest $request
	 * @param JTable                                  $row
	 * @param array                                   $data
	 */
	protected function beforeRequestSend($request, $row, $data)
	{
		parent::beforeRequestSend($request, $row, $data);

		$request->setToken($data['stripeToken']);
	}
}
<?php
/**
 * @version            3.5.3
 * @package            Joomla
 * @subpackage         Event Booking
 * @author             Tuan Pham Ngoc
 * @copyright          Copyright (C) 2010 - 2018 Ossolution Team
 * @license            GNU/GPL, see LICENSE.php
 */

defined('_JEXEC') or die();

/**
 * Stripe payment plugin for Events Booking
 *
 * @author Tuan Pham Ngoc
 *
 */
class os_stripe extends RADPaymentOmnipay
{

	protected $omnipayPackage = 'Stripe';

	/**
	 * Constructor
	 *
	 * @param JRegistry $params
	 * @param array     $config
	 */
	public function __construct($params, $config = array('type' => 0))
	{
		$config['params_map'] = array(
			'apiKey' => 'stripe_api_key'
		);

		$document  = JFactory::getDocument();
		$publicKey = $params->get('stripe_public_key');

		if ($params->get('use_stripe_card_element', 0))
		{
			$document->addScript('https://js.stripe.com/v3/');
			$document->addScriptDeclaration(
				"   var stripe = Stripe('$publicKey');\n
					var elements = stripe.elements();\n
				"
			);

			$config['type'] = 0;
		}
		else
		{
			$document->addScript('https://js.stripe.com/v2/');
			$document->addScriptDeclaration(
				"   var stripePublicKey = '$publicKey';\n
					Stripe.setPublishableKey('$publicKey');\n
				"
			);
		}

		parent::__construct($params, $config);
	}

	/**
	 * Add stripeToken to request message
	 *
	 * @param \Omnipay\Stripe\Message\AbstractRequest $request
	 * @param EventbookingTableRegistrant             $row
	 * @param array                                   $data
	 */
	protected function beforeRequestSend($request, $row, $data)
	{
		parent::beforeRequestSend($request, $row, $data);

		$request->setToken($data['stripeToken']);

		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('name, title')
			->from('#__eb_fields')
			->where('published = 1');
		$db->setQuery($query);
		$fields = $db->loadObjectList('name');

		$metaData[$fields['first_name']->title] = $row->first_name;

		if ($row->last_name)
		{
			$metaData[$fields['last_name']->title] = $row->last_name;
		}

		$metaData['Email']  = $row->email;
		$metaData['Source'] = 'Event Booking';
		$metaData['Event']  = $data['event_title'];

		$request->setMetadata($metaData);
	}
}
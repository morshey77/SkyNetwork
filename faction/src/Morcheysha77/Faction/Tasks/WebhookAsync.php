<?php

namespace Morcheysha77\Faction\Tasks;


use pocketmine\Server;
use pocketmine\scheduler\AsyncTask;

use Morcheysha77\Faction\Webhooks\Message;
use Morcheysha77\Faction\Webhooks\Webhook;

class WebhookAsync extends AsyncTask
{
    
	/** @var Webhook */
	protected Webhook $webhook;
	/** @var Message */
	protected Message $message;

    /**
     * WebhookAsync constructor.
     * @param Webhook $webhook
     * @param Message $message
     */
	public function __construct(Webhook $webhook, Message $message)
	{
		$this->webhook = $webhook;
		$this->message = $message;
	}

	public function onRun(): void
	{
	    
		$curl = curl_init($this->webhook->getURL());
		curl_setopt_array($curl, 
		[
		    CURLOPT_POSTFIELDS => json_encode($this->message),
		    CURLOPT_POST => true,
		    CURLOPT_RETURNTRANSFER => true, 
		    CURLOPT_SSL_VERIFYHOST => false, 
		    CURLOPT_SSL_VERIFYPEER => false, 
		    CURLOPT_HTTPHEADER => ["Content-Type: application/json"]
        ]);
		$this->setResult([curl_exec($curl), curl_getinfo($curl, CURLINFO_RESPONSE_CODE)]);
		curl_close($curl);
		
	}

	public function onCompletion(): void
	{
		$response = $this->getResult();
		if(!in_array($response[1], [200, 204])) 
		    Server::getInstance()->getLogger()->error("[WebhookAPI] Got error (" . $response[1] . "): " . $response[0]);
	}
}

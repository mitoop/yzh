<?php

namespace Mitoop\Yzh\API;

use Illuminate\Support\Str;
use Mitoop\Yzh\Response;
use Yzh\ApiUserSignServiceClient;
use Yzh\Model\Apiusersign\ApiUserSignContractRequest;

class Contract extends BaseAPI
{
    public function handle(): Response
    {
        $client = new ApiUserSignServiceClient($this->config);

        $request = new ApiUserSignContractRequest([
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        $response = $client->apiUserSignContract($request);

        if ($status = $response->isSuccess()) {
            $this->data = ['title' => $response->getData()->getTitle(), 'url' => $response->getData()->getUrl()];
        }

        return new Response($status, $this->data, $this->getError($response));
    }
}

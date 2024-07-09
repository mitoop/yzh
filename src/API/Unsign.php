<?php

namespace Mitoop\Yzh\API;

use Illuminate\Support\Str;
use Mitoop\Yzh\Response;
use Yzh\ApiUserSignServiceClient;
use Yzh\Model\Apiusersign\ApiUserSignReleaseRequest;

class Unsign extends BaseAPI
{
    public function handle(string $name, string $idCard): Response
    {
        $client = new ApiUserSignServiceClient($this->config);

        $request = new ApiUserSignReleaseRequest([
            'dealer_id' => $this->config->app_dealer_id,
            'broker_id' => $this->config->app_broker_id,
            'real_name' => $name,
            'id_card' => strtoupper($idCard),
            'card_type' => 'idcard',
        ]);

        $request->setRequestID((string) Str::orderedUuid());

        $response = $client->apiUserSignRelease($request);

        if ($status = $response->isSuccess()) {
            $this->data = ['status' => $response->getData()->getStatus()];
        }

        return new Response($status, $this->data, $this->getError($response));
    }
}

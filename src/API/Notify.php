<?php

namespace Mitoop\Yzh\API;

use Mitoop\Yzh\Response;
use Yzh\Model\Notify\NotifyRequest;
use Yzh\Model\Notify\NotifyResponse;
use Yzh\NotifyClient;

class Notify extends BaseAPI
{
    public function handle(): Response
    {
        $client = new NotifyClient($this->config);

        $request = new NotifyRequest(
            (string) request('data'),
            (string) request('mess'),
            (string) request('timestamp'),
            (string) request('sign')
        );

        $response = $client->verifyAndDecrypt($request);

        if ($status = ($response->getSignRes() && $response->getDescryptRes())) {
            $this->data = json_decode($response->getData(), true);
        }

        return new Response($status, $this->data, $this->getError($response));
    }

    protected function getError($response): string
    {
        /** @var NotifyResponse $response */
        if ($response->getSignRes() && $response->getDescryptRes()) {
            return '';
        }

        return sprintf(
            '验签失败 sign_res:%s descrypt_res%s',
            (int) $response->getSignRes(),
            (int) $response->getDescryptRes()
        );
    }
}

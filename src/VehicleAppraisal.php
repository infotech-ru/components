<?php

namespace infotech\components;

/**
 * Компонент для работы по API с сервисом оценки авто AutoCRM Parser
 */
class VehicleAppraisal
{
    /** @var string Оценка стоимости БУ авто */
    protected const METHOD_APPRAISAL_USED_AUTO = 'appraisal/used-auto-by-params';

    /** @var string токен для работы который мы можем получить в ЛК (http://parser.autocrm.ru/) */
    public $token = '';
    /** @var string */
    public $url = '';
    /** @var string */
    public $proxy;

    protected function sendQuery($method, $params = [])
    {
        $ch = curl_init($this->getUrl($method, $params));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json', "Authorization: Bearer {$this->token}"]);
        if ($this->proxy) {
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        $result = json_decode($output, true);
        curl_close($ch);

        return $result;
    }

    protected function getUrl($method, $params = [])
    {
        return implode('/', [
                rtrim($this->url, '/'),
                'v1',
                rtrim($method),
            ]) . '?' . http_build_query($params);
    }
}

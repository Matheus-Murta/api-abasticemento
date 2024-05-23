<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait RMQuery
{
    private function realizaConsultaRM(string $key, array $params = [],string $porta = '126704')
    {
        $apiURI = "https://pelicanoconstrucoes$porta.rm.cloudtotvs.com.br:8059/api/framework/v1/consultaSQLServer/RealizaConsulta/$key/1/G/?parameters=";
        $paramsString = $this->converterParametrosRM($params);

        return Http::withHeader('Authorization', 'Basic '.base64_encode('fluig:Centrium505050@@'))
            ->get($apiURI.$paramsString)
            ->json();
    }

    /**
     * Converte para o formato esperado pelo RM
     */
    private function converterParametrosRM(array $data): string
    {
        $params = [];

        foreach ($data as $key => $value)
        {
            if (is_array($value)) {
                $value = implode('|', $value);
            }

            $params[] = urlencode($key) . '=' . urlencode($value);
        }

        return implode(';', $params);
    }
}

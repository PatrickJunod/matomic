<?php

namespace Patrickjunod\Matomic\Services;

use Illuminate\Support\Facades\Cache;
use Patrickjunod\Matomic\Client\MatomicClient;

class Service
{
    public function getCacheKey(string $name): string
    {
        return "widgets::Matomic.{$name}";
    }

    public function clearCache(string $name): void
    {
        Cache::forget($this->getCacheKey($name));
    }

    public function getMatomoDataCached(string $name, int $limit = 10, int $expiry = 60, string $period = 'month')
    {
        return Cache::remember(
            $this->getCacheKey($name),
            $expiry, //seconds
            function () use ($limit, $period) {
                return $this->getMatomoData($limit, $period);
            },
        );
    }

    public function preloadCache(string $container): void
    {
        $this->getMatomoDataCached($container);
    }

    protected function getMatomoData(int $limit, string $period)
    {
        $matomoUrl = config('matomic.matomo_url');
        $matomoSiteId = config('matomic.matomo_site_id');
        $matomoAuthToken = config('matomic.matomo_auth_token');

        $matomoActions = new MatomicClient($matomoUrl, $matomoAuthToken);

        $visitSummary = $matomoActions->getModule('Actions');

        $res = $visitSummary->getPageUrls(['idSite' => $matomoSiteId, 'period' => $period, 'date'=>'today', 'filter_limit' => $limit]);

        $datas = collect($res)->map(function ($data) {
            return [
                'label' => \Str::start($data['label'], '/'),
                'visits' => $data['nb_visits'],
                'avg_time_on_page' => \Carbon\CarbonInterval::seconds($data['avg_time_on_page'])->cascade()->forHumans(['short' => true]),
                'avg_page_load' => \Carbon\CarbonInterval::seconds($data['avg_page_load_time'])->cascade()->forHumans(['short' => true]),
                'bounce_rate' => $data['bounce_rate'],
            ];
        });

        return $datas;
    }
}
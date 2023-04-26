<?php

namespace Patrickjunod\Matomic\Widgets;

use Patrickjunod\Matomic\Client\MatomicClient;
use Statamic\Facades\User;
use Statamic\Widgets\Widget as BaseWidget;

class MatomicMostVisitedPagesWidget extends BaseWidget
{

    public function __construct(
        protected \Patrickjunod\Matomic\Services\Service $service,
    ) {
    }

    /**
     * The HTML that should be shown in the widget.
     *
     * @return string|\Illuminate\View\View
     */
    public function html()
    {

        if (! User::current()->hasPermission('view Matomo analytics')) {
            return;
        }

        $limit = $this->config('limit', 5);
        $expiry = $this->config('expiry', 60);
        $period = $this->config('period', 'month');
        $title = $this->config('title', 'Most Visited Pages');

        return view('matomic::widgets.matomic_most_visited_pages_widget',
            [
                'datas' => $this->service->getMatomoDataCached('datas-' . $limit, $limit, $expiry, $period),
                'matomo_link' => config('matomic.matomo_url'),
                'title' => $title,
            ]);
    }

}
<div class="h-full p-0 card">
    <header class="flex items-center justify-between p-2 border-b">
        <h2>
            <a class="flex items-center" target="_blank" href="{{ $matomo_link }}">
                <div class="h-6 w-6 mr-1 text-grey-80">
                    @cp_svg('charts')
                </div>
                <span>{{ $title }}</span>
            </a>
        </h2>
    </header>
    <div>
        <table class="data-table">
            <thead>
            <tr>
                <th class="text-left">#</th>
                <th class="text-left">Link</th>
                <th class="text-right">Time on Page (Avg)</th>
                <th class="text-right">Page Load (Avg)</th>
                <th class="text-right">Bounce Rate</th>
                <th class="text-right">Visits</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($datas as $index => $data)
                <tr class="sortable-row outline-none">
                    <td class="">{{ $index + 1 }}</td>
                    <td class="">
                        <div class="flex break-all items-center"><a href="{{ $data['label'] }}" target="_blank">{{ $data['label'] }}</a></div>
                    </td>
                    <td class="text-right">{{ $data['avg_time_on_page'] }}</td>
                    <td class="text-right">{{ $data['avg_page_load'] }}</td>
                    <td class="text-right">{{ $data['bounce_rate'] }}</td>
                    <td class="text-right">{{ $data['visits'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
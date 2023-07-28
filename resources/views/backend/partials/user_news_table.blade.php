<div class="table-responsive">
    <table class="table table-borderless table-theme" style="width:100%;">
        <thead>
        <tr>
            <th style="width:60%">{{ __('Ngày / tháng') }}</th>
            <th style="width:40%">{{ __('Tổng bài viết') }}</th>

        </tr>
        </thead>
        <tbody>

{{--        @dd($datalist)--}}
        @if (isset($datalist) )
            @foreach($datalist as $row)
                <tr>
                    <td class="text-left">{{ $row->date }}</td>
                    <td class="text-left">{{ $row->total_news_user }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="8">{{ __('No data available') }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>


<div class="table-responsive">
    <table class="table table-borderless table-theme" style="width:100%;">
        <thead>
        <tr>
            <th class="checkboxlist text-center" style="width:5%"><input class="tp-check-all checkAll" type="checkbox">
            </th>
            <th class="text-left" style="width:20%">{{ __('Title') }}</th>
            <th class="text-left" style="width:10%">{{ __('IP Address') }}</th>
            <th class="text-left" style="width:10%">{{ __('Platform Name') }}</th>
            <th class="text-left" style="width:30%">{{ __('Device Name') }}</th>
            <th class="text-left" style="width:10%">{{ __('Country') }} </th>
            <th class="text-left" style="width:10%">{{ __('Robot') }}</th>
            <th class="text-left" style="width:10%">{{ __('Count') }}</th>
        </tr>
        </thead>
        <tbody>

        @if (count($trackNews)>0)
            @foreach($trackNews as $row)
{{--                @dd($row->news)--}}
                <tr>
                    <td class="checkboxlist text-center"><input name="item_ids[]" value="{{ $row->id }}"
                                                                class="tp-checkbox selected_item" type="checkbox"></td>

                        <?php $url = '//' . $row->news->categories->site->site_web . '/' . $row->news->categories->slug . '/details/' . $row->news->id . '/' . $row->news->slug; ?>
                    <td class="text-left click_search">{{ htmlDecode(rawurldecode($row->news->title))  }}</td>


                    <td class="text-left click_search">{{ $row->ip_address }}</td>
                    <td class="text-left">{{ $row->platform_name}} - {{ $row->device_name}}  </td>
                    <td class="text-left">{{ $row->device_name_full}} </td>
                    <td class="text-left">{{ $row->country}} </td>
                    <td class="text-left">{{ $row->robot}} </td>
                    <td class="text-left">{{ $row->count}} </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td class="text-center" colspan="7">{{ __('No data available') }}</td>
            </tr>
        @endif
        </tbody>
    </table>
</div>
<div class="row mt-15">
    <div class="col-lg-12 tp_pagination">
        {{ $trackNews->links() }}
    </div>
</div>

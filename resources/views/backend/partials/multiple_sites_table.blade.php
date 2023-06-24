<div class="table-responsive">
	<table class="table table-borderless table-theme" style="width:100%;">
		<thead>
			<tr>
				<th class="checkboxlist text-center" style="width:10%"><input class="tp-check-all checkAll" type="checkbox"></th>
				<th class="text-left" style="width:20%">{{ __('Site Name') }}</th>
				<th class="text-left" style="width:20%">{{ __('Site Web') }}</th>
				<th class="text-left" style="width:10%">{{ __('Count Categories') }}</th>
				<th class="text-left" style="width:10%">{{ __('Count News') }}</th>
				<th class="text-center" style="width:10%">{{ __('Image') }} </th>
				<th class="text-center" style="width:10%">{{ __('Status') }}</th>
				<th class="text-center" style="width:10%">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@if (count($datalist)>0)
			@foreach($datalist as $row)
			<tr>
				<td class="checkboxlist text-center"><input name="item_ids[]" value="{{ $row->id }}" class="tp-checkbox selected_item" type="checkbox"></td>

				<td class="text-left"><a href="{{ route('backend.site', [$row->id]) }}" title="{{ __('Edit') }}">{{ $row->site_name }}</a></td>
				<td class="text-left">{{ $row->site_web }}</td>
				<td class="text-left">{{ count($row->categories) }}</td>
				<td class="text-left">{{ count($row->news) }}</td>

				@if ($row->site_options->theme_logo != '')
                    @php
                        $logo = json_decode($row->site_options->theme_logo,true)
                    @endphp
				<td class="text-center"><div class="table_col_image"><img src="/media/{{ $logo['front_logo'] }}" /></div></td>
				@else
				<td class="text-center"><div class="table_col_image"><img src="/backend/images/album_icon.png" /></div></td>
				@endif


				@if ($row->is_publish == 1)
				<td class="text-center">
                    <span class="enable_btn">{{ $row->tp_status->status }}</span>
                </td>
				@else
				<td class="text-center"><span class="disable_btn">{{ $row->tp_status->status }}</span></td>
				@endif
				<td class="text-center">
					<div class="btn-group action-group">
                        <a onclick="onDelete({{ $row->id }})"  href="javascript:void(0);"><i class="fa fa-trash" > </i></a>&nbsp;&nbsp;&nbsp;
                        <a onclick="onClone({{ $row->id }})"  href="javascript:void(0);"><i class="fa fa-clone" ></i></a>
					</div>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td class="text-center" colspan="9">{{ __('No data available') }}</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
<div class="row mt-15">
	<div class="col-lg-12">
		{{ $datalist->links() }}
	</div>
</div>

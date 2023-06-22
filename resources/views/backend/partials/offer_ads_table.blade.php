<div class="table-responsive">
	<table class="table table-borderless table-theme" style="width:100%;">
		<thead>
			<tr>
				<th class="checkboxlist text-center" style="width:5%"><input class="tp-check-all checkAll" type="checkbox"></th>
				<th class="text-left" style="width:25%">{{ __('Title') }}</th>
				<th class="text-left" style="width:15%">{{ __('Offer & Ads Position') }}</th>
				<th class="text-left" style="width:25%">{{ __('URL') }} </th>
				<th class="text-center" style="width:10%">{{ __('Image') }} </th>
				<th class="text-center" style="width:10%">{{ __('Status') }}</th>
				<th class="text-center" style="width:10%">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>
			@if (count($offer_ads)>0)
			@foreach($offer_ads as $row)
			<tr>
				<td class="checkboxlist text-center"><input name="item_ids[]" value="{{ $row->id }}" class="tp-checkbox selected_item" type="checkbox"></td>
				<td class="text-left">{{ $row->title }}</td>
				<td class="text-left">{{ $row->offer_ad_type }}</td>
				<td class="text-left"><a target="_blank" href="{{ $row->url }}">{{ $row->url }}</a></td>

				@if ($row->image != '')
				<td class="text-center"><div class="table_col_image"><img src="/media/{{ $row->image }}" /></div></td>
				@else
				<td class="text-center"><div class="table_col_image"><img src="/backend/images/album_icon.png" /></div></td>
				@endif

				@if ($row->is_publish == 1)
				<td class="text-center"><span class="enable_btn">{{ $row->tp_status->status }}</span></td>
				@else
				<td class="text-center"><span class="disable_btn">{{ $row->tp_status->status }}</span></td>
				@endif
				<td class="text-center">
					<div class="btn-group action-group">
						<a class="action-btn" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a onclick="onEdit({{ $row->id }})" class="dropdown-item" href="javascript:void(0);">{{ __('Edit') }}</a>
							<a onclick="onDelete({{ $row->id }})" class="dropdown-item" href="javascript:void(0);">{{ __('Delete') }}</a>
						</div>
					</div>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td class="text-center" colspan="6">{{ __('No data available') }}</td>
			</tr>
			@endif
		</tbody>
	</table>
</div>
<div class="row mt-15">
	<div class="col-lg-12 tp_pagination">
		{{ $offer_ads->links() }}
	</div>
</div>

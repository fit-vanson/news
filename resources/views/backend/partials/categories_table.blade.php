<div class="table-responsive">
	<table class="table table-borderless table-theme" style="width:100%;">
		<thead>
			<tr>
				<th class="checkboxlist text-center" style="width:10%"><input class="tp-check-all checkAll" type="checkbox"></th>
                <th class="text-left" style="width:50%">{{ __('Name') }}</th>
                <th class="text-left" style="width:10%">{{ __('Count News') }}</th>
                <th class="text-center" style="width:10%">{{ __('Image') }} </th>
                <th class="text-center" style="width:10%">{{ __('Status') }}</th>
                <th class="text-center" style="width:10%">{{ __('Action') }}</th>
			</tr>
		</thead>
		<tbody>

			@if (count($categories)>0)
			@foreach($categories as $row)
                <tr>
                    <td class="checkboxlist text-center"><input name="item_ids[]" value="{{ $row->id }}" class="tp-checkbox selected_item" type="checkbox"></td>
                    <td class="text-left">{{ rawurldecode($row->name) }}</td>
                    <td class="text-left">{{ count($row->news) }}</td>
                    {{--				<td class="text-left">{{ $row->language_name }}</td>--}}

                    @if ($row->thumbnail != '')
                        <td class="text-center"><div class="table_col_image"><img src="/media/{{ $row->thumbnail }}" /></div></td>
                    @else
                        <td class="text-center"><div class="table_col_image"><img src="/backend/images/album_icon.png" /></div></td>
                    @endif

                    @if ($row->is_publish == 1)
                        <td class="text-center"><span class="enable_btn">{{ $row->tp_status->status  }}</span></td>
                    @else
                        <td class="text-center"><span class="disable_btn">{{ $row->tp_status->status  }}</span></td>
                    @endif
                    <td class="text-center">

                        <div class="btn-group action-group">
                            <a onclick="onEdit({{ $row->id }})" href="javascript:void(0);"><i class="fa fa-edit" style="font-size: x-large"></i></a>&nbsp;&nbsp;&nbsp;
                            <a onclick="onDelete({{ $row->id }})" href="javascript:void(0);"><i class="fa fa-trash" style="font-size: x-large"> </i></a>
                            {{--                        <a onclick="onClone({{ $row->id }})"  href="javascript:void(0);"><i class="fa fa-clone" ></i></a>--}}
                        </div>
                    </td>
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
		{{ $categories->links() }}
	</div>
</div>

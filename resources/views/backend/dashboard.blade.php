@extends('layouts.backend')

@section('title', __('Dashboard'))

@section('content')
<!-- main Section -->
<div class="main-body">
	<div class="container-fluid">

		<div class="row">
			<div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-25">
				<div class="status-card bg-grad-1">
					<div class="status-text">
						<div class="status-name opacity50">{{ __('Total') }}</div>
						<div class="status-name opacity50">{{ __('News') }}</div>
						<h2 class="status-count">{{ $total_sites }}</h2>
					</div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
						<path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
					</svg>
				</div>
			</div>

			<div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-25">
				<div class="status-card bg-grad-2">
					<div class="status-text">
						<div class="status-name opacity50">{{ __('Total') }}</div>
						<div class="status-name opacity50">{{ __('Categories') }}</div>
						<h2 class="status-count">{{ $total_categories }}</h2>
					</div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
						<path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
					</svg>
				</div>
			</div>

			<div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-25">
				<div class="status-card bg-grad-3">
					<div class="status-text">
						<div class="status-name opacity50">{{ __('Total') }}</div>
						<div class="status-name opacity50">{{ __('News') }}</div>
						<h2 class="status-count">{{ $total_news }}</h2>
					</div>
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
						<path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
					</svg>
				</div>
			</div>
            {{--			<div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-4">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Orders') }}</div>
                                    <div class="status-name opacity50">{{ __('Ready for pickup') }}</div>
                                    <h2 class="status-count">{{ $ready_for_pickup_order }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-5">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Orders') }}</div>
                                    <div class="status-name opacity50">{{ __('Completed') }}</div>
                                    <h2 class="status-count">{{ $completed_order }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-6">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Orders') }}</div>
                                    <div class="status-name opacity50">{{ __('Canceled') }}</div>
                                    <h2 class="status-count">{{ $canceled_order }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-7">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Total') }}</div>
                                    <div class="status-name opacity50">{{ __('Published Products') }}</div>
                                    <h2 class="status-count">{{ $published_product }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-8">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Total') }}</div>
                                    <div class="status-name opacity50">{{ __('Published Categories') }}</div>
                                    <h2 class="status-count">{{ $published_category }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-9">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Total') }}</div>
                                    <div class="status-name opacity50">{{ __('Published Brands') }}</div>
                                    <h2 class="status-count">{{ $published_brand }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-10">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Total') }}</div>
                                    <div class="status-name opacity50">{{ __('Review & Ratings') }}</div>
                                    <h2 class="status-count">{{ $review }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-11">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Total') }}</div>
                                    <div class="status-name opacity50">{{ __('Customers') }}</div>
                                    <h2 class="status-count">{{ $total_customer }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-4 col-lg-3 col-xl-3 mt-25">
                            <div class="status-card bg-grad-12">
                                <div class="status-text">
                                    <div class="status-name opacity50">{{ __('Total') }}</div>
                                    <div class="status-name opacity50">{{ __('Out of Stock Products') }}</div>
                                    <h2 class="status-count">{{ $out_of_stock_products }}</h2>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                                    <path fill="rgba(255,255,255,0.2)" fill-opacity="1" d="M0,32L34.3,58.7C68.6,85,137,139,206,138.7C274.3,139,343,85,411,53.3C480,21,549,11,617,10.7C685.7,11,754,21,823,42.7C891.4,64,960,96,1029,138.7C1097.1,181,1166,235,1234,218.7C1302.9,203,1371,117,1406,74.7L1440,32L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path>
                                </svg>
                            </div>
                        </div>--}}
		</div>

		<div class="row">
			<div class="col-lg-6 mt-25">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-12">
								<span>{{ __('Top 10 News Viewers') }}</span>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-borderless table-theme" style="width:100%;">
								<thead>
									<tr>
										<th class="text-left" style="width:50%">{{ __('News') }}</th>
										<th class="text-left" style="width:30%">{{ __('Site ') }}</th>
										<th class="text-center" style="width:20%">{{ __('Viewers') }}</th>
									</tr>
								</thead>
								<tbody>
									@if (count($newsViewers)>0)
									@foreach($newsViewers as $row)
									<tr>
                                        <td class="text-left"><a href="@if($row->categories) {{ route('backend.news',['site_id'=>$row->categories->site->id, 'news_id'=> $row->id]) }} @endif">{{ htmlDecode(rawurldecode($row->title))  }}</a></td>
                                        <td class="text-left"><a href="@if($row->categories) {{ route('backend.site',['id'=>$row->categories->site->id]) }} @endif">{{ @$row->categories->site->site_name }}</a></td>
                                        <td class="text-center">{{ $row->viewers }}</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td class="text-center" colspan="2">{{ __('No data available') }}</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-6 mt-25">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-lg-12">
								<span>{{ __('Top 10 News Latest') }}</span>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-borderless table-theme" style="width:100%;">
								<thead>
									<tr>
										<th class="text-left" style="width:50%">{{ __('Products') }}</th>
										<th class="text-left" style="width:20%">{{ __('Site') }}</th>
										<th class="text-center" style="width:15%">{{ __('Viewers') }}</th>
										<th class="text-center" style="width:15%">{{ __('User Created') }}</th>
									</tr>
								</thead>
								<tbody>
									@if (count($newsLatest)>0)
									@foreach($newsLatest as $row)
									<tr>
                                        <td class="text-left"><a href="@if($row->categories) {{ route('backend.news',['site_id'=>$row->categories->site->id, 'news_id'=> $row->id]) }} @endif">{{ htmlDecode(rawurldecode($row->title))  }}</a></td>
                                        <td class="text-left"><a href="@if($row->categories) {{ route('backend.site',['id'=>$row->categories->site->id]) }} @endif">{{ @$row->categories->site->site_name }}</a></td>
										<td class="text-center">{{ $row->viewers }}</td>
										<td class="text-center">{{ $row->user->name }}</td>
									</tr>
									@endforeach
									@else
									<tr>
										<td class="text-center" colspan="3">{{ __('No data available') }}</td>
									</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
<!-- /main Section -->
@endsection

@push('scripts')

@endpush

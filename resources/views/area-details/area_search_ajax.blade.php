@extends('layouts.ajax')

@section('content') 
@foreach($area_lists_ajax as $area_info)
	<div class="site-item d-flex col-md-6 col-xxl-6 item-m6-l4-xxl3">
		<div class="site-box">
			<a href="{{ route('area-details', ['id' => $area_info->id]) }}" class="d-block img-elm">
				<span class="d-block">
					@if($area_info->area_pic1 == NULL)
						<img class="w-100" src="{{asset('images/area/no-image.png')}}" alt="img"/>
					@else
						<img src="{{ url('public/application_files/area_images') . '/'. $area_info->area_pic1 }}" alt="img"/>
					@endif
				</span>
			</a>
			<div class="info-elmnt">
				<h3><a href="{{ route('area-details', ['id' => $area_info->id]) }}">{{ $area_info->title }}</a></h3>
				<ul>
					<li><h4>State</h4><span>{{ $area_info->state->name ?? '' }}</span></li>
					<li><h4>City</h4><span>{{ $area_info->city->name ?? '' }}</span></li>
					<li><h4>Size</h4><span>{{ $area_info->width }}x{{ $area_info->height }}</span></li>
				</ul>
				
			</div>
		</div>
	</div>
@endforeach
@endsection
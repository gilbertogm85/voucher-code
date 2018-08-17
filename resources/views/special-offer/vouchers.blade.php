@extends('app')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/">{{__('Home')}}</a></li>
			<li class="breadcrumb-item"><a href="/special-offer">{{__('Special Offer')}}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $special_offer->name }}</li>
		</ol>
	</nav>
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif
	@if ($message = Session::get('unsuccess'))
	<div class="alert alert-danger">
		<strong>Whoops!</strong> Something is wrong.<br><br>
		<ul>
			<p>{{$message}}</p>
		</ul>
	</div>
	@endif
	@if(isset($alert))
	@if ($alert == 'success')
	<div class="alert alert-success">
		<p>Vouchers were created successfully!</p>
	</div>
	@elseif ($alert == 'error')
	<div class="alert alert-danger">
		<strong>Whoops!</strong> Something is wrong.<br><br>
		<ul>
			<p>There wasn't any vouchers to be created!</p>
		</ul>
	</div>
	@endif
	@endif
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">{{ __('List of All Vouchers of this Special Offer:') }}
						<small> {{ $special_offer->name }} (Discount {{ $special_offer->discount }}%)</small>
					</h4>
				</div>

				<div class="card-body">
					<table class="table table-borderless">
						<thead>
							<tr>
								<th scope="col">Code</th>
								<th scope="col">Status</th>
								<th scope="col">E-mail</th>	
								<th scope="col">Date Used</th>							
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($vouchers as $i)
							<tr>
								<td scope="row">{{ $i->code }}</td>
								<td >@if($i->used_at)  <i class="fas fa-check" data-toggle="tooltip" data-placement="top" title="{{__('Voucher used.')}}"> @else <i class="fas fa-times" data-toggle="tooltip" data-placement="top" title="{{__('Voucher not used.')}}"> @endif</td>
									<td >{{ $i->email }}</td>
									<td >{{ $i->used_at ? $i->used_at : '-' }}</td>
									<td>
										<div style="display: inline-flex">
											@if(is_null($i->used_at))
											@if($i->expiry_date >= date('Y-m-d'))
											<div style="margin-right: 5px"><a class="btn btn-primary" href="{{ route('vouchers.confirm',[$i->code,$i->email]) }}" data-toggle="tooltip" data-placement="top" title="{{__('Mark this voucher as used.')}}"><i class="fas fa-eye"></i></a></div>
											<div style="margin-right: 5px"><a class="btn btn-primary" href="{{ route('vouchers.send-voucher',[$i->code,$i->email]) }}" data-toggle="tooltip" data-placement="top" title="{{__('Send voucher by email')}}"><i class="fas fa-envelope"></i></a></div>
											<div><form action="{{ route('voucher.destroy',$i->voucher_id) }}" method="POST">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="{{__('Delete this voucher.')}}"><i class="fas fa-trash-alt"></i></button>
											</form></div>
											@else
											Expired
											@endif
											@endif
										</div>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('table').DataTable({responsive: true});
	} );
</script>
@endsection
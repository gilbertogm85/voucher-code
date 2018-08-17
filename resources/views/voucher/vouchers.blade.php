@extends('app')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/">{{__('Home')}}</a></li>
			<li class="breadcrumb-item"><a href="/recipient">{{__('Recipient')}}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{__('Voucher Codes')}}</li>
		</ol>
	</nav>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">{{ __('Voucher Codes') }}
					</h4>
				</div>

				<div class="card-body">
					<table class="table table-borderless table-hover">
						<thead>
							<tr>
								<th scope="col">Special Offer</th>
								<th scope="col">Voucher Code</th>
								<th scope="col">Date Used</th>							
								<th scope="col">Discount</th>
								<th scope="col">Expiry date</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($vouchers as $v)
							<tr>
								<td scope="row">{{ $v->name }}</td>
								<td>{{ $v->code }}</td>
								<td>{{ $v->used_at ? $v->used_at : 'Not used yet' }}</td>
								<td>{{ $v->discount }}%</td>
								<td>{{ $v->expiry_date }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
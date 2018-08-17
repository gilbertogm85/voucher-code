@extends('app')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/">{{__('Home')}}</a></li>
			<li class="breadcrumb-item"><a href="/special-offer">{{__('Special Offer')}}</a></li>
			<li class="breadcrumb-item"><a href="/special-offer/{{ $voucher->special_offer_id }}">{{ $voucher->name }}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{__('Voucher Code')}}</li>
		</ol>
	</nav>
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">{{ __('Voucher Code') }}
					</h4>
				</div>

				<div class="card-body">
					@if(isset($voucher))
						@if(is_null($voucher->used_at))
							<form method="POST">
								@csrf
								<div>
									<label for="code">Voucher Code: </label>
									<input type="text" name="code" readonly value="{{ $voucher->code }}">
								</div>
								<div>
									<label for="used_at">Date used: </label>
									<input type="hidden" name="used_at" readonly value="{{ date('Y-m-d') }}">
									<input type="text" name="used_at2" readonly value="Not used yet">
								</div>
								<div>
									<label for="discount">Discount: </label>
									<input type="text" name="discount" readonly value="{{ $voucher->discount }}%">
								</div>
								<button type="submit" class="btn btn-primari">Check as used today</button>
							</form>
						@else
							Voucher for {{ $voucher->email }} has already been used at {{ $voucher->used_at }}
						@endif
 					@else
						It's not a valid combination of voucher and e-mail address.
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
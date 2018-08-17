@extends('app')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/">{{__('Home')}}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{__('Special Offers')}}</li>
		</ol>
	</nav>
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif
	@if ($errors->any())
	<div class="alert alert-danger">
		<strong>Whoops!</strong> Something is wrong.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">{{ __('List of All Special Offers') }}
					</h4>
					<div>
						<a href="{{ route('special-offer.create') }}"><button class="btn btn-primary">New Special Offer</button></a>
					</div>
				</div>

				<div class="card-body">
					<table class="table table-borderless table-hover">
						<thead>
							<tr>
								<th scope="col">Name</th>
								<th scope="col">Expiry Date</th>
								<th scope="col">Discount</th>							
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($special_offers as $i)
							<tr>
								<td scope="row">{{ $i->name }}</td>
								<td >{{ $i->expiry_date }}</td>
								<td >{{ $i->discount }}%</td>
								<td>
									<div style="display: inline-flex">
										<div style="margin-right: 5px"><a class="btn btn-primary" href="{{ route('special-offer.show',$i->special_offer_id) }}" data-toggle="tooltip" data-placement="top" title="{{__('Show all the generated vouchers to this offer')}}"><i class="fas fa-eye"></i></a></div>
										<div style="margin-right: 5px"><a class="btn btn-primary" href="{{ route('vouchers.late-vouchers',$i->special_offer_id) }}" data-toggle="tooltip" data-placement="top" title="{{__('In case you created users after you created an offer, you can generate vouchers to those users.')}}"><i class="fas fa-sync-alt"></i></a></div>
										<div><form action="{{ route('special-offer.destroy',$i->special_offer_id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="{{__('Remove the offer and its vouchers.')}}"><i class="fas fa-trash-alt"></i></button>
										</form></div>
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
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready( function () {
		$('table').DataTable({responsive: true});
	} );
</script>
@endsection
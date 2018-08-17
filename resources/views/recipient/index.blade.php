@extends('app')

@section('content')
<div class="container">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="/">{{__('Home')}}</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{__('Recipient')}}</li>
		</ol>
	</nav>
	@if ($message = Session::get('success'))
	<div class="alert alert-success">
		<p>{{ $message }}</p>
	</div>
	@endif
	@if ($errors->any() || $message = Session::get('error'))
	<div class="alert alert-danger">
		<strong>Whoops!</strong> Something is wrong.<br><br>
		<ul>
			@if($errors->any())
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
			@else
			<p>{{ $message }}</p>
			@endif
		</ul>
	</div>
	@endif
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4 class="my-0 font-weight-normal">{{ __('List of All Recipients') }}
					</h4>
					<div>
						<a href="{{ route('recipient.create') }}"><button class="btn btn-primary">New Recipient</button></a>
					</div>
				</div>
				<div class="card-body">
					<table class="table table-borderless">
						<thead>
							<tr>
								<th scope="col">Name</th>
								<th scope="col">Email</th>
								<th scope="col">Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($recipients as $i)
							<tr>
								<td scope="row">{{ $i->name }}</td>
								<td >{{ $i->email }}</td>
								<td>
									<div style="display: inline-flex">
										<div style="margin-right: 5px"><a class="btn btn-primary" href="{{ route('recipient.edit',$i->recipient_id) }}" data-toggle="tooltip" data-placement="top" title="{{__('Edit this recipient.')}}"><i class="fas fa-edit"></i></a></div>
										<div style="margin-right: 5px"><a class="btn btn-primary" href="{{ route('vouchers.email',$i->email) }}" data-toggle="tooltip" data-placement="top" title="{{__('View all the valid vouchers of this recipient.')}}"><i class="fas fa-eye"></i></a></div>
										<div><form action="{{ route('recipient.destroy',$i->recipient_id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-danger"  data-toggle="tooltip" data-placement="top" title="{{__('Delete this recipient.')}}"><i class="fas fa-trash-alt"></i></button>
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

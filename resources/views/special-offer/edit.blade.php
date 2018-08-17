@extends('app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">{{__('Home')}}</a></li>
            <li class="breadcrumb-item"><a href="/special-offer">{{__('Special Offer')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('Edit')}}</li>
        </ol>
    </nav>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Edit Special Offer') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('special-offer.update', $special_offer->special_offer_id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $special_offer ? $special_offer->name : old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="expiry_date" class="col-md-4 col-form-label text-md-right">{{ __('Expiry Date') }}</label>

                            <div class="col-md-6">
                                <input id="expiry_date" type="date" class="form-control{{ $errors->has('expiry_date') ? ' is-invalid' : '' }}" name="expiry_date" value="{{ $special_offer ? $special_offer->expiry_date : old('expiry_date') }}" required>

                                @if ($errors->has('expiry_date'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('expiry_date') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="discount" class="col-md-4 col-form-label text-md-right">{{ __('Discount') }}</label>

                            <div class="col-md-6">
                                <input id="discount" type="number" min='0' max="100" step="any" class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" value="{{ $special_offer ? $special_offer->discount : old('discount') }}" required>

                                @if ($errors->has('discount'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('discount') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Edit Special Offer') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Client Edit')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('client.index') }}" class="btn btn-success">All
                                Client</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('client.update', $client->id) }}">
                            @csrf
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Client Name</label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('name') ? 'is-invalid' : 'is-valid' }}"
                                        name="name" value="{{ old('name', $client->name) }}" id="name"
                                        placeholder="Enter Client Name">
                                    @error('name')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">Email</label>
                                <div class="col-sm-4">
                                    <input type="email"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-valid' }}"
                                        id="email" name="email" value="{{ old('email', $client->email) }}"
                                        placeholder="Enter Email">
                                    @error('email')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Phone</label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('phone') ? 'is-invalid' : 'is-valid' }}"
                                        id="phone" name="phone" value="{{ old('phone', $client->phone) }}"
                                        placeholder="Enter Phone">
                                    @error('phone')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <label class="col-sm-2 col-form-label text-right">Opening Balance</label>
                                <div class="col-sm-4">
                                    <input type="text"
                                        class="form-control {{ $errors->has('opening_balance') ? 'is-invalid' : 'is-valid' }}"
                                        id="opening_balance" name="opening_balance"
                                        value="{{ old('opening_balance', 0) }}">
                                    @error('opening_balance')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label text-right">Client Category</label>
                                <div class="col-sm-4">
                                    <select name="client_category" class="form-control" id="client_category">
                                        <option value="">Select One</option>
                                        @foreach ($client_categories as $client_category)
                                            <option
                                                {{ old('client_category', $client->client_category_id) == $client_category->id ? 'selected' : '' }}
                                                value="{{ $client_category->id }}">{{ $client_category->name }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('client_category')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label text-right">Address</label>
                                <div class="col-sm-4">
                                    <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : 'is-valid' }}" id="address" name="address"
                                        value="{{ old('address', $client->address) }}" placeholder="Enter your address">{{ old('address', $client->address) }}</textarea>
                                    @error('address')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                            <label class="col-sm-2 col-form-label">User Type</label>
                            <div class="col-sm-10">
                                <select class="js-example-basic-single col-sm-10">
                                    <option value="">Select Option</option>
                                    <option value="AL">Alabama</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                                <span class="messages"></span>
                            </div>
                        </div> --}}
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-check text-right">Status</label>
                                <div class="col-sm-4">
                                    <div class="form-radio">
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="1"
                                                    {{ old('status', $client->status) == '1' ? 'checked' : '' }}
                                                    data-bv-field="status">
                                                <i class="helper"></i>Active
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="status" value="0"
                                                    {{ old('status', $client->status) == '0' ? 'checked' : '' }}
                                                    data-bv-field="status">
                                                <i class="helper"></i>Inactive
                                            </label>
                                        </div>
                                    </div>
                                    @error('status')
                                        <span class="help-block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary m-b-0">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

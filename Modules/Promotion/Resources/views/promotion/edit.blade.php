@extends('layouts.app')
@section('title', 'Promotion Edit')
@section('content')
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-inline" style="float: left">
                            <h4>@yield('title')</h4>
                        </div>
                        <h5 style="float: right"><a href="{{ route('promotion.index') }}" class="btn btn-success">All
                                Promotion</a></h5>
                    </div>
                    <div class="card-block mt-4">
                        <form id="main" method="post" action="{{ route('promotion.update', $data->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Promotion Title</label>
                                        <div class="col-sm-8">
                                            <input type="text"
                                                class="form-control {{ $errors->has('title') ? 'is-invalid' : 'is-valid' }}"
                                                name="title" value="{{ old('title', $data->title) }}" id="title"
                                                placeholder="Enter Promotion Title">
                                            @error('title')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Platform</label>
                                        <div class="col-sm-8">
                                            <input type="text"
                                                class="form-control {{ $errors->has('platform') ? 'is-invalid' : 'is-valid' }}"
                                                id="platform" name="platform" value="{{ old('platform', $data->platform) }}"
                                                placeholder="Enter Platform">
                                            @error('platform')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Date</label>
                                        <div class="col-sm-8">
                                            <input type="date"
                                                class="form-control {{ $errors->has('date') ? 'is-invalid' : 'is-valid' }}"
                                                id="date" name="date" value="{{ old('date', $data->date) }}"
                                                placeholder="Enter date">
                                            @error('date')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Details</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control {{ $errors->has('details') ? 'is-invalid' : 'is-valid' }}" id="details" name="details"
                                                rows="3" value="{{ old('details', $data->details) }}" placeholder="Enter Details">{{ old('details', $data->details) }}</textarea>
                                            @error('details')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6 ">
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Promotion Type</label>
                                        <div class="col-sm-8">
                                            <select name="promotion_type" class="form-control" id="promotion_type">
                                                <option value="">Select One</option>
                                                <option {{ old('promotion_type', $data->promotion_type) == 'Online' ? 'selected' : '' }}
                                                    value="Online">
                                                    Online
                                                </option>
                                                <option {{ old('promotion_type', $data->promotion_type) == 'Offline' ? 'selected' : '' }}
                                                    value="Offline">
                                                    Offline
                                                </option>

                                            </select>
                                            @error('promotion_type')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Payment Type</label>
                                        <div class="col-sm-8">
                                            <select name="transaction_method" class="form-control" id="transaction_method">
                                                <option value="">Select One</option>
                                                <option {{ old('transaction_method', $data->transaction_method) == '1' ? 'selected' : '' }}
                                                    value="1">
                                                    Cash
                                                </option>
                                                <option {{ old('transaction_method', $data->transaction_method) == '2' ? 'selected' : '' }}
                                                    value="2">
                                                    Bank
                                                </option>

                                            </select>
                                            @error('transaction_method')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div id="bank_area">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label text-right">Bank</label>
                                            <div class="col-sm-8">
                                                <select name="bank" class="form-control" id="bank">
                                                    <option value="">Select One</option>
                                                    @foreach ($banks as $bank)
                                                        <option
                                                            value="{{ $bank->id }}"{{ old('bank', $data->bank_id) == $bank->id ? ' selected' : '' }}>
                                                            {{ $bank->bank_name }} (Ac : {{ $bank->ac_number }})</option>
                                                    @endforeach
                                                </select>
                                                @error('bank')
                                                    <span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label text-right">Cheque No.</label>
                                            <div class="col-sm-8">
                                                <input class="form-control is-valid-border" type="text" name="cheque_no"
                                                    placeholder="Enter Cheque No." value="{{ old('cheque_no', $data->cheque_no) }}">
                                                @error('cheque_no')
                                                    <span class="help-block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label text-right">Cheque Image.</label>
                                            <div class="col-sm-8">
                                                <input type="file" name="cheque_image"
                                                    class="form-control value="{{ old('cheque_image') }}">
                                                @error('cheque_image')
                                                    <span class="help-block">{{ $message }}</span>
                                                @enderror
                                                @if ($data->cheque_image)
                                                {{-- <img src="ass{{ base64_encode($data->cheque_image) }}" alt="Image"> --}}
                                                <a target="_blank" href="{{ asset($data->cheque_image) }}"> <img class="mt-2" src="{{ asset($data->cheque_image) }}" alt="Image" width="100" height="100"></a>

                                                @endif
                                               </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label text-right">Cost</label>
                                        <div class="col-sm-8">
                                            <input type="number"
                                                class="form-control {{ $errors->has('cost') ? 'is-invalid' : 'is-valid' }}"
                                                id="cost" name="cost" value="{{ old('cost', $data->cost) }}">
                                            @error('cost')
                                                <span class="help-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
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

@section('script')

    <script>
        $(function() {
            $('#transaction_method').change(function() {
                var type = $(this).val();
                if (type == 1) {
                    $('#bank_area').hide();
                } else if (type == 2) {
                    $('#bank_area').show();
                } else {
                    $('#bank_area').hide();
                }
            })
            $('#transaction_method').trigger('change')
        })
    </script>
@endsection

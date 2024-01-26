@extends('layouts.app')
@section('title','Task Add')
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-inline" style="float: left">
                        <h4>@yield('title')</h4>
                    </div>
                    <h5 style="float: right"><a href="{{ route('task.task_all') }}" class="btn btn-success">All Task</a></h5>
                </div>
                <div class="card-block mt-4">
                    <form id="main" method="post" action="{{ route('task.task_add') }}">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right">Title</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' :'is-valid' }}" name="title" value="{{ old('title') }}" id="title" placeholder="Enter Title">
                                @error('title')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label text-right">User</label>
                            <div class="col-sm-4">
                                <select name="user" id="user" class="form-control">
                                    <option value="">Select One</option>
                                    @foreach ($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                                @error('user')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right" for="task_type">Task Type</label>
                            <div class="col-sm-4">
                                <select name="task_type" id="task_type" class="form-control">
                                    <option value="">Select One</option>
                                    <option value="1">Individual</option>
                                    <option value="2">Market visit	</option>

                                </select>
                                @error('task_type')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <label class="col-sm-2 col-form-label text-right" for="date">Date</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control {{ $errors->has('opening_balance') ? 'is-invalid' :'' }}" id="date" name="date" value="{{ old('date') }}">
                                @error('date')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label text-right" for="reason">Reason</label>
                            <div class="col-sm-4">
                                <textarea class="form-control {{ $errors->has('reason') ? 'is-invalid' :'is-valid' }}" id="reason" rows="6" name="reason" value="{{ old('reason') }}" placeholder="Enter your address"></textarea>
                                @error('reason')
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
                        {{-- <div class="form-group row">
                            <label class="col-sm-2 col-form-check text-right">Status</label>
                            <div class="col-sm-4">
                                <div class="form-radio">
                                    <div class="radio radiofill radio-primary radio-inline">
                                        <label>
                                            <input type="radio" name="status" value="1" {{ old('status','1') == '1' ? 'checked' : '' }} data-bv-field="status">
                                            <i class="helper"></i>Active
                                        </label>
                                    </div>
                                    <div class="radio radiofill radio-primary radio-inline">
                                        <label>
                                            <input type="radio" name="status" value="0" {{ old('status') == '0' ? 'checked' : '' }} data-bv-field="status">
                                            <i class="helper"></i>Inactive
                                        </label>
                                    </div>
                                </div>
                                @error('status')
                                   <span class="help-block">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group row">
                            <label class="col-sm-2"></label>
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

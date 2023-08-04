@include('layouts.includes.alerts')


<form role="form" action="{{ route('users.store') }}" method="POST">
    @csrf
    
    <div class="form-group row">
        <div class="col-sm-6">
            <label>{{ __('Given Name') }}</label>
            <div class="mb-3">
                <input name="given_name" type="text" class="form-control" value="{{ old('given_name') }}">
                @error('given_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <label>{{ __('Family Name') }}</label>
            <div class="mb-3">
                <input name="family_name" type="text" class="form-control" value="{{ old('family_name') }}">
                @error('family_name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-6">
            <label>{{ __('Email') }}</label>
            <div class="mb-3">
                <input name="email" type="email" class="form-control" aria-label="Email" aria-describedby="email-addon" value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <label>{{ __('Type') }}</label>
            <div class="mb-3">
                <select name="type" class="form-control" value="{{ old('type') }}">
                    <option value="">Select an option</option>
                    <option value="owner">Owner</option>
                    <option value="tenant">Tenant</option>
                </select>
                @error('type')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>   
    </div>

    <div class="form-group">
        <button type="submit" class="btn bg-gradient-primary mt-3 mb-0 mr-auto">Create</button>
    </div>
</form>

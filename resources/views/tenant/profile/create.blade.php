@extends('layouts.app') 

@section('content')
    <h1>Create Tenant Profile</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('tenant.profile.store') }}" method="POST">
        @csrf

        <label for="full_name">Full Name:</label>
        <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}">
        @error('full_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <label for="phone_number">Phone Number:</label>
        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number') }}">
        @error('phone_number')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <!-- Add more fields as needed -->

        <button type="submit">Submit</button>
    </form>
@endsection

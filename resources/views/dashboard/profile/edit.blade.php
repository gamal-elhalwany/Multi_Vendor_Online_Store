@extends('layouts.dashboardLayout')

@section('title', 'Edit Profile')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Profile</li>
    <li class="breadcrumb-item active">Edit Profile</li>
@endsection

@section('content')
    <x-alert type="success" />
    <form action="{{ route('dashboard.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <div class="form-group">
            <label for="">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $user->profile->first_name) }}"/>
            @error('first_name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="">Last Name</label>
            <input name="last_name" class="form-control" value="{{ old('last_name', $user->profile->last_name) }}">
            @error('last_name')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>

        {{-- <div class="form-group">
            <label for="">Image</label>
            <input type="file" name="image" class="form-control"/>
            @error('image')
                <p class="text-danger">{{ $message }}</p>
            @enderror
            @if ($category->image)
            <img src="{{ asset('storage/' .$category->image) }}" alt="Image" height="50">
            @endif
        </div> --}}

        <div class="form-group d-flex jutify-between m-4">
            <div class="col-md-6">
                <label for="birthday">Birthday</label>
                <input class="form-control" type="date" name="birth_day" value="{{ old('birth_day', $user->profile->birth_day) }}">
                @error('birth_day')
                    <p class="text-danger">{{ $message }}</p>
                @enderror

            </div>

            <div class="col-md-6">
                <label for="street_address">street_address</label>
                <input class="form-control" type="text" name="street_address" value="{{ old('street_address', $user->profile->street_address) }}">
                @error('street_address')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group d-flex jutify-between m-4">
            <div class="col-md-6">
                <label for="city">City</label>
                <input class="form-control" type="text" name="city" value="{{ old('city', $user->profile->city) }}">
                @error('city')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-6">
                <label for="state">State</label>
                <input class="form-control" type="text" name="state" value="{{ old('state', $user->profile->state) }}">
                @error('state')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group d-flex jutify-between m-4">
            <div class="col-md-6">
                <label for="postal_code">Postal_code</label>
                <input class="form-control" type="text" name="postal_code" value="{{ old('postal_code', $user->profile->postal_code) }}">
                @error('postal_code')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-6">
                <label>Country</label>
                <select class="form-control form-select" name="country" value="{{ $user->profile->country }}">
                    <option value="Country">Select Country</option>
                    @foreach ($countries as $country)
                    <option value="{{ $country }}" @selected($user->profile->country)>{{ $country }}</option>
                    @endforeach
                </select>
                @error('country')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group d-flex jutify-between m-4">
            <div class="col-md-6">
                <label>Locale</label>
                <select class="form-control form-select" name="local">
                    <option value="Locale">Locale</option>
                    @foreach ($languages as $language)
                    <option value="{{ $language }}">{{ $language }}</option>
                    @endforeach
                </select>
                @error('locale')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>

            <div class="col-md-6">
                <label>Gender</label>
                <select class="form-control form-select" name="gender">
                    <option value="">Gender</option>
                    <option value="male" @selected($user->profile->gender == 'male')>Male</option>
                    <option value="female" @selected($user->profile->gender == 'female')>Female</option>
                </select>
                @error('gender')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection

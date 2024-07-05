<x-guest-layout>
    <form method="POST" action="{{ route('merchant_create') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone_number" :value="old('phone')" required autofocus autocomplete="phone" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- First name -->
        <div class="mt-4">
            <x-input-label for="First name" :value="__('first name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="First name" />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <!-- Last name -->
        <div class="mt-4">
            <x-input-label for="last name" :value="__('last name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <!-- Birth Day -->
        <div class="mt-4">
            <x-input-label for="birth day" :value="__('birth day')" />
            <x-text-input id="birth_day" class="block mt-1 w-full" type="date" name="birth_day" :value="old('birth_day')" required autofocus autocomplete="birth_day" />
            <x-input-error :messages="$errors->get('birth_day')" class="mt-2" />
        </div>

        <!-- Gender -->
        <div class="mt-4">
            <x-input-label for="gender" :value="__('gender')" />
            <select name="gender" id="gender" class="form-control">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            <x-input-error :messages="$errors->get('gender')" class="mt-2" />
        </div>

        <!-- Country -->
        <div class="mt-4">
            <x-input-label for="country" :value="__('country')" />
            <select name="country" id="country" class="form-control">
                <option>Country</option>
                @foreach($countries as $country)
                <option value="{{$country}}">{{$country}}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('country')" class="mt-2" />
        </div>

        <!-- Street Address -->
        <div class="mt-4">
            <x-input-label for="street_address" :value="__('street address')" />
            <x-text-input id="street_address" class="block mt-1 w-full" type="text" name="street_address" :value="old('street_address')" required autofocus autocomplete="street_address" />
            <x-input-error :messages="$errors->get('street_address')" class="mt-2" />
        </div>

        <!-- City -->
        <div class="mt-4">
            <x-input-label for="city" :value="__('city')" />
            <x-text-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required autofocus autocomplete="city" />
            <x-input-error :messages="$errors->get('city')" class="mt-2" />
        </div>

        <!-- state -->
        <div class="mt-4">
            <x-input-label for="state" :value="__('state')" />
            <x-text-input id="state" class="block mt-1 w-full" type="text" name="state" :value="old('state')" required autofocus autocomplete="state" />
            <x-input-error :messages="$errors->get('state')" class="mt-2" />
        </div>

        <!-- postal code -->
        <div class="mt-4">
            <x-input-label for="postal_code" :value="__('postal code')" />
            <x-text-input id="postal_code" class="block mt-1 w-full" type="text" name="postal_code" :value="old('postal_code')" required autofocus autocomplete="postal_code" />
            <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
        </div>

        <!-- Store name -->
        <div class="mt-4">
            <x-input-label for="store_name" :value="__('store name')" />
            <x-text-input id="store_name" class="block mt-1 w-full" type="text" name="store_name" :value="old('store_name')" required autofocus autocomplete="store_name" />
            <x-input-error :messages="$errors->get('store_name')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <textarea class="form-control" id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" required autofocus autocomplete="description"></textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Store logo -->
        <div class="mt-4">
            <x-input-label for="logo_image" :value="__('store logo')" />
            <x-text-input id="logo_image" class="block mt-1 w-full" type="file" name="logo_image" :value="old('logo_image')" autofocus autocomplete="logo_image" />
            <x-input-error :messages="$errors->get('logo_image')" class="mt-2" />
        </div>

        <!-- Store cover -->
        <div class="mt-4">
            <x-input-label for="cover_image" :value="__('store cover')" />
            <x-text-input id="cover_image" class="block mt-1 w-full" type="file" name="cover_image" :value="old('cover_image')" autofocus autocomplete="cover_image" />
            <x-input-error :messages="$errors->get('cover_image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ml-4">
                {{ __('Register as merchant') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
@if (session('error'))
    <p class="text-red text-bold">
        {{ session('error') }}
    </p>
@endif

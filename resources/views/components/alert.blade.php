
{{-- this type variable comes from the alert component tag attribute type="success" --}}
@if (session()->has($type))
    <div class="alert alert-info">
        {{ session($type) }}
        <button class="close-alert" style="background:none;border:none;float:right;">x</button>
    </div>
@endif
{{--
@if (session()->has($type))
    <div class="alert alert-danger">
        {{ session($type) }}
    </div>
@endif

@if (session()->has($type))
    <div class="alert alert-info">
        {{ session($type) }}
    </div>
@endif --}}

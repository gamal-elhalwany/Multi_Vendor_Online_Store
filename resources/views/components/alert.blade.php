
{{-- this type variable comes from the alert component tag attribute type="success" --}}
@if (session()->has($type))
    <div class="alert alert-success">
        {{ session($type) }}
        <button class="close-alert" style="float:right;">x</button>
    </div>
@endif

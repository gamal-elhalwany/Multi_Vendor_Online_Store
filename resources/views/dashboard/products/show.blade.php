<h3>Here's the show product page, welcome {{ auth()->user()->name }}</h3>

@foreach($options as $option)
<div style="margin: 20px;">
    <strong>{{ $option->name }}:</strong>
    <span>{{ $option->value }}</span>
</div>
@endforeach

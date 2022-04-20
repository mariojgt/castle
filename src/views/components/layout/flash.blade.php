@if ($message = Session::get('success'))
    <flash-message type="success" message="{{ $message }}" />
@endif

@if ($message = Session::get('error'))
    <flash-message type="error" message="{{ $message }}" />
@endif

@if ($message = Session::get('info'))
    <flash-message type="info" message="{{ $message }}" />
@endif

{{-- Fields message --}}
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <flash-message type="error" message="{{ $error }}" />
    @endforeach
@endif

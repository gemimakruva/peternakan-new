@if ($message = session('success'))
    <x-adminlte-alert theme="success" icon="" dismissable>
        {{ $message }}
    </x-adminlte-alert>
@endif

@if ($message = session('warning'))
    <x-adminlte-alert theme="warning" icon="" dismissable>
        {{ $message }}
    </x-adminlte-alert>
@endif

@if ($message = session('danger'))
    <x-adminlte-alert theme="danger" icon="" dismissable>
        {{ $message }}
    </x-adminlte-alert>
@endif

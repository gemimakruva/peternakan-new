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

        {{-- Error validasi --}}
        @if ($errors->any())
            <ul class="mb-0">
                @foreach ($errors->all() as $msg)
                    <li>{{ $msg }}</li>
                @endforeach
            </ul>
        @endif
    </x-adminlte-alert>
@endif

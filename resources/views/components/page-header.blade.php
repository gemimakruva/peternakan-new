@props([
    'title',
    'breadcrumbs' => [],
    'actions' => null,
])

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <h1 class="mb-0">{{ $title }}</h1>
                @if($actions)
                    <div class="d-none d-sm-flex gap-1">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
        <div class="col-sm-6 d-none d-sm-block">
            @if(count($breadcrumbs) > 0)
                <ol class="breadcrumb float-sm-right mb-0">
                    @foreach($breadcrumbs as $label => $url)
                        @if($loop->last)
                            <li class="breadcrumb-item active">{{ $label }}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
                        @endif
                    @endforeach
                </ol>
            @endif
        </div>
    </div>
    @if($actions)
        <div class="d-sm-none mt-2">
            <div class="d-flex gap-2">
                {{ $actions }}
            </div>
        </div>
    @endif
</div>

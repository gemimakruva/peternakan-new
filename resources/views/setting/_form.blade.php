<div class="row">
    <div class="col-12 col-md-6">
        <x-adminlte-input name="title" label="Title" :value="@$data->title" />
    </div>
    <div class="col-12 col-md-6">
        <x-adminlte-input name="description" label="Description" :value="@$data->description" />
    </div>
</div>

<div class="d-flex flex-column flex-md-row gap-2">
    <x-adminlte-input-file
        name="sidebar_logo"
        label="Sidebar Logo"
        placeholder="Choose a file..."
        fgroup-class="flex-1"
    />
    @if (@$data->sidebar_logo_url)
        <div class="mx-100">
            <img src="{{ @$data->sidebar_logo_url }}" alt="Saved Logo" class="w-100">
        </div>
    @endif
</div>
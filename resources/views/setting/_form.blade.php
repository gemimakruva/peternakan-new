<x-adminlte-input
    name="title"
    label="Title"
    :value="@$data->title"
/>

<x-adminlte-input
    name="description"
    label="Description"
    :value="@$data->description"
/>

<div class="d-flex gap-2">
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
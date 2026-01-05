<x-adminlte-input
    name="name"
    label="Nama Role"
    type="text"
    placeholder="Masukkan nama Role..."
    :value="old('name', @$role->name)"
    igroup-size="md">
</x-adminlte-input>

<div class="form-group">
    <label for="permissions">Permissions</label>
    <div class="row">
        @foreach($permissions as $permission)
            <div class="col-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission-{{ $permission->id }}"
                        {{ isset($role) && $role->permissions->contains($permission) ? 'checked' : '' }}>
                    <label class="form-check-label" for="permission-{{ $permission->id }}">
                        {{ $permission->name }}
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
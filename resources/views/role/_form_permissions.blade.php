<div class="card">
    <div class="card-header">
        <h3 class="card-title">Permissions</h3>
    </div>
    <div class="card-body">
        @php
        $grouped = [];
        foreach($permissions as $permission) {
            $parts = explode('.', $permission->name);
            if(count($parts) >= 3) {
                $modul = ucwords(str_replace('-', ' ', $parts[0]));
                $category = ucwords(str_replace('-', ' ', $parts[1]));
                $perm = ucwords(str_replace('-', ' ', $parts[2]));
                $grouped[$modul][$category][] = ['permission' => $permission, 'label' => $perm];
            }
        }
        @endphp
        <ul class="nav nav-tabs" id="permissionTabs" role="tablist">
            @foreach($grouped as $modul => $categories)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ strtolower(str_replace(' ', '-', $modul)) }}-tab" data-toggle="tab" href="#{{ strtolower(str_replace(' ', '-', $modul)) }}" role="tab">{{ $modul }}</a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content" id="permissionTabsContent">
            @foreach($grouped as $modul => $categories)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ strtolower(str_replace(' ', '-', $modul)) }}" role="tabpanel">
                    <div class="row mt-3">
                        @foreach($categories as $category => $perms)
                            <div class="col-6 col-md-3">
                                <div class="card">
                                    <div class="card-header p-2">
                                        <h4 class="lead mb-0">{{ $category }}</h4>
                                    </div>
                                    <div class="card-body p-1">
                                        <ul class="list-group list-group-flush">
                                            @foreach($perms as $item)
                                                <li class="list-group-item p-1">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item['permission']->id }}" id="permission-{{ $item['permission']->id }}"
                                                            {{ isset($role) && $role->permissions->contains($item['permission']) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="permission-{{ $item['permission']->id }}">
                                                            {{ $item['label'] }}
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-md-6">
        <x-adminlte-input name="name" label="Nama" type="text" placeholder="Masukkan nama..." :value="old('name', @$user->name)" igroup-size="md" />
    </div>
    <div class="col-12 col-md-6">
        <x-adminlte-input name="email" label="Email" type="email" placeholder="Masukkan email..." :value="old('email', @$user->email)" igroup-size="md" />
    </div>
    <div class="col-12 col-md-6">
        @if(isset($user))
            <x-adminlte-input name="password" label="Password (Kosongkan jika tidak ingin mengubah)" type="password" placeholder="Masukkan password baru..." igroup-size="md" />
        @else
            <x-adminlte-input name="password" label="Password" type="password" placeholder="Masukkan password..." igroup-size="md" />
        @endif
    </div>
    <div class="col-12 col-md-6">
        <x-adminlte-input name="password_confirmation" label="Konfirmasi Password" type="password" placeholder="Konfirmasi password..." igroup-size="md" />
    </div>
</div>
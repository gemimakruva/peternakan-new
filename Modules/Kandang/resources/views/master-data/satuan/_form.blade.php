<x-adminlte-input
    label="Nama"
    name="nama"
    :value="old('nama', @$data->nama)"
/>

<x-adminlte-input
    label="Standar Satuan Terkecil"
    name="standar_terkecil_satuan"
    :value="old('standar_terkecil_satuan', @$data->standar_terkecil_satuan)"
/>
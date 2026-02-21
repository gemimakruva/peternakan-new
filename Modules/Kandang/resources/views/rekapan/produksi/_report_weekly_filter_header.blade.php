@push('js')
    <script src="{{ Vite::asset('resources/js/print-charts.js') }}" defer></script>
@endpush

<h2 class="h4">Filter</h2>
<div class="card">
    <div class="card-body">
        <form action="{{ route($routeName) }}" class="row">
            <x-adminlte-select
                name="kandang_id"
                label="Kandang"
                fgroup-class="mb-0 col-12 col-lg-3"
            >
                <x-adminlte-options
                    :options="$listKandang"
                    empty-option="Semua Kandang"
                    :selected="@$kandang?->id"
                />
            </x-adminlte-select>

            <x-adminlte-input
                name="umur"
                label="Umur Ayam"
                :value="$umur"
                fgroup-class="mb-0 col-12 col-lg-3"
            />

            <div class="col-12 col-lg-3 d-flex gap-2 justify-content-end justify-content-lg-start align-items-end">
                <button class="btn btn-primary mt-2">
                    <i class="fas fa-search"></i>
                </button>
                <button type="button" class="btn btn-danger" onclick="downloadPdf()">
                    <i class="fas fa-file-pdf"></i>
                </button>
            </div>
        </form>
    </div>
</div>

@push('js')
<script>
function downloadPdf() {
    // Get chart images
    const chartImages = PrintCharts.getImages();
    
    // Create form to submit to server
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `{{ route('rekapan-produksi.report.weekly.pdf', ['client-side' => true]) }}`;
    form.target = '_blank';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);
    
    // Add filter data
    const kandangInput = document.createElement('input');
    kandangInput.type = 'hidden';
    kandangInput.name = 'kandang_id';
    kandangInput.value = '{{ @$kandang?->id ?? '' }}';
    form.appendChild(kandangInput);
    
    const umurInput = document.createElement('input');
    umurInput.type = 'hidden';
    umurInput.name = 'umur';
    umurInput.value = '{{ $umur }}';
    form.appendChild(umurInput);
    
    // Add chart images as JSON
    const chartsInput = document.createElement('input');
    chartsInput.type = 'hidden';
    chartsInput.name = 'chart_images';
    chartsInput.value = JSON.stringify(chartImages);
    form.appendChild(chartsInput);
    
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);
}
</script>
@endpush
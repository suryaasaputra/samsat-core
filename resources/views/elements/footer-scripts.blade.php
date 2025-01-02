@if (!empty(config('dz.public.global.js.top')))
    @foreach (config('dz.public.global.js.top') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
@endif

@php
    // $action = $controller.'_'.$action;
    $action = isset($action) ? $action : '';
@endphp

@if (!empty(config('dz.public.pagelevel.js.' . $action)))
    @foreach (config('dz.public.pagelevel.js.' . $action) as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
@endif

@if (!empty(config('dz.public.global.js.bottom')))
    @foreach (config('dz.public.global.js.bottom') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach
@endif

@if (session('berhasil'))
    <script type="text/javascript">
        $(function() {
            toastr.success("{{ session('info') }}");
            toastr.options.progressBar = true;
            toastr.options.closeButton = true;
        });
    </script>
@endif

@if (session('gagal'))
    <script type="text/javascript">
        $(function() {
            toastr.error("{{ session('gagal') }}");
            toastr.options.progressBar = true;
            toastr.options.closeButton = true;
        });
    </script>
@endif

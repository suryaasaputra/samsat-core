@if (session('success'))
    <div class="p-4">
        <div class="alert alert-success solid  alert-dismissible fade show p-6">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <polyline points="9 11 12 14 22 4"></polyline>
                <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
            </svg>
            <strong>Berhasil!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
    </div>
@endif
@if (session('error'))
    <div class="p-4">
        <div class="alert alert-danger solid  alert-dismissible fade show ">
            <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                <line x1="15" y1="9" x2="9" y2="15"></line>
                <line x1="9" y1="9" x2="15" y2="15"></line>
            </svg>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
    </div>
@endif
@if (session('warning'))
    <div class="p-4">
        <div class="alert alert-warning solid  alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z">
                </path>
                <line x1="12" y1="9" x2="12" y2="13"></line>
                <line x1="12" y1="17" x2="12.01" y2="17"></line>
            </svg>
            <strong>Warning!</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
    </div>
@endif
@if (session('info'))
    <div class="p-4">
        <div class="alert alert-info solid  alert-dismissible fade show">
            <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none"
                stroke-linecap="round" stroke-linejoin="round" class="me-2">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="16" x2="12" y2="12"></line>
                <line x1="12" y1="8" x2="12.01" y2="8"></line>
            </svg>
            <strong>Info!</strong> {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
            </button>
        </div>
    </div>
@endif

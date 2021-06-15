@if ($status = session('status_success'))
    <div class="alert alert-success" role="alert">{{ $status }}</div>
@endif
@if ($status = session('status_danger'))
    <div class="alert alert-danger" role="alert">{{ $status }}</div>
@endif
@if ($status = session('status_warning'))
    <div class="alert alert-warning" role="alert">{{ $status }}</div>
@endif
@if ($status = session('status_info'))
    <div class="alert alert-info" role="alert">{{ $status }}</div>
@endif
@if ($status = session('status_primary'))
    <div class="alert alert-primary" role="alert">{{ $status }}</div>
@endif
@if ($status = session('status_secondary'))
    <div class="alert alert-secondary" role="alert">{{ $status }}</div>
@endif

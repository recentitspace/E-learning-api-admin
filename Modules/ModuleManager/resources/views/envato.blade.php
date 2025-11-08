@extends('modulemanager::layouts.master')

@section('title', 'Envato Marketplace')

@section('content')
    @if(!$envatoToken)
        <div class="alert alert-warning">
            <h4>Envato API Token Not Configured</h4>
            <p>To access your purchases and install modules from Envato, you need to configure your Envato API token in the settings.</p>
            <a href="{{ route('module-manager.settings') }}" class="btn btn-primary">Go to Settings</a>
        </div>
    @else
        <div class="card mb-4">
            <div class="card-header">
                <h5>Install from Envato Purchase Code</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('module-manager.install-from-envato') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="purchase_code" class="form-label">Purchase Code</label>
                        <input type="text" class="form-control" id="purchase_code" name="purchase_code" required placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx">
                        @error('purchase_code')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter your item purchase code from Envato.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Verify & Install</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Search Envato Marketplace</h5>
            </div>
            <div class="card-body">
                <form id="searchForm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="query" class="form-label">Search Term</label>
                                <input type="text" class="form-control" id="query" name="query" placeholder="e.g. Laravel modules">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category" class="form-label">Category</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">All Categories</option>
                                    <option value="php-scripts">PHP Scripts</option>
                                    <option value="plugins">Plugins</option>
                                    <option value="laravel">Laravel</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <div id="searchResults" class="mt-4"></div>

        @if($hasPurchases)
            <h3 class="mt-4">Your Envato Purchases</h3>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($purchases as $purchase)
                    <div class="col">
                        <div class="card h-100">
                            @if(isset($purchase['item']['previews']['icon_with_landscape_preview']['icon_url']))
                                <img src="{{ $purchase['item']['previews']['icon_with_landscape_preview']['icon_url'] }}" class="card-img-top" alt="{{ $purchase['item']['name'] }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $purchase['item']['name'] }}</h5>
                                <p class="card-text">
                                    <span class="badge bg-info">{{ $purchase['item']['site'] }}</span>
                                    <span class="badge bg-secondary">v{{ $purchase['item']['version'] }}</span>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">Purchased: {{ \Carbon\Carbon::parse($purchase['purchased_at'])->format('M d, Y') }}</small>
                                </p>
                            </div>
                            <div class="card-footer">
                                <form action="{{ route('module-manager.install-from-envato') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="purchase_code" value="{{ $purchase['code'] }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Install</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    @endif
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchForm = document.getElementById('searchForm');
        const searchResults = document.getElementById('searchResults');
        
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const query = document.getElementById('query').value;
            const category = document.getElementById('category').value;
            
            searchResults.innerHTML = '<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
            
            fetch('{{ route('module-manager.search-envato') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ query, category })
            })
            .then(response => response.json())
            .then(data => {
                let html = '';
                
                if (data.matches && data.matches.length > 0) {
                    html = '<h3>Search Results</h3>';
                    html += '<div class="row row-cols-1 row-cols-md-3 g-4">';
                    
                    data.matches.forEach(item => {
                        html += `
                            <div class="col">
                                <div class="card h-100">
                                    ${item.previews?.icon_with_landscape_preview?.icon_url ? 
                                        `<img src="${item.previews.icon_with_landscape_preview.icon_url}" class="card-img-top" alt="${item.name}">` : ''}
                                    <div class="card-body">
                                        <h5 class="card-title">${item.name}</h5>
                                        <p class="card-text">
                                            <span class="badge bg-info">${item.site}</span>
                                            <span class="badge bg-secondary">v${item.version}</span>
                                            <span class="badge bg-success">$${item.price_cents / 100}</span>
                                        </p>
                                        <p class="card-text small">${item.description ? item.description.substring(0, 100) + '...' : ''}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="${item.url}" target="_blank" class="btn btn-primary btn-sm">View on Envato</a>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                } else {
                    html = '<div class="alert alert-info">No items found matching your search criteria.</div>';
                }
                
                searchResults.innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                searchResults.innerHTML = '<div class="alert alert-danger">An error occurred while searching. Please try again.</div>';
            });
        });
    });
</script>
@endsection

                                    
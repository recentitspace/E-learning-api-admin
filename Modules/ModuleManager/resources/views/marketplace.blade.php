@extends('modulemanager::layouts.master')

@section('title', 'Module Marketplace')

@section('content')
    @if(!config('module_manager.marketplace_api_url'))
        <div class="alert alert-warning">
            <h4>Marketplace API URL Not Configured</h4>
            <p>To access the module marketplace, you need to configure the marketplace API URL in the settings.</p>
            <a href="{{ route('module-manager.settings') }}" class="btn btn-primary">Go to Settings</a>
        </div>
    @else
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @forelse($availableModules as $module)
                <div class="col">
                    <div class="card h-100">
                        @if(isset($module['thumbnail']))
                            <img src="{{ $module['thumbnail'] }}" class="card-img-top" alt="{{ $module['name'] }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $module['name'] }}</h5>
                            <p class="card-text">
                                <span class="badge bg-secondary">v{{ $module['version'] }}</span>
                                @if(isset($module['price']))
                                    <span class="badge bg-success">${{ $module['price'] }}</span>
                                @else
                                    <span class="badge bg-primary">Free</span>
                                @endif
                            </p>
                            <p class="card-text">{{ $module['description'] ?? 'No description available' }}</p>
                            <p class="card-text">
                                <small class="text-muted">
                                    Author: {{ $module['author'] ?? 'Unknown' }}
                                </small>
                            </p>
                        </div>
                        <div class="card-footer">
                            @if(isset($module['download_url']))
                                <form action="{{ route('module-manager.install-from-url') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="download_url" value="{{ $module['download_url'] }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Install</button>
                                </form>
                            @elseif(isset($module['purchase_url']))
                                <a href="{{ $module['purchase_url'] }}" target="_blank" class="btn btn-success btn-sm">Purchase</a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info">
                        No modules available in the marketplace at the moment.
                    </div>
                </div>
            @endforelse
        </div>
    @endif
@endsection
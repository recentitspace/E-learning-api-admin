@extends('modulemanager::layouts.master')

@section('title', 'Module Manager Settings')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('module-manager.save-settings') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="envato_api_token" class="form-label">Envato API Token</label>
                    <input type="password" class="form-control" id="envato_api_token" name="envato_api_token" value="{{ $settings['envato_api_token'] ?? '' }}">
                    <div class="form-text">
                        You can generate an API token from your <a href="https://build.envato.com/create-token/" target="_blank">Envato account</a>.<br>
                        Required scopes: <code>purchase:verify</code>, <code>purchase:list</code>
                    </div>
                    @error('envato_api_token')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="marketplace_api_url" class="form-label">Marketplace API URL</label>
                    <input type="url" class="form-control" id="marketplace_api_url" name="marketplace_api_url" value="{{ $settings['marketplace_api_url'] ?? '' }}">
                    <div class="form-text">URL to your module marketplace API.</div>
                    @error('marketplace_api_url')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="run_seeders" name="run_seeders" value="1" {{ ($settings['run_seeders'] ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="run_seeders">Run database seeders after module installation</label>
                </div>
                
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="enable_auto_updates" name="enable_auto_updates" value="1" {{ ($settings['enable_auto_updates'] ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="enable_auto_updates">Enable automatic update checking</label>
                </div>
                
                <div class="mb-3">
                    <label for="license_verification_interval" class="form-label">License verification interval (days)</label>
                    <input type="number" class="form-control" id="license_verification_interval" name="license_verification_interval" value="{{ $settings['license_verification_interval'] ?? 30 }}" min="1" max="365">
                </div>
                
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h5>Verify Module Licenses</h5>
        </div>
        <div class="card-body">
            <p>Run a license verification check for all installed modules that have purchase codes.</p>
            <form action="{{ route('module-manager.verify-licenses') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Verify Licenses</button>
            </form>
        </div>
    </div>
@endsection
@extends('modulemanager::layouts.master')

@section('title', 'Module Updates')

@section('content')
    <div class="mb-4">
        <a href="{{ route('module-manager.updates') }}" class="btn btn-primary">Check for Updates</a>
    </div>

    @if(empty($updates))
        <div class="alert alert-success">
            <h4>All modules are up to date!</h4>
            <p>No updates are available for your installed modules at this time.</p>
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Module</th>
                        <th>Current Version</th>
                        <th>New Version</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($updates as $module => $update)
                        <tr>
                            <td>{{ $module }}</td>
                            <td>{{ $update['current_version'] }}</td>
                            <td>{{ $update['new_version'] }}</td>
                            <td>{{ $update['description'] ?? 'No update description available' }}</td>
                            <td>
                                <form action="{{ route('module-manager.update', $module) }}" method="POST" onsubmit="return confirm('Are you sure you want to update this module? It is recommended to backup your database before updating.');">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
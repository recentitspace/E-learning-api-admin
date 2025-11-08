@extends('modulemanager::layouts.master')

@section('title', 'Installed Modules')

@section('content')
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Version</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($modules as $module)
                    <tr>
                        <td>{{ $module->getName() }}</td>
                        <td>{{ $module->getDescription() }}</td>
                        <td>{{ $module->get('version', 'Unknown') }}</td>
                        <td>{{ $module->get('author', 'Unknown') }}</td>
                        <td>
                            @if($module->isEnabled())
                                <span class="badge bg-success">Enabled</span>
                            @else
                                <span class="badge bg-danger">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                @if($module->isEnabled())
                                    <form action="{{ route('module-manager.disable', $module->getName()) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Disable</button>
                                    </form>
                                @else
                                    <form action="{{ route('module-manager.enable', $module->getName()) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">Enable</button>
                                    </form>
                                @endif
                                <form action="{{ route('module-manager.uninstall', $module->getName()) }}" method="POST" onsubmit="return confirm('Are you sure you want to uninstall this module?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Uninstall</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No modules installed yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

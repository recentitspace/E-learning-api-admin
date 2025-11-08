@section('title', 'Module Management Dashboard')

<x-dashboard-layout>
    <x-slot:title>{{ translate('Dashboard') }}</x-slot:title>
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-full card">
            <div class="grid grid-cols-12 gap-4 h-full">
                <!-- Total Module Card -->
                <div class="col-span-full md:col-span-4 lg:col-span-3 px-5 py-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Total Modules') }}
                        </h6>
                    </div>
                    <div class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="shrink-0">
                            <div class="flex items-center gap-2">
                                <div class="card-title text-2xl">
                                    <span class="counter-value" data-value="{{ count($installedModules) }}">{{ count($installedModules) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Enabled Modules Card -->
                <div class="col-span-full md:col-span-4 lg:col-span-3 px-5 py-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Enabled Modules') }}
                        </h6>
                    </div>
                    <div class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="shrink-0">
                            <div class="flex items-center gap-2">
                                <div class="card-title text-2xl">
                                    <span class="counter-value" data-value="{{ count($enabledModules) }}">{{ count($enabledModules) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Disabled Module Card -->
                <div class="col-span-full md:col-span-4 lg:col-span-3 px-5 py-4 dk-border-one rounded-xl h-full dk-theme-card-square">
                    <div class="flex-center-between">
                        <h6 class="leading-none text-gray-500 dark:text-dark-text font-semibold">
                            {{ translate('Disabled Modules') }}
                        </h6>
                    </div>
                    <div class="pt-3 bg-[url('../../assets/images/card/pattern.png')] dark:bg-[url('../../assets/images/card/pattern-dark.png')] bg-no-repeat bg-100% flex gap-4 mt-3">
                        <div class="shrink-0">
                            <div class="flex items-center gap-2">
                                <div class="card-title text-2xl">
                                    <span class="counter-value" data-value="{{ count($disabledModules) }}">{{ count($disabledModules) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-full card">
            <div class="flex-center-between py-2">
                <h6 class="card-title">{{ translate('Recently Installed Modules') }}</h6>
                <button class="btn b-solid btn-primary-solid" data-modal-id="install-module">{{ translate('Add New Module') }}</button>
            </div>
            <div class="overflow-x-auto mt-5">
                <table class="table-auto border-collapse w-full whitespace-nowrap text-left text-gray-500 dark:text-dark-text font-medium">
                    <thead class="text-heading dark:text-dark-text">
                        <tr>
                            <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('Name') }}</th>
                            <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square w-[500px] min-w-[300px]">{{ translate('Description') }}</th>
                            <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('Version') }}</th>
                            <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square">{{ translate('Status') }}</th>
                            <th class="p-6 py-4 bg-primary-200 dark:bg-dark-card-two first:rounded-l-lg last:rounded-r-lg dk-theme-card-square w-10">{{ translate('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-dark-border-three">
                        @forelse($installedModules as $module)
                            <tr>
                                <td class="p-6 py-4">{{ $module->getName() }}</td>
                                <td class="p-6 py-4">
                                    <p class="block text-wrap">{{ $module->getDescription() }}</p>
                                </td>
                                <td class="p-6 py-4">{{ $module->get('version', 'Unknown') }}</td>
                                <td class="p-6 py-4">
                                    @if($module->isEnabled())
                                        <span class="badge badge-success-solid b-solid">{{ translate('Enabled') }}</span>
                                    @else
                                        <span class="badge badge-danger-solid b-solid">{{ translate('Disabled') }}</span>
                                    @endif
                                </td>
                                <td class="p-6 py-4">
                                    <div class="flex items-center gap-2">
                                        @if($module->get('type', 'module') !== 'core')
                                            @if($module->isEnabled())
                                                <form action="{{ route('module-manager.disable', $module->getName()) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn b-outline btn-danger-outline btn-sm">{{ translate('Disable') }}</button>
                                                </form>
                                            @else
                                                <form action="{{ route('module-manager.enable', $module->getName()) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn b-outline btn-success-outline btn-sm">{{ translate('Enable') }}</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('module-manager.uninstall', $module->getName()) }}" method="POST" onsubmit="return confirm('Are you sure you want to uninstall this module?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn b-outline btn-info-outline btn-sm">{{ translate('Uninstall') }}</button>
                                            </form>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <td colspan="100%" class="w-full">
                                <div class="flex-center text-center h-[200px]">{{ translate('No modules installed yet') }}</div>
                            </td>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Module Installation Modal -->
    <div id="install-module" class="fixed inset-0 z-modal flex-center items-start bg-black bg-opacity-50 modal !hidden">
        <div class="modal-content bg-white rounded-lg shadow-lg w-full max-w-screen-sm transform transition-all duration-300 m-4 mt-20 opacity-0 -translate-y-10">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-xl font-semibold">{{ translate('Install New Module') }}</h2>
                <button type="button" class="absolute top-3 end-2.5 text-gray-500 dark:text-dark-text hover:bg-gray-200 dark:hover:bg-dark-icon rounded-lg size-8 flex-center close-modal-btn">
                    <i class="ri-close-line text-inherit text-xl leading-none"></i>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="p-4 max-h-[80vh] overflow-auto">
                <div class="dashkit-tab" id="deliveryStatusTab">
                    <div class="flex items-center bg-white dark:bg-dark-card-two shadow-md rounded-md divide-x divide-input-border dark:divide-dark-border-two dk-theme-card-square">
                        <button class="dashkit-tab-btn grow shrink-0 leading-none p-4 text-gray-500 dark:text-dark-text-two font-semibold hover:text-primary [&.active]:text-primary active" id="install-by-upload">{{ translate('By Upload') }}</button>
                        <button class="dashkit-tab-btn grow shrink-0 leading-none p-4 text-gray-500 dark:text-dark-text-two font-semibold hover:text-primary [&.active]:text-primary" id="install-by-url">{{ translate('By URL') }}</button>
                    </div>
                </div>
                <div class="dashkit-tab-content mt-10 *:hidden" id="deliveryStatusTabContent">
                    <!-- Install By Upload -->
                    <div class="dashkit-tab-pane !block" data-tab="install-by-upload">
                        <form action="{{ route('module-manager.upload') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="module_zip" class="form-label">{{ translate('Module Zip File') }}</label>
                                <input type="file" accept=".zip" id="module_zip" class="border border-dashed border-primary-200 rounded-md hover:border-primary cursor-pointer file:cursor-pointer block w-full text-sm text-gray-500 file:mr-4 file:py-5 file:px-4 file:rounded-none file:border-0 file:text-sm file:font-semibold file:bg-primary-200 file:text-primary hover:file:bg-primary hover:file:text-white file:duration-300 duration-300" name="module_zip" required>
                                @error('module_zip')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn b-light btn-light-light">{{ translate('Install') }}</button>
                            </div>
                        </form>
                    </div>
                    <!-- Install By URL -->
                    <div class="dashkit-tab-pane" data-tab="install-by-url">
                        <form action="{{ route('module-manager.install-from-url') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="download_url" class="form-label">{{ translate('Download URL') }}</label>
                                <div class="flex">
                                    <span class="form-input-group !rounded-r-none input-icon bg-[#F8F8F8] dark:bg-dark-card !text-gray-900 dark:text-dark-text">
                                        <i class="ri-links-fill text-inherit"></i>
                                    </span>
                                    <input type="url" id="download_url" class="form-input !rounded-l-none" name="download_url" placeholder="https://example.com/module.zip" required>
                                </div>
                                @error('download_url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="btn b-light btn-light-light">{{ translate('Install') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-dashboard-layout>

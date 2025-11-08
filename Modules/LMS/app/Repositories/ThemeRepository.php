<?php

namespace Modules\LMS\Repositories;

use Illuminate\Support\Facades\File;
use Modules\LMS\Models\Theme\Theme;
use Illuminate\Support\Str;

class ThemeRepository extends BaseRepository
{
    protected static $model = Theme::class;

    protected static $exactSearchFields = [
        'slug',
        'uuid',
    ];

    protected static $excludedFields = [
        'save' => [
            '_token',
        ],
        'update' => [
            '_token',
        ]
    ];

    protected static $rules = [
        'save' => [
            'name' => 'required',
            'slug' => 'required|unique:themes',
        ],
        'update' => [
            'name' => 'required',
        ],
    ];

    /**
     * @param  array  $data
     */
    public static function save($data): array
    {
        $data['slug'] = ! empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['uuid'] = Str::uuid()->toString();

        return parent::save($data);
    }

    /**
     * @param  int  $id
     * @param  array  $data
     */
    public static function update($id, $data): array
    {
        $id = (int) $id;
        $data['slug'] = ! empty($data['slug']) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $theme = static::$model::find($id);
        static::$rules['update']['slug'] = 'required|unique:themes,slug,' . $id;

        if ($theme) {
            $data['active'] = 1;
        }

        $response = parent::update($id, $data);

        if ($response['status'] === 'success') {
            $themes = static::$model::all();

            foreach ($themes as $theme) {
                if ($theme->id === $id) {
                    continue;
                }

                $theme->active = 0;
                $theme->save();
            }
        }

        return $response;
    }

    public function getInstalledThemes()
    {

        $themeDir = system_path('LMS', 'resources/themes');
        $directories = File::directories($themeDir);
        $themes = [];

        foreach ($directories as $directory) {

            $baseName =  basename($directory);
            $configPath = $directory . '/theme.json';

            if (File::exists($configPath)) {
                $config = json_decode(File::get($configPath), true);

                if (! isset($config['name']) || empty($config['name'])) {
                    $config['name'] = $baseName;
                }

                if (! isset($config['slug']) || empty($config['slug'])) {
                    $config['slug'] = $config['name'];
                }

                $config['slug'] = Str::slug($config['slug']);

                if (! isset($config['thumbnail']) || empty($config['thumbnail'])) {
                    $thumbnail = $directory . '/thumbnail.png';

                    if (!$thumbnail && file_exists($directory . '/thumbnail.jpg')) {
                        $thumbnail = $directory . '/thumbnail.jpg';
                    }

                    if (! $thumbnail && file_exists($directory . '/thumbnail.jpeg')) {
                        $thumbnail = $directory . '/thumbnail.jpeg';
                    }

                    $config['thumbnail'] = $thumbnail;
                }

                if (! isset($config['preview']) || empty($config['preview'])) {
                    $preview = $directory . '/preview.png';

                    if (!$preview && file_exists($directory . '/preview.jpg')) {
                        $preview = $directory . '/preview.jpg';
                    }

                    if (! $preview && file_exists($directory . '/preview.jpeg')) {
                        $preview = $directory . '/preview.jpeg';
                    }

                    $config['preview'] = $preview;
                }

                $themes[] = $config;
            }
        }

        if (count($themes) > 0) {

            $installedThemes = Theme::all();
            $filteredThemes = [];

            foreach ($themes as &$theme) {

                if (! $theme['slug']) {
                    continue;
                }

                $theme['is_installed'] = false;
                $theme['is_activated'] = false;

                foreach ($installedThemes as $key => $installedTheme) {
                    if ($theme['slug'] === $installedTheme->slug) {
                        $theme['id'] = $installedTheme->id;
                        $theme['is_installed'] = true;
                        $theme['is_activated'] = $installedTheme->active === 1;
                        unset($installedTheme[$key]);
                    }
                }

                if ($theme['is_activated']) {
                    array_unshift($filteredThemes, $theme);
                    continue;
                }

                $filteredThemes[] = $theme;
            }

            unset($theme);
        }

        return [
            'success' => true,
            'themes' => $filteredThemes,
        ];
    }
}

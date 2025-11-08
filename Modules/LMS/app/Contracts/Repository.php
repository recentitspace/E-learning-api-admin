<?php

namespace Modules\LMS\Contracts;

/**
 * Repository contract
 *
 * @author  Md Abu Ahsan Basir <abasir@nobilisgroup.com>
 */
interface Repository
{
    /**
     * Get posts.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function all($options = [], $relations = []): array;

    /**
     * Get posts.
     *
     * @param  array  $options
     * @param  array  $relations
     */
    public static function get($options = [], $relations = []): array;

    /**
     * Get a post.
     *
     * @param  int  $id
     * @param  array  $realtions
     */
    public static function first($id, $realtions = []): array;

    /**
     * Search posts.
     *
     * @param  int  $id
     * @param  array  $realtions
     * @param  array  $options
     */
    public static function search($id, $realtions = [], $options = []): array;

    /**
     * Create a post.
     *
     * @param  array|object  $data
     */
    public static function save($data): array;

    /**
     * Update a post.
     *
     * @param  int  $id
     * @param  array|object  $data
     */
    public static function update($id, $data): array;

    /**
     * Delete a post.
     *
     * @param  int  $id
     */
    public static function delete($id): array;
}

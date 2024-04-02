<?php

/*
 * This file is part of afrux/top-posters-widget.
 *
 * Copyright (c) 2021 Sami Mazouz.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Afrux\TopPosters;

use Afrux\ForumWidgets\SafeCacheRepositoryAdapter;
use Carbon\Carbon;
use Flarum\Post\CommentPost;
use Flarum\Settings\SettingsRepositoryInterface;

class UserRepository
{
    /**
     * @var SafeCacheRepositoryAdapter
     */
    private $cache;

     /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    public function __construct(SafeCacheRepositoryAdapter $cache, SettingsRepositoryInterface $settings)
    {
        $this->cache = $cache;
        $this->settings = $settings;
    }


    public function getTopPosters(): array
    {
        $excludedUsernames = explode(';', $this->settings->get('afrux-top-posters-widget.excluded_usernames'));

        return CommentPost::query()
            ->with('user')
            ->whereHas('user', function ($query) use ($excludedUsernames) {
                if (!empty($excludedUsernames)) {
                    $query->whereNotIn('username', $excludedUsernames);
                }
            })
            ->selectRaw('user_id, count(id) as count')
            ->where('created_at', '>', Carbon::now()->subMonth())
            ->groupBy('user_id')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->mapWithKeys(function ($post) {
                return [$post->user_id => (int) $post->count];
            })
            ->toArray();
    }
}

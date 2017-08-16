<?php
/**
 * Created by PhpStorm.
 * User: Jiangzhiheng
 * Date: 2017/5/2
 * Time: 下午3:57
 */
namespace  LWJ\Commodity\Controllers\Services\Search;

use Cache;
use CommoditySearch;
use Illuminate\Support\Collection;

class Search
{
    const SEARCH_CACHE_KEY = 'SEARCH_CACHE_KEY';

    /**
     * 获取搜索项的详情
     *
     * @param int $id
     * @return null|\stdClass
     */
    public static function getSearch(int $id)
    {
        /** @var Collection $searches */
        $searches = Cache::rememberForever(static::SEARCH_CACHE_KEY, function () {
            return static::getSearches();
        });

        // 通过ID获取值
        $search = static::first($searches, $id);

        // 如果没有搜索到search,重新刷新缓存
        if (! is_null($search)) {
            return $search;
        }

        Cache::forever(static::SEARCH_CACHE_KEY, static::getSearches());
        return static::first($searches, $id);
    }

    /**
     * 获取搜索项集合
     *
     * @return Collection
     */
    public static function getSearches()
    {
        return CommoditySearch::all();
    }

    /**
     * @param Collection $searches
     * @param int $id
     * @return \stdClass|null
     */
    protected static function first($searches, $id)
    {
        return $searches->first(function ($item) use ($id) {
            return $item->id == $id;
        });
    }
}
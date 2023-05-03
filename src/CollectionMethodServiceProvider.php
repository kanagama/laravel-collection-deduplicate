<?php

namespace Kanagama\LaravelCollectionDeduplicate;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;

/**
 * @author k.nagama <k.nagama@gmail.com>
 */
class CollectionMethodServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $items;

    /**
     *
     */
    public function boot(): void
    {
        Collection::macro('deduplicate', function (?string $algo = 'sha512'): Collection {
            // 指定されたアルゴリズムが使えるかどうかをチェック
            if (!in_array($algo, hash_algos(), true)) {
                throw new InvalidArgumentException('Invalid algorithm');
            }

            $hashTables = [];
            foreach ($this->items as $key => $item) {
                $hash = hash($algo, serialize($item));
                // 既に同じ hash が存在していたら削除する
                if (isset($hashTables[$hash])) {
                    unset($this->items[$key]);
                    continue;
                }

                $hashTables[$hash] = true;
            }

            return new Collection($this->items);
        });
    }
}

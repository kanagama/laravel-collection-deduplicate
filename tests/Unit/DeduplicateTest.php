<?php

namespace Kanagama\LaravelCollectionDeduplicate\Tests\Unit;

use Illuminate\Support\Collection;
use Kanagama\LaravelCollectionDeduplicate\Tests\TestCase;
use Kanagama\LaravelCollectionDeduplicate\Tests\ValueObjects\User;

/**
 * @author k-nagama <k.nagama0632@gmail.com>
 */
class DeduplicateTest extends TestCase
{
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function 数値重複なし()
    {
        $limit = 100000;

        $collection = new Collection(range(1, $limit));
        $this->assertSame($collection->count(), $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function 数値重複あり()
    {
        $limit = 10;

        $items = range(1, $limit);

        $items[] = 1;
        $items[] = 1;
        $items[] = 1;

        $collection = new Collection($items);
        // 配列の要素数と一致する
        $this->assertSame(count($items), $collection->count());
        // 数値の重複が排除されている
        $this->assertSame($limit, $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function 文字列重複なし()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';

        $collection = new Collection(str_split($alphabet));
        $this->assertSame($collection->count(), $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function 文字列重複あり()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $collection = new Collection(str_split($alphabet . $alphabet));
        $this->assertSame((strlen($alphabet) * 2), $collection->count());
        // 文字列の重複が排除されている
        $this->assertSame(strlen($alphabet), $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function 配列重複なし()
    {
        $limit = 100;

        $array = [];
        for ($i = 1; $i <= $limit; $i++) {
            $array[] = [
                $i,
            ];
        }

        $collection = new Collection($array);
        $this->assertSame($collection->count(), $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function 配列重複あり()
    {
        $limit = 100;

        $array = [];
        for ($i = 1; $i <= $limit; $i++) {
            $array[] = [
                $i,
            ];
        }
        for ($i = 1; $i <= $limit; $i++) {
            $array[] = [
                $i,
            ];
        }

        $collection = new Collection($array);
        $this->assertSame(($limit * 2), $collection->count());
        // 配列の重複が排除されている
        $this->assertSame($limit, $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function オブジェクト重複なし()
    {
        $collection = new Collection([
            new User([
                'id' => 1,
                'name' => 'k.nagama',
                'tel' => '090-9999-9999',
                'mail' => 'k.nagama0632@gmail.com',
            ]),
            new User([
                'id' => 2,
                'name' => 'e.ikeda',
                'tel' => '080-8888-8888',
                'mail' => 'e.ikeda@example.com',
            ]),
            new User([
                'id' => 3,
                'name' => 'm.nishiuchi',
                'tel' => '070-7777-7777',
                'mail' => 'm.nishiuchi@example.com',
            ]),
        ]);
        $this->assertSame($collection->count(), $collection->deduplicate()->count());
    }

    /**
     * @test
     */
    public function オブジェクト重複あり()
    {
        $collection = new Collection([
            new User([
                'id' => 1,
                'name' => 'k.nagama',
                'tel' => '090-9999-9999',
                'mail' => 'k.nagama0632@gmail.com',
            ]),
            new User([
                'id' => 2,
                'name' => 'e.ikeda',
                'tel' => '080-8888-8888',
                'mail' => 'e.ikeda@example.com',
            ]),
            new User([
                'id' => 3,
                'name' => 'm.nishiuchi',
                'tel' => '070-7777-7777',
                'mail' => 'm.nishiuchi@example.com',
            ]),
            new User([
                'id' => 1,
                'name' => 'k.nagama',
                'tel' => '090-9999-9999',
                'mail' => 'k.nagama0632@gmail.com',
            ]),
            new User([
                'id' => 1,
                'name' => 'k.nagama',
                'tel' => '090-9999-9999',
                'mail' => 'k.nagama0632@gmail.com',
            ]),
        ]);
        $this->assertSame(5, $collection->count());
        // 重複が排除されている
        $this->assertSame(3, $collection->deduplicate()->count());
    }
}

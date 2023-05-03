# laravel-collection-deduplicate

## 機能概要

php 7.4 以上
Laraevel 8.0 以上

Collection クラスの重複を削除するメソッド deduplicate() を追加します。

## 既存メソッド unique() と uniqueStrict()

コレクションの重複を排除するメソッドとして、既に [unique()](https://readouble.com/laravel/10.x/ja/collections.html#method-unique) や [uniqueStrict()](https://readouble.com/laravel/10.x/ja/collections.html#method-uniquestrict) が用意されています。この２つのメソッドは、ネストした配列やオブジェクトを取り扱いたい場合、一意であることを決めるキーを指定する必要があります。

## unique(), uniqueStrict()

### example

```php
$collection = collect([
    ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
    ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
    ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
    ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
    ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
]);

// 'brand' キーで重複を判断し削除する
$unique = $collection->unique('brand');

$unique->values()->all();

/*
    [
        ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
        ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
    ]
*/
```

指定したキーの値さえ一致していれば、他のキーが一致していなくても重複として削除されてしまいます。

一意であることを決めるキーを指定するのではなく**配列の中身が完全に一致しているとかオブジェクトのプロパティや値が完全に一致しているとか**そういう場合に削除して欲しいんです…！！！！


と言いましても無いものは仕方ありませんので、そういう重複を削除できるメソッド deduplicate() メソッドをコレクションクラスに追加する拡張機能を作りました。


## deduplicate() メソッド

全てのキーやプロパティの値が一致していれば重複として削除します。

### example
```php
$collection = collect([
    ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
    ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
    ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
    ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
    ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
    // 1つ目のキーと全く同じ配列を格納しまくる
    ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
    ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
    ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
]);

$deduplicate = $collection->deduplicate();

$deduplicate->values()->all();

/*
    [
        ['name' => 'iPhone 6', 'brand' => 'Apple', 'type' => 'phone'],
        ['name' => 'iPhone 5', 'brand' => 'Apple', 'type' => 'phone'],
        ['name' => 'Apple Watch', 'brand' => 'Apple', 'type' => 'watch'],
        ['name' => 'Galaxy S6', 'brand' => 'Samsung', 'type' => 'phone'],
        ['name' => 'Galaxy Gear', 'brand' => 'Samsung', 'type' => 'watch'],
        // 以降3件は1つめのキーと同じ値のため、重複として扱われ削除される
    ]
*/
```

※サンプルは配列を格納して比較していますが、格納されているのがオブジェクトでも数値でも文字列でも問題なく動作します。

## 使い方

composer でインストールするだけ。
Collection クラスに deduplicate() メソッドが追加されます。

```bash
composer require kanagama/laravel-collection-deduplicate
```



## github
https://github.com/kanagama/laravel-collection-deduplicate

## packagist

https://packagist.org/packages/kanagama/laravel-collection-deduplicate



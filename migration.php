<?php
require_once "config.php";

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Capsule\Manager as Capsule;

Capsule::schema()->dropIfExists('product_category');
Capsule::schema()->dropIfExists('categories');
Capsule::schema()->dropIfExists('products');

// Таблица категорий
Capsule::schema()->create('categories', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('parent_id')->unsigned()->nullable();  // родительская категория
    $table->string('name', 100);  // название категории
});

// Таблица товаров
Capsule::schema()->create('products', function (Blueprint $table) {
    $table->increments('id');
    $table->string('name', 100); // название товара
    $table->decimal('price', 15, 2)->default(0); // цена
    $table->integer('quantity')->unsigned()->default(0); // количество в наличии
    $table->string('unity', 20); // единица измерения (шт, кг, упаковка и т.п.)
    $table->float('weight')->nullable(); // вес
});

// Таблица отношений между товарами и категориями.
// Один товар может быть в нескольких категориях.
Capsule::schema()->create('product_category', function (Blueprint $table) {
    $table->integer('product_id')->unsigned();
    $table->integer('category_id')->unsigned();
    $table->integer('position')->unsigned(); // позиция товара среди других в рамках одной категории
    // Внешние ключи
    $table->foreign('product_id')->references('id')->on('products');
    $table->foreign('category_id')->references('id')->on('categories');
    // Первичный ключ
    $table->primary(['product_id', 'category_id']);
});

echo 'Таблицы созданы';

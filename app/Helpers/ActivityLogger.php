<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogger
{
    public static function log($action, $description = null): void
    {
        ActivityLog::create([
            'user_id'     => auth()->id(),
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Borrowing
    |--------------------------------------------------------------------------
    */

    public static function borrow($products): void
    {
        self::log('borrow', "Mengajukan peminjaman {$products}");
    }

    public static function approve($products): void
    {  
        self::log('approve', "Menyetujui peminjaman {$products}");
    }

    public static function returned($products): void
    {
        self::log('return', "Mengembalikan {$products}");
    }

    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    public static function createProduct($name): void
    {
        self::log('create_product', "Menambahkan produk \"{$name}\"");
    }

    public static function updateProduct($oldName, $newName): void
    {
        self::log(
            'update_product',
            "Mengubah produk \"{$oldName}\" menjadi \"{$newName}\""
        );
    }

    public static function deleteProduct($name): void
    {
        self::log('delete_product', "Menghapus produk \"{$name}\"");
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public static function createCategory($name): void
    {
        self::log('create_category', "Menambahkan kategori \"{$name}\"");
    }

    public static function updateCategory($oldName, $newName): void
    {
        self::log(
            'update_category',
            "Mengubah kategori \"{$oldName}\" menjadi \"{$newName}\""
        );
    }

    public static function deleteCategory($name): void
    {
        self::log('delete_category', "Menghapus kategori \"{$name}\"");
    }

    /*
    |--------------------------------------------------------------------------
    | Supplier
    |--------------------------------------------------------------------------
    */

    public static function createSupplier($name): void
    {
        self::log('create_supplier', "Menambahkan supplier \"{$name}\"");
    }

    public static function updateSupplier($oldName, $newName): void
    {
        self::log(
            'update_supplier',
            "Mengubah supplier \"{$oldName}\" menjadi \"{$newName}\""
        );
    }

    public static function deleteSupplier($name): void
    {
        self::log('delete_supplier', "Menghapus supplier \"{$name}\"");
    }
}
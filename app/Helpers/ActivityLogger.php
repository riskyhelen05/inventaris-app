<?php

namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogger
{
    public static function log(string $action, ?string $description = null, array $extra = []): void
{
    try {
        ActivityLog::create(array_merge([
            'user_id'     => Auth::id(),
            'action'      => $action,
            'description' => $description ?? '-',
            'ip_address'  => Request::ip(),
            'user_agent'  => Request::userAgent(),
        ], [
            'old_data' => $extra['old_data'] ?? null,
            'new_data' => $extra['new_data'] ?? null, 
        ]));
    } catch (\Throwable $e) {
        report($e);
    }
}

    /*
    |--------------------------------------------------------------------------
    | Borrowing
    |--------------------------------------------------------------------------
    */

    public static function borrow($products): void
    {
        self::log('borrow', "Mengajukan peminjaman: {$products}");
    }

    public static function approve($products): void
    {
        self::log('approve', "Menyetujui peminjaman: {$products}");
    }

    public static function returned($products): void
    {
        self::log('return', "Mengembalikan: {$products}");
    }

    /*
    |--------------------------------------------------------------------------
    | Product
    |--------------------------------------------------------------------------
    */

    public static function createProduct($name): void
    {
        self::log('create_product', "Menambahkan produk: \"{$name}\"");
    }

    public static function updateProduct($oldName, $newName): void
    {
        self::log(
            'update_product',
            "Mengubah produk: \"{$oldName}\" → \"{$newName}\""
        );
    }

    public static function deleteProduct($name): void
    {
        self::log('delete_product', "Menghapus produk: \"{$name}\"");
    }

    /*
    |--------------------------------------------------------------------------
    | Category
    |--------------------------------------------------------------------------
    */

    public static function createCategory($name): void
    {
        self::log('create_category', "Menambahkan kategori: \"{$name}\"");
    }

    public static function updateCategory($oldName, $newName): void
    {
        self::log(
            'update_category',
            "Mengubah kategori: \"{$oldName}\" → \"{$newName}\""
        );
    }

    public static function deleteCategory($name): void
    {
        self::log('delete_category', "Menghapus kategori: \"{$name}\"");
    }
}
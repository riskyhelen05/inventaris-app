<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'action',
        'user_id',
        'description',
        'ip_address',
        'user_agent',
        'old_data',
        'new_data',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    const ACTION_LABELS = [
        'borrow' => 'Peminjaman',
        'approve' => 'Disetujui',
        'return' => 'Dikembalikan',

        'create_product' => 'Tambah Produk',
        'update_product' => 'Update Produk',
        'delete_product' => 'Hapus Produk',

        'create_category' => 'Tambah Kategori',
        'update_category' => 'Update Kategori',
        'delete_category' => 'Hapus Kategori',

        'update_profile' => 'Update Profil',
    ];

    public function getActionLabelAttribute()
    {
        return self::ACTION_LABELS[$this->action]
            ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    public static function log($action, $description = null)
    {
         return self::create([
            'action'      => $action,
            'user_id'     => auth()->id(),
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}
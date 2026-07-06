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
    'user_agent'
];

    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper label action (biar enak di blade)
     */
public function getActionLabelAttribute()
{
    return match ($this->action) {

        'borrow' => 'Peminjaman',
        'approve' => 'Disetujui',
        'return' => 'Dikembalikan',

        'create_product' => 'Tambah Produk',
        'update_product' => 'Update Produk',
        'delete_product' => 'Hapus Produk',

        'create_category' => 'Tambah Kategori',
        'update_category' => 'Update Kategori',
        'delete_category' => 'Hapus Kategori',

        'create_supplier' => 'Tambah Supplier',
        'update_supplier' => 'Update Supplier',
        'delete_supplier' => 'Hapus Supplier',

        'update_profile' => 'Update Profil',

        default => ucfirst(str_replace('_', ' ', $this->action)),
    };
}
}
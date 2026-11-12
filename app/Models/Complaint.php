<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Complaint extends Model
{
     protected $fillable = [
        'ticket_number',
        'access_code_hash',
        'name',
        'nik',
        'phone',
        'email',
        'service_location',
        'other_location',
        'category',
        'description',
        'status',
        'withdrawal_reason',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'completed_at' => 'datetime',
        ];
    }
    public function attachments(): HasMany
    {
        return $this->hasMany(ComplaintAttachment::class);
    }
}

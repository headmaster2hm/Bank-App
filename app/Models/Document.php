<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_id',
        'document_type',
        'title',
        'period_label',
        'document_date',
        'file_size_label',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'document_date' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    public static function typeLabel(?string $type): string
    {
        return match($type) {
            'statement' => 'Account statement',
            'tax' => 'Tax document',
            'notice' => 'Notice',
            'loan' => 'Loan document',
            'card' => 'Card document',
            'agreement' => 'Agreement',
            default => 'Document',
        };
    }
}

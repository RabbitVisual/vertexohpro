<?php

namespace Modules\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketMessage extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'user_id', 'content'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}

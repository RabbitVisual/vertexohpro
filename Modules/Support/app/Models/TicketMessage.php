<?php

namespace Modules\Support\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class TicketMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
    ];
    protected $fillable = ['ticket_id', 'user_id', 'content'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
        return $this->belongsTo(\App\Models\User::class);
    }
}

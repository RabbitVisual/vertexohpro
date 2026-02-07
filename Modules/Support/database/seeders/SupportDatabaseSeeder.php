<?php

namespace Modules\Support\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Support\Models\Ticket;
use App\Models\User;

class SupportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Problema com acesso',
            'status' => 'answered',
            'last_reply_at' => now(),
        ]);

        Ticket::create([
            'user_id' => $user->id,
            'subject' => 'Sugestão de funcionalidade',
            'status' => 'open',
            'last_reply_at' => null,
        ]);
    }
}

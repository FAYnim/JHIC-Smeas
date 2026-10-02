<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoleColumnTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_be_created_with_a_role(): void
    {
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
            'role' => 'bkk',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'budi@smkn1.surabaya.sch.id',
            'role' => 'bkk',
        ]);
    }

    public function test_role_may_be_null_for_unassigned_account(): void
    {
        User::create([
            'name' => 'Belum Ditugaskan',
            'email' => 'baru@smkn1.surabaya.sch.id',
            'password' => 'rahasia123',
        ]);

        $user = User::where('email', 'baru@smkn1.surabaya.sch.id')->firstOrFail();

        $this->assertNull($user->role);
    }

    public function test_invalid_role_is_rejected_by_database(): void
    {
        $this->expectException(QueryException::class);

        DB::table('users')->insert([
            'name' => 'Salah Peran',
            'email' => 'salah@smkn1.surabaya.sch.id',
            'password' => bcrypt('rahasia123'),
            'role' => 'superuser',
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Medicine;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ListFilteringTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_search_medicines_by_name(): void
    {
        $admin = User::factory()->admin()->create();
        $this->createMedicine('MED-FIND', 'Paracetamol Uji', 'Analgesik');
        $this->createMedicine('MED-HIDE', 'Vitamin Uji', 'Vitamin');

        $this->actingAs($admin)
            ->get(route('admin.medicines.index', ['q' => 'Paracetamol']))
            ->assertOk()
            ->assertSee('Paracetamol Uji')
            ->assertDontSee('Vitamin Uji');
    }

    public function test_admin_can_filter_users_by_role(): void
    {
        $admin = User::factory()->admin()->create(['name' => 'Pemilik Sistem']);
        User::factory()->admin()->create(['name' => 'Admin Filter']);
        User::factory()->apoteker()->create(['name' => 'Apoteker Filter']);

        $this->actingAs($admin)
            ->get(route('admin.usermanagemen.index', ['role' => 'apoteker']))
            ->assertOk()
            ->assertSee('Apoteker Filter')
            ->assertDontSee('Admin Filter');
    }

    public function test_apoteker_can_search_only_their_transactions(): void
    {
        $apoteker = User::factory()->apoteker()->create();
        $other = User::factory()->apoteker()->create();

        Transaction::create([
            'user_id' => $apoteker->id,
            'no_transaction' => 'TRX-SEARCH-ME',
            'total' => 10000,
        ]);
        Transaction::create([
            'user_id' => $other->id,
            'no_transaction' => 'TRX-SEARCH-OTHER',
            'total' => 20000,
        ]);

        $this->actingAs($apoteker)
            ->get(route('apoteker.transactions.index', ['q' => 'SEARCH']))
            ->assertOk()
            ->assertSee('TRX-SEARCH-ME')
            ->assertDontSee('TRX-SEARCH-OTHER');
    }

    private function createMedicine(string $code, string $name, string $category): void
    {
        Medicine::create([
            'kode' => $code,
            'nama' => $name,
            'satuan' => 'tablet',
            'kategori' => $category,
            'min_stok' => 10,
        ]);
    }
}

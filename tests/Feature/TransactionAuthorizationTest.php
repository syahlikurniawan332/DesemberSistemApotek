<?php

namespace Tests\Feature;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_apoteker_cannot_view_another_apotekers_transaction(): void
    {
        [$owner, $other, $transaction] = $this->transactionOwnedByAnotherUser();

        $this->actingAs($other)
            ->get(route('apoteker.transactions.show', $transaction))
            ->assertNotFound();
    }

    public function test_apoteker_cannot_edit_another_apotekers_transaction(): void
    {
        [$owner, $other, $transaction] = $this->transactionOwnedByAnotherUser();

        $this->actingAs($other)
            ->get(route('apoteker.transactions.edit', $transaction))
            ->assertNotFound();
    }

    public function test_apoteker_cannot_update_another_apotekers_transaction(): void
    {
        [$owner, $other, $transaction] = $this->transactionOwnedByAnotherUser();

        $this->actingAs($other)
            ->put(route('apoteker.transactions.update', $transaction), [
                'medicines' => [],
            ])
            ->assertNotFound();
    }

    private function transactionOwnedByAnotherUser(): array
    {
        $owner = User::factory()->apoteker()->create();
        $other = User::factory()->apoteker()->create();

        $transaction = Transaction::create([
            'user_id' => $owner->id,
            'no_transaction' => 'TRX-AUTH-TEST',
            'total' => 10000,
        ]);

        return [$owner, $other, $transaction];
    }
}

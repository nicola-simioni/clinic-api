<?php
namespace Tests\Feature;
use App\Mail\BookingConfirmationMail;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_booking(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $slot = Slot::factory()->create(['is_available' => true]);

        $response = $this->postJson('/api/v1/bookings', [
            'slot_id' => $slot->id,
            'notes' => 'Test booking',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'slot_id' => $slot->id,
        ]);
    }

    public function test_user_cannot_book_unavailable_slot(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $slot = Slot::factory()->create(['is_available' => false]);

        $response = $this->postJson('/api/v1/bookings', [
            'slot_id' => $slot->id,
            'notes' => 'Test booking',
        ]);

        $response->assertStatus(400);
    }

    public function test_unauthenticated_user_cannot_create_booking(): void
    {
        $slot = Slot::factory()->create();

        $response = $this->postJson('/api/v1/bookings', [
            'slot_id' => $slot->id,
        ]);

        $response->assertStatus(401);
    }

    public function test_booking_confirmation_email_is_sent(): void
    {
        Mail::fake();

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $slot = Slot::factory()->create(['is_available' => true]);

        $this->postJson('/api/v1/bookings', [
            'slot_id' => $slot->id,
            'notes' => 'Test email',
        ]);

        Mail::assertSent(BookingConfirmationMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    public function test_user_can_cancel_booking(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $slot = Slot::factory()->create(['is_available' => false]);
        $booking = Booking::factory()->create([
            'user_id' => $user->id,
            'slot_id' => $slot->id,
        ]);

        $response = $this->deleteJson("/api/v1/bookings/{$booking->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('bookings', ['id' => $booking->id]);
        $this->assertDatabaseHas('slots', ['id' => $slot->id, 'is_available' => true]);
    }

    public function test_user_can_list_own_bookings(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        Sanctum::actingAs($user);

        Booking::factory()->count(2)->create(['user_id' => $user->id]);
        Booking::factory()->count(3)->create(['user_id' => $otherUser->id]);

        $response = $this->getJson('/api/v1/bookings');

        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');
    }
}
<?php
namespace Tests\Feature;
use App\Models\Booking;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\Slot;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_booking(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $doctor = Doctor::factory()->create();
        $service = Service::factory()->create();
        $slot = Slot::factory()->create([
            'doctor_id' => $doctor->id,
            'service_id' => $service->id,
            'is_available' => true,
        ]);

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
}
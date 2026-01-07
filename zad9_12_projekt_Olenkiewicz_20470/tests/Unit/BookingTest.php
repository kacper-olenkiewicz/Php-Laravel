<?php

namespace Tests\Unit;

use App\Models\Booking;
use PHPUnit\Framework\TestCase;

class BookingTest extends TestCase
{
    /**
     * Test 4: Sprawdza czy model Booking ma zdefiniowane poprawne statusy w fillable.
     */
    public function test_booking_has_status_in_fillable(): void
    {
        $booking = new Booking();
        $fillable = $booking->getFillable();

        $this->assertContains('status', $fillable);
        $this->assertContains('total_amount', $fillable);
        $this->assertContains('start_date', $fillable);
        $this->assertContains('end_date', $fillable);
    }

    /**
     * Test 5: Sprawdza czy daty są poprawnie castowane.
     */
    public function test_booking_dates_are_casted_to_datetime(): void
    {
        $booking = new Booking();
        $casts = $booking->getCasts();

        $this->assertArrayHasKey('start_date', $casts);
        $this->assertArrayHasKey('end_date', $casts);
        $this->assertEquals('datetime', $casts['start_date']);
        $this->assertEquals('datetime', $casts['end_date']);
    }
}

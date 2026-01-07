<?php

namespace Tests\Unit;

use App\Models\Product;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    /**
     * Test 1: Sprawdza czy placeholder image zawiera poprawny URL picsum.
     */
    public function test_placeholder_image_contains_picsum_url(): void
    {
        $placeholder = Product::placeholderImageFor(1);

        $this->assertStringContainsString('picsum.photos', $placeholder);
    }

    /**
     * Test 2: Sprawdza czy placeholder dla różnych ID produktów zwraca różne obrazy.
     */
    public function test_placeholder_returns_different_images_for_different_ids(): void
    {
        $image1 = Product::placeholderImageFor(1);
        $image2 = Product::placeholderImageFor(5);

        // Różne ID powinny dawać różne obrazy (modulo długość tablicy)
        $this->assertNotEquals($image1, $image2);
    }

    /**
     * Test 3: Sprawdza czy tablica placeholderów nie jest pusta.
     */
    public function test_placeholder_images_array_is_not_empty(): void
    {
        $reflection = new \ReflectionClass(Product::class);
        $property = $reflection->getProperty('placeholderImages');
        $property->setAccessible(true);
        
        $placeholders = $property->getValue();

        $this->assertNotEmpty($placeholders);
        $this->assertIsArray($placeholders);
    }
}

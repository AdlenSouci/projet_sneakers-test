<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_contact_respond_correctly(): void
    {
        $response = $this->post('/contact', [
            'name' => 'John Doe',
            'email' => 'fake',
            'content' => 'This is a fake content'
        ]);

        $response->assertStatus(405);    
        //$response->assertRedirect();
        // $response->assertSessionHasErrors(['email']);
        // $response->assertSessionHasInput('email', 'fake');
    }
}

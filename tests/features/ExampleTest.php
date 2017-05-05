<?php

class ExampleTest extends FeatureTestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    function test_basic_example()
    {
        $user = factory(\App\User::class)->create([
            'name'  => 'JhonatanCF',
            'email' => 'admin@admin.com'
        ]);

        $this->actingAs($user, 'api')
            ->visit('api/user')
            ->see('JhonatanCF')
            ->see('admin@admin.com');
    }
}

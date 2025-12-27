<?php

use AnikRahman\Hive\Models\Tenant;
use AnikRahman\Hive\Actions\CreateTenant;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;


// test('creates tenant with auto subdomain', function () {
//     $tenant = (new CreateTenant)->execute('Acme Corporation');

//     expect($tenant)
//         ->toBeInstanceOf(Tenant::class)
//         ->name->toBe('Acme Corporation')
//         ->subdomain->toBe('acme-corporation');
// });

// test('creates tenant with custom subdomain', function () {
//     $tenant = (new CreateTenant)->execute('Tech Company', 'tech');
//     expect($tenant->subdomain)->toBe('tech');
// });

// test('prevents duplicate subdomains', function () {
//     (new CreateTenant)->execute('First', 'unique');
//     (new CreateTenant)->execute('Second', 'unique');
// })->throws(ValidationException::class);


// test('gets current tenant id', function () {
//     $tenant = Tenant::create(['subdomain' => 'demo', 'name' => 'Demo', 'status' => 1]);
//     app()->instance('currentTenant', $tenant);

//     expect(Tenant::id())->toBe($tenant->id);
// });

test('basic test works', function () {
    $this->assertTrue(true);
});

test('can instantiate tenant model', function () {
    $tenant = new \AnikRahman\Hive\Models\Tenant([
        'name' => 'Test',
        'subdomain' => 'test'
    ]);

    $this->assertInstanceOf(\AnikRahman\Hive\Models\Tenant::class, $tenant);
});



// test('database connection works', function () {
//     // Test if we can run a simple SQL query
//     \DB::statement('CREATE TABLE IF NOT EXISTS test_table (id INTEGER)');
//     \DB::insert('INSERT INTO test_table (id) VALUES (1)');
//     $result = \DB::select('SELECT * FROM test_table');
    
//     $this->assertCount(1, $result);
//     $this->assertEquals(1, $result[0]->id);
// });


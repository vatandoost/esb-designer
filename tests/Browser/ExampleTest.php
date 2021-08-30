<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->browse(function (Browser $browser) {
            $loginPage = $browser->visit(route('login'));
            $browser->screenshot('filename');
            $loginPage->assertSee('Welcome Back');
        });
    }

    protected function hasHeadlessDisabled()
    {
        return true;
    }
}

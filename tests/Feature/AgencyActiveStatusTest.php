<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgencyActiveStatusTest extends TestCase
{
    use RefreshDatabase;

    private Agency $activeAgency;

    private Agency $inactiveAgency;

    private User $superAdmin;

    private User $activeAgencyAdmin;

    private User $inactiveAgencyAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->activeAgency = Agency::create(['name' => 'Active Agency', 'slug' => 'active-agency', 'is_active' => true]);
        $this->inactiveAgency = Agency::create(['name' => 'Inactive Agency', 'slug' => 'inactive-agency', 'is_active' => false]);

        $this->superAdmin = User::create([
            'name' => 'Super', 'email' => 'super@test.local', 'password' => 'password',
            'role' => 'super_admin', 'agency_id' => null,
        ]);

        $this->activeAgencyAdmin = User::create([
            'name' => 'Active Admin', 'email' => 'active-admin@test.local', 'password' => 'password',
            'role' => 'agency_admin', 'agency_id' => $this->activeAgency->id,
        ]);

        $this->inactiveAgencyAdmin = User::create([
            'name' => 'Inactive Admin', 'email' => 'inactive-admin@test.local', 'password' => 'password',
            'role' => 'agency_admin', 'agency_id' => $this->inactiveAgency->id,
        ]);
    }

    public function test_super_admin_login_is_never_blocked(): void
    {
        $this->post(route('admin.login.submit'), [
            'email' => 'super@test.local',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->superAdmin);
    }

    public function test_active_agency_admin_can_log_in(): void
    {
        $this->post(route('admin.login.submit'), [
            'email' => 'active-admin@test.local',
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($this->activeAgencyAdmin);
    }

    public function test_inactive_agency_admin_cannot_log_in(): void
    {
        $this->post(route('admin.login.submit'), [
            'email' => 'inactive-admin@test.local',
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_already_logged_in_session_is_bounced_the_moment_its_agency_is_deactivated(): void
    {
        $this->actingAs($this->activeAgencyAdmin)
            ->get(route('admin.dashboard'))
            ->assertOk();

        $this->activeAgency->update(['is_active' => false]);

        // Force the auth guard to re-resolve the user on the next request
        // instead of reusing the PHP object it already cached in-process —
        // matches a real second HTTP request, which always re-fetches fresh.
        $this->app['auth']->forgetGuards();

        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }

    public function test_deactivating_one_agency_never_affects_another(): void
    {
        $this->activeAgency->update(['is_active' => false]);

        // A separate, still-active agency's admin is unaffected.
        $stillActive = Agency::create(['name' => 'Untouched Agency', 'slug' => 'untouched-agency', 'is_active' => true]);
        $stillActiveAdmin = User::create([
            'name' => 'Untouched Admin', 'email' => 'untouched-admin@test.local', 'password' => 'password',
            'role' => 'agency_admin', 'agency_id' => $stillActive->id,
        ]);

        $this->actingAs($stillActiveAdmin)
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_a_query_cannot_be_assigned_to_an_inactive_agency(): void
    {
        $inquiry = Inquiry::create(['name' => 'Test Customer']);

        $this->actingAs($this->superAdmin)
            ->post(route('admin.inquiries.assign-agency', $inquiry), ['agency_id' => $this->inactiveAgency->id])
            ->assertSessionHasErrors('agency_id');

        $this->assertNull($inquiry->fresh()->agency_id);
    }

    public function test_a_query_can_still_be_assigned_to_an_active_agency(): void
    {
        $inquiry = Inquiry::create(['name' => 'Test Customer']);

        $this->actingAs($this->superAdmin)
            ->post(route('admin.inquiries.assign-agency', $inquiry), ['agency_id' => $this->activeAgency->id])
            ->assertRedirect();

        $this->assertEquals($this->activeAgency->id, $inquiry->fresh()->agency_id);
    }
}

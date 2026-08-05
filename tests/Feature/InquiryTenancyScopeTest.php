<?php

namespace Tests\Feature;

use App\Models\Agency;
use App\Models\Inquiry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InquiryTenancyScopeTest extends TestCase
{
    use RefreshDatabase;

    private Agency $agencyA;

    private Agency $agencyB;

    private User $superAdmin;

    private User $agencyAdminA;

    private User $agentA;

    private Inquiry $inquiryA;

    private Inquiry $inquiryB;

    protected function setUp(): void
    {
        parent::setUp();

        $this->agencyA = Agency::create(['name' => 'Agency A', 'slug' => 'agency-a', 'is_active' => true]);
        $this->agencyB = Agency::create(['name' => 'Agency B', 'slug' => 'agency-b', 'is_active' => true]);

        $this->superAdmin = User::create([
            'name' => 'Super', 'email' => 'super@test.local', 'password' => 'password',
            'role' => 'super_admin', 'agency_id' => null,
        ]);

        $this->agencyAdminA = User::create([
            'name' => 'Admin A', 'email' => 'admin-a@test.local', 'password' => 'password',
            'role' => 'agency_admin', 'agency_id' => $this->agencyA->id,
        ]);

        $this->agentA = User::create([
            'name' => 'Agent A', 'email' => 'agent-a@test.local', 'password' => 'password',
            'role' => 'agent', 'agency_id' => $this->agencyA->id,
        ]);

        $this->inquiryA = Inquiry::create(['name' => 'Customer A', 'agency_id' => $this->agencyA->id]);
        $this->inquiryB = Inquiry::create(['name' => 'Customer B', 'agency_id' => $this->agencyB->id]);

        $this->inquiryA->update(['assigned_agent_id' => $this->agentA->id]);
    }

    public function test_super_admin_sees_every_agencys_inquiries(): void
    {
        $this->actingAs($this->superAdmin);
        $ids = Inquiry::pluck('id');

        $this->assertTrue($ids->contains($this->inquiryA->id));
        $this->assertTrue($ids->contains($this->inquiryB->id));
    }

    public function test_agency_admin_only_sees_their_own_agencys_inquiries(): void
    {
        $this->actingAs($this->agencyAdminA);
        $ids = Inquiry::pluck('id');

        $this->assertTrue($ids->contains($this->inquiryA->id));
        $this->assertFalse($ids->contains($this->inquiryB->id));
    }

    public function test_agency_admin_gets_404_fetching_another_agencys_inquiry_directly(): void
    {
        $this->actingAs($this->agencyAdminA)
            ->get(route('admin.inquiries.show', $this->inquiryB))
            ->assertNotFound();
    }

    public function test_agent_only_sees_inquiries_assigned_to_them_not_their_whole_agency(): void
    {
        $unassignedInAgencyA = Inquiry::create(['name' => 'Unassigned in Agency A', 'agency_id' => $this->agencyA->id]);

        $this->actingAs($this->agentA);
        $ids = Inquiry::pluck('id');

        $this->assertTrue($ids->contains($this->inquiryA->id));
        $this->assertFalse($ids->contains($unassignedInAgencyA->id));
        $this->assertFalse($ids->contains($this->inquiryB->id));
    }

    public function test_agent_gets_404_fetching_an_unassigned_inquiry_directly(): void
    {
        $unassignedInAgencyA = Inquiry::create(['name' => 'Unassigned in Agency A', 'agency_id' => $this->agencyA->id]);

        $this->actingAs($this->agentA)
            ->get(route('admin.inquiries.show', $unassignedInAgencyA))
            ->assertNotFound();
    }

    public function test_agent_cannot_reassign_an_inquiry(): void
    {
        $this->actingAs($this->agentA)
            ->post(route('admin.inquiries.assign-agent', $this->inquiryA), ['agent_id' => $this->agentA->id])
            ->assertForbidden();
    }

    public function test_agency_admin_cannot_assign_an_agent_from_another_agency(): void
    {
        $agentB = User::create([
            'name' => 'Agent B', 'email' => 'agent-b@test.local', 'password' => 'password',
            'role' => 'agent', 'agency_id' => $this->agencyB->id,
        ]);

        $this->actingAs($this->agencyAdminA)
            ->post(route('admin.inquiries.assign-agent', $this->inquiryA), ['agent_id' => $agentB->id])
            ->assertSessionHasErrors('agent_id');
    }

    public function test_only_super_admin_can_delete_an_inquiry(): void
    {
        $this->actingAs($this->agencyAdminA)
            ->delete(route('admin.inquiries.destroy', $this->inquiryA))
            ->assertForbidden();

        $this->assertDatabaseHas('inquiries', ['id' => $this->inquiryA->id]);

        $this->actingAs($this->superAdmin)
            ->delete(route('admin.inquiries.destroy', $this->inquiryA))
            ->assertRedirect(route('admin.inquiries.index'));

        $this->assertDatabaseMissing('inquiries', ['id' => $this->inquiryA->id]);
    }

    public function test_only_super_admin_can_manage_agencies_and_users(): void
    {
        $this->actingAs($this->agencyAdminA)->get(route('admin.agencies.index'))->assertForbidden();
        $this->actingAs($this->agencyAdminA)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($this->agentA)->get(route('admin.agencies.index'))->assertForbidden();

        $this->actingAs($this->superAdmin)->get(route('admin.agencies.index'))->assertOk();
    }

    public function test_only_super_admin_can_view_contact_clicks(): void
    {
        $this->actingAs($this->agencyAdminA)->get(route('admin.contact-clicks.index'))->assertForbidden();
        $this->actingAs($this->superAdmin)->get(route('admin.contact-clicks.index'))->assertOk();
    }
}

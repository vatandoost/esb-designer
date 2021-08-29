<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

class ProjectsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_needs_login()
    {
        $response = $this->get('/project');

        $response->assertRedirect('/login');
    }

    public function test_create_project()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);
        $name = $this->faker->text(50);
        $response = $this->post(route('project.store'), [
            'name' => $name,
        ]);
        $project = Project::where('owner_id', '=', $user->id)
            ->where('name', '=', $name)
            ->get()->first();
        assertTrue($project->exists);

        $response->assertRedirect(route('project.index'));
    }

    public function test_create_project_with_empty_name()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);
        $name = '';
        $response = $this->post(route('project.store'), [
            'name' => $name,
        ]);

        $project = Project::where('owner_id', '=', $user->id)
            ->where('name', '=', $name)
            ->get()->first();

        assertNull($project);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_create_project_with_duplicated_name()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);
        $project = Project::factory()->for($user)->hasNamespaces(1)->create();
        $response = $this->post(route('project.store'), [
            'name' => $project->name,
        ]);

        $projectCount = Project::where('owner_id', '=', $user->id)
            ->where('name', '=', $project->name)
            ->count();

        assertTrue($projectCount == 1);
        $response->assertSessionHasErrors(['name']);
    }

    public function test_activate_project()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->for($user)->hasNamespaces(1)->create();
        $response = $this->post(route('project.activate', ['project' => $project->id]));
        $response->assertSessionHas('active_project');
        $response->assertOk();
        $response->assertJsonPath('id', $project->id);
    }

    public function test_update_project()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->for($user)->hasNamespaces(1)->create();
        $name = $this->faker->text(50);
        $response = $this->post(route('project.update', ['project' => $project->id]), [
            'name' => $name,
        ]);
        $project = Project::find($project->id);

        assertTrue($project->name == $name);
        $response->assertRedirect(route('project.index'));
        $response->assertSessionHas('toast_message');
    }

    public function test_update_project_with_wrong_data()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);

        //test empty name update
        $project = Project::factory()->for($user)->hasNamespaces(1)->create();
        $response = $this->post(route('project.update', ['project' => $project->id]), [
            'name' => '',
        ]);
        $project->fresh();

        assertFalse($project->name == '');
        $response->assertSessionHasErrors(['name']);

        //test nuique name update
        $project2 = Project::factory()->for($user)->hasNamespaces(1)->create();
        $response2 = $this->post(route('project.update', ['project' => $project2->id]), [
            'name' => $project->name,
        ]);
        $project2->fresh();

        assertFalse($project->name == $project2->name);
        $response2->assertSessionHasErrors(['name']);
    }

    public function test_update_notowned_project()
    {

        /** @var User */
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->for($user2)->hasNamespaces(1)->create();
        $name = $this->faker->text(50);
        $response = $this->post(route('project.update', ['project' => $project->id]), [
            'name' => $name,
        ]);
        $response->assertForbidden();
    }

    public function test_delete_project()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->for($user)->hasNamespaces(1)->create();
        $response = $this->delete(route('project.delete', ['project' => $project->id]));
        $project = Project::find($project->id);

        assertNull($project);
        $response->assertRedirect(route('project.index'));
        $response->assertSessionHas('toast_message');
    }

    public function test_delete_active_project()
    {
        /** @var User */
        $user = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->for($user)->hasNamespaces(1)->create();
        $response = $this->withSession([
            'active_project' => $project
        ])->delete(route('project.delete', ['project' => $project->id]));
        $project = Project::find($project->id);

        assertNull($project);
        $response->assertRedirect(route('project.index'));
        //should remove session after delete main project
        $response->assertSessionMissing('active_project');
    }

    public function test_delete_notowned_project()
    {
        /** @var User */
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $this->be($user);

        $project = Project::factory()->for($user2)->hasNamespaces(1)->create();
        $response = $this->delete(route('project.delete', ['project' => $project->id]));
        $response->assertForbidden();
    }
}

<?php

namespace Tests\Unit\Models;

use App\Entities\Partners\Customer;
use App\Entities\Projects\Project;
use Illuminate\Support\Collection;
use Tests\TestCase as TestCase;

class CustomerTest extends TestCase
{
    /** @test */
    public function a_customer_has_many_projects()
    {
        $customer = factory(Customer::class)->create();
        $project = factory(Project::class)->create(['customer_id' => $customer->id]);

        $this->assertInstanceOf(Collection::class, $customer->projects);
        $this->assertInstanceOf(Project::class, $customer->projects->first());
    }

    /** @test */
    public function a_customer_has_name_link_method()
    {
        $customer = factory(Customer::class)->make();
        $this->assertEquals(
            link_to_route('customers.show', $customer->name, [$customer->id], [
                'title' => trans(
                    'app.show_detail_title',
                    ['name' => $customer->name, 'type' => trans('customer.customer')]
                ),
            ]), $customer->nameLink()
        );
    }
}

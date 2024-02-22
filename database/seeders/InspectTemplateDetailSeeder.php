<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InspectTemplateDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('inspect_template_details')->delete();

        \DB::table('inspect_template_details')->insert([
                [
                    'inspect_template_id' => 1,
                    'inspect_topic_id' => 1,
                ],
                [
                    'inspect_template_id' => 1,
                    'inspect_topic_id' => 2,
                ],
                [
                    'inspect_template_id' => 2,
                    'inspect_topic_id' => 3,
                ],
                [
                    'inspect_template_id' => 2,
                    'inspect_topic_id' => 4,
                ],
                [
                    'inspect_template_id' => 2,
                    'inspect_topic_id' => 5,
                ],
                [
                    'inspect_template_id' => 2,
                    'inspect_topic_id' => 6,
                ],
                [
                    'inspect_template_id' => 2,
                    'inspect_topic_id' => 7,
                ],
                [
                    'inspect_template_id' => 2,
                    'inspect_topic_id' => 8,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 9,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 10,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 11,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 12,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 13,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 14,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 15,
                ],
                [
                    'inspect_template_id' => 3,
                    'inspect_topic_id' => 16,
                ],
                [
                    'inspect_template_id' => 4,
                    'inspect_topic_id' => 17,
                ],
                [
                    'inspect_template_id' => 4,
                    'inspect_topic_id' => 18,
                ],
                [
                    'inspect_template_id' => 4,
                    'inspect_topic_id' => 19,
                ],
                [
                    'inspect_template_id' => 4,
                    'inspect_topic_id' => 20,
                ],
                [
                    'inspect_template_id' => 4,
                    'inspect_topic_id' => 21,
                ],
            ]
        );
    }
}

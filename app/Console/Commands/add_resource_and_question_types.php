<?php

namespace App\Console\Commands;

use App\Models\QuestionResourceTypes;
use App\Models\QuestionType;
use App\Models\ResourceType;
use Illuminate\Console\Command;

class add_resource_and_question_types extends Command
{
    protected $signature = 'type:add_resource_and_question_types';

    protected $description = 'Add resource and question types';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        $rt1 = ResourceType::create([
            'id' => 1,
            'name' => 'video',
        ]);
        $rt2 = ResourceType::create([
            'id' => 2,
            'name' => 'audio',
        ]);
        $rt3 = ResourceType::create([
            'id' => 3,
            'name' => 'image',
        ]);
        $rt4 = ResourceType::create([
            'id' => 4,
            'name' => 'text',
        ]);

        $qt1 = QuestionType::create([
            'id' => 1,
            'name' => 'listening',
        ]);
        $qt2 = QuestionType::create([
            'id' => 2,
            'name' => 'reading',
        ]);
        $qt3 = QuestionType::create([
            'id' => 3,
            'name' => 'grammar',
        ]);
        $qt4 = QuestionType::create([
            'id' => 4,
            'name' => 'vocabulary',
        ]);
        $qt5 = QuestionType::create([
            'id' => 5,
            'name' => 'speaking',
        ]);
        $qt6 = QuestionType::create([
            'id' => 6,
            'name' => 'writing',
        ]);

        $qt1->resource_types()->attach($rt1->id);
        $qt1->resource_types()->attach($rt2->id);

        $qt2->resource_types()->attach($rt3->id);
        $qt2->resource_types()->attach($rt4->id);
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Level;
use Illuminate\Console\Command;

class insert_levels_data extends Command
{
    protected $signature = 'levels:insert_data';

    protected $description = 'Insert levels datable data';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        Level::create([
            'name' => 'Beginner Mid'
        ]);
        Level::create([
            'name' => 'Beginner Final'
        ]);

        Level::create([
            'name' => 'Elementary Mid'
        ]);
        Level::create([
            'name' => 'Elementary Final'
        ]);

        Level::create([
            'name' => 'Pre-Intermediate Mid'
        ]);
        Level::create([
            'name' => 'Pre-Intermediate Final'
        ]);

        Level::create([
            'name' => 'Intermediate Mid'
        ]);
        Level::create([
            'name' => 'Intermediate Final'
        ]);

        Level::create([
            'name' => 'Upper-Intermediate Mid'
        ]);
        Level::create([
            'name' => 'Upper-Intermediate Final'
        ]);
    }
}

<?php

namespace App\Console\Commands;

use App\Obstacle;
use App\Rover;
use App\ValueObjects\ActionValueObject;
use App\ValueObjects\MapValueObject;
use Illuminate\Console\Command;

class MarsRoverMission extends Command
{
    public const OBSTACLES = 4;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mars:rovers_mission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Victor Quiros Mayer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $map = MapValueObject::create();
        $rover = Rover::create();
        $coordinate = $map->putInitialRover($rover);

        for ($i = 0; $i < self::OBSTACLES; $i++) {
            $obstacle = Obstacle::create();
            $coordinateObstacle = $map->putInitialObstacle($obstacle);
            $this->info('Obstacle is in row: ' . $coordinateObstacle->row() . ' and column: ' . $coordinateObstacle->column());
        }

        do{
            try{
                $this->info('Rover is in row: ' . $coordinate->row() . ' and column: ' . $coordinate->column());

                $actionsString = $this->ask('Actions: (F,L,R)');

                $actions = str_split(strtoupper($actionsString));

                foreach ($actions as $action) {
                    $coordinate = $map->move(ActionValueObject::fromString($action));
                    $this->info('Rover moved to row: ' . $coordinate->row() . ' and column: ' . $coordinate->column());
                }

            }catch (\Exception $e){
                $this->error($e->getMessage());
            }
            $continue = $this->ask('Continue making movements? (Y/N)');
        }while(strtoupper($continue) !== "N");

        return 0;
    }
}

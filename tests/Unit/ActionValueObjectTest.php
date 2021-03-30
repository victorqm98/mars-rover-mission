<?php

namespace Tests\Unit;

use App\Console\Commands\MarsRoverMission;
use App\ValueObjects\ActionValueObject;
use App\ValueObjects\MapValueObject;
use PHPUnit\Framework\TestCase;

class ActionValueObjectTest extends TestCase
{

    /** @dataProvider actionsProvider */
    public function testActionAllowed($action){
        $result = ActionValueObject::fromString($action);

        $this->assertEquals($action, $result->value());
    }

    public function actionsProvider()
    {
        return [
            ['F'],
            ['R'],
            ['L']
        ];
    }

    public function test_action_not_allowed_return_exception(){
        $this->expectException(\InvalidArgumentException::class);
        ActionValueObject::fromString('P');
    }

    public function testObstaclesLessThanCells(){
        $numCells = pow(MapValueObject::DIMENSION, 2);
        $numObstacles = MarsRoverMission::OBSTACLES;
        $condition = $numObstacles < ($numCells - 1);
        $this->assertTrue($condition);
    }
}

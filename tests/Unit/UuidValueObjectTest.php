<?php

namespace Tests\Unit;

use App\Console\Commands\MarsRoverMission;
use App\ValueObjects\ActionValueObject;
use App\ValueObjects\MapValueObject;
use App\ValueObjects\UuidValueObject;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UuidValueObjectTest extends TestCase
{
    public function test_valid_uuid_format(){
        $uuid = Uuid::uuid4()->toString();
        $result = UuidValueObject::fromString($uuid);

        $this->assertEquals($uuid, $result->value());
    }

    public function test_invalid_uuid_format(){
        $id = '1234';
        $this->expectException(\InvalidArgumentException::class);
        UuidValueObject::fromString($id);
    }
}

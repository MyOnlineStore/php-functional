<?php

declare(strict_types=1);

namespace test\Functional;

use function Widmogrod\Functional\applicator;

class ApplicatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider provideData
     */
    public function test_it_should_apply_value_as_a_argument_to_a_function(
        $value,
        callable $fn,
        $expected
    ) {
        $this->assertSame(
            $expected,
            applicator($value, $fn)
        );
    }

    public function provideData()
    {
        return [
            'Single value function' => [
                '$value' => 133,
                '$fn' => function (int $i): int {
                    return 10 + $i;
                },
                '$expected' => 143,
            ],
        ];
    }
}

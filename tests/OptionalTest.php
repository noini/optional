<?php

namespace Noini\Optional;

use Noini\Optional\Helpers\Types;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class OptionalTest extends TestCase
{
    private static $objectHasCalled;

    protected function setUp()
    {
        parent::setUp();

        self::$objectHasCalled = false;
    }

    protected function failCallback()
    {
        $this->fail("Callback should not be called");
    }

    public static function objectCallTest($data)
    {
        TestCase::assertFalse(empty($data));
        self::$objectHasCalled = true;
    }

    public function testCreate_whenCalled_shouldReturnNewOptionalInstance()
    {
        $payload = "content";
        $optional = Optional::create($payload);
        $this->assertTrue($optional instanceof Optional);
        $this->assertEquals($payload, $optional->getPayload());
    }

    public function testOptionalFunction_whenCalled_shouldReturnNewOptionalInstance()
    {
        $payload = "content";
        $optional = optional($payload);
        $this->assertTrue($optional instanceof Optional);
        $this->assertEquals($payload, $optional->getPayload());
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testThen_whenConstructorGivenNullPayload_shouldNotBeCalled()
    {
        optional(null)->then(function () {
            $this->failCallback();
        });
    }

    public function testThen_whenConstructorGivenNonNullPayload_shouldBeCalled()
    {
        $payload = "string";
        optional($payload)->then(function ($data) use ($payload) {
            $this->assertEquals($payload, $data);
        });
    }

    public function testThen_whenNonNullPayload_withCallableStringCallback_shouldBeCalled()
    {
        optional("non-null")->then(__CLASS__ . "::objectCallTest");
        $this->assertTrue(self::$objectHasCalled, "Did not call static callback method");
    }

    public function testHas_whenNullPayload_withNullTypeCheck_shouldCallThen()
    {
        optional(null)->has(Types::NULL)->then(function ($value) {
            $this->assertNull($value);
        });
    }

    public function testHas_whenNullPayload_withNullValueCheck_shouldCallThen()
    {
        optional(null)->has(null)->then(function ($value) {
            $this->assertNull($value);
        });
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testHas_whenNullPayload_withEmptyStringComparison_shouldNotCallThen()
    {
        optional(null)->has("")->then(function () {
            $this->failCallback();
        });
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testThen_whenHasBeenCalled_shouldUseLastHasResult()
    {
        optional(true)
            ->has("You shall not pass")
            ->then(function () {
                $this->failCallback();
            })
            ->then(function () {
                $this->failCallback();
            });
    }

    public function testGetResult_whenHasIsSuccessful_shouldReturnTrue()
    {
        $payload = "expected string";
        $result = optional($payload)->has($payload)->getResult();
        $this->assertTrue($result);
    }

    public function testGetResult_whenHasIsNotSuccessful_shouldReturnFalse()
    {
        $payload = "123 unexpected string";
        $result = optional($payload)->has(123)->getResult();
        $this->assertFalse($result);
    }

    public function testHas_whenGivenCallable_shouldCallCallable()
    {
        $calledCallable = false;
        $payload = 10;
        optional($payload)
            ->has(function ($data) use ($payload, &$calledCallable) {
                $calledCallable = true;
                return $data === $payload;
            });

        $this->assertTrue($calledCallable, "Did not call callable");
    }

    public function testHas_whenGivenCallable_thatDoesNotReturnBool_shouldThrowException()
    {
        $this->expectException(UnexpectedValueException::class);

        optional("stuff")->has(function () {
            return "nope.jpg";
        });
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testIf_whenGivenComparisonFails_shouldNotCallCallback()
    {
        optional(null)->if(Types::STRING, function () {
            $this->failCallback();
        });
    }

    public function testIf_whenGivenComparisonSucceeds_shouldCallCallback()
    {
        $payload = "string value";
        optional($payload)
            ->if(Types::STRING, function ($data) use ($payload) {
                $this->assertSame($payload, $data);
            });
    }

    public function testElse_whenIfComparisonFails_shouldCallElseCallback()
    {
        optional(null)
            ->if(Types::STRING, function () {
                $this->failCallback();
            })->else(function ($data) {
                $this->assertNull($data, "Original payload should be null");
            });
    }

    public function testElse_whenIfComparisonSucceeds_shouldNotCallElseCallback()
    {
        $payload = "this is a string";
        optional($payload)
            ->if(Types::STRING, function ($data) use ($payload) {
                $this->assertSame($payload, $data);
            })->else(function () {
                $this->failCallback();
            });
    }
}

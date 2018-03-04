<?php

namespace Noini\Optional;

use Noini\Optional\Helpers\Types;
use PHPUnit\Framework\TestCase;

class OptionalTest extends TestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    protected function failCallback()
    {
        $this->fail("Callback should not be called");
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
}

<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Account\Tests\Infrastructure\Validator;

use Ergonode\Account\Domain\Query\RoleQueryInterface;
use Ergonode\Account\Infrastructure\Validator\RoleNameUnique;
use Ergonode\Account\Infrastructure\Validator\RoleNameUniqueValidator;
use Ergonode\SharedKernel\Domain\Aggregate\RoleId;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

/**
 */
class RoleNameUniqueValidatorTest extends ConstraintValidatorTestCase
{
    /**
     * @var RoleQueryInterface|MockObject
     */
    private RoleQueryInterface $query;

    /**
     */
    protected function setUp(): void
    {
        $this->query = $this->createMock(RoleQueryInterface::class);
        parent::setUp();
    }

    /**
     */
    public function testWrongValueProvided(): void
    {
        $this->expectException(\Symfony\Component\Validator\Exception\ValidatorException::class);
        $this->validator->validate(new \stdClass(), new RoleNameUnique());
    }

    /**
     */
    public function testWrongConstraintProvided(): void
    {
        $this->expectException(\Symfony\Component\Validator\Exception\ValidatorException::class);
        /** @var Constraint $constraint */
        $constraint = $this->createMock(Constraint::class);
        $this->validator->validate('Value', $constraint);
    }

    /**
     */
    public function testCorrectEmptyValidation(): void
    {
        $this->validator->validate('', new RoleNameUnique());

        $this->assertNoViolation();
    }

    /**
     */
    public function testRoleNameExistsValidation(): void
    {
        $this->query->method('findIdByRoleName')->willReturn($this->createMock(RoleId::class));
        $constraint = new RoleNameUnique();
        $value = 'value';
        $this->validator->validate($value, $constraint);

        $assertion = $this->buildViolation($constraint->uniqueMessage);
        $assertion->assertRaised();
    }

    /**
     * @return RoleNameUniqueValidator
     */
    protected function createValidator(): RoleNameUniqueValidator
    {
        return new RoleNameUniqueValidator($this->query);
    }
}
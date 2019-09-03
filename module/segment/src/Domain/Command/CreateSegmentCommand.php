<?php

/**
 * Copyright © Bold Brand Commerce Sp. z o.o. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types = 1);

namespace Ergonode\Segment\Domain\Command;

use Ergonode\Core\Domain\ValueObject\TranslatableString;
use Ergonode\Segment\Domain\Entity\SegmentId;
use Ergonode\Segment\Domain\ValueObject\SegmentCode;
use JMS\Serializer\Annotation as JMS;

/**
 */
class CreateSegmentCommand
{
    /**
     * @var SegmentId
     *
     * @JMS\Type("Ergonode\Segment\Domain\Entity\SegmentId")
     */
    private $id;

    /**
     * @var SegmentCode
     *
     * @JMS\Type("Ergonode\Segment\Domain\ValueObject\SegmentCode")
     */
    private $code;

    /**
     * @var TranslatableString
     *
     * @JMS\Type("Ergonode\Core\Domain\ValueObject\TranslatableString")
     */
    private $name;

    /**
     * @var TranslatableString
     *
     * @JMS\Type("Ergonode\Core\Domain\ValueObject\TranslatableString")
     */
    private $description;

    /**
     * @param SegmentCode        $code
     * @param TranslatableString $name
     * @param TranslatableString $description
     */
    public function __construct(SegmentCode $code, TranslatableString $name, TranslatableString $description)
    {
        $this->id = SegmentId::fromCode($code);
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return SegmentId
     */
    public function getId(): SegmentId
    {
        return $this->id;
    }

    /**
     * @return SegmentCode
     */
    public function getCode(): SegmentCode
    {
        return $this->code;
    }

    /**
     * @return TranslatableString
     */
    public function getName(): TranslatableString
    {
        return $this->name;
    }

    /**
     * @return TranslatableString
     */
    public function getDescription(): TranslatableString
    {
        return $this->description;
    }
}

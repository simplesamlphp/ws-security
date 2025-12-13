<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507\Type;

use SimpleSAML\WSSecurity\XML\sp_200507\AbstractSpElement;
use SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken;
use SimpleSAML\XML\Attribute as XMLAttribute;
use SimpleSAML\XMLSchema\Type\AnyURIValue as BaseAnyURIValue;

/**
 * @package simplesaml/ws-security
 */
class IncludeTokenValue extends BaseAnyURIValue
{
    /**
     * Convert this value to an attribute
     *
     * @return \SimpleSAML\XML\Attribute
     */
    public function toAttribute(): XMLAttribute
    {
        return new XMLAttribute(AbstractSpElement::NS, AbstractSpElement::NS_PREFIX, 'IncludeToken', $this);
    }


    /**
     * @param \SimpleSAML\WSSecurity\XML\sp_200507\IncludeToken $value
     * @return static
     */
    public static function fromEnum(IncludeToken $value): static
    {
        return new static($value->value);
    }
}

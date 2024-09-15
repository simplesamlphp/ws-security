<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsdl;

/**
 * Abstract class representing the tTypes type.
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractTypes extends AbstractExtensibleDocumented
{
    /**
     * Initialize a wsdl:tTypes
     *
     * @param \SimpleSAML\XML\SerializableElementInterface[] $elements
     */
    public function __construct(
        array $elements = [],
    ) {
        parent::__construct($elements);
    }
}

<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\wsa;

use SimpleSAML\Assert\Assert;
use SimpleSAML\WSSecurity\Exception\ProtocolViolationException;
use SimpleSAML\XML\Constants;
use SimpleSAML\XML\ExtendableAttributesTrait;
use SimpleSAML\XML\XMLStringElementTrait;

use function filter_var;

/**
 * Class representing WS-addressing AttributedURIType.
 *
 * @package tvdijen/ws-security
 */
abstract class AbstractAttributedURIType extends AbstractWsaElement
{
    use ExtendableAttributesTrait;
    use XMLStringElementTrait;

    /** The namespace-attribute for the xs:any element */
    public const NAMESPACE = Constants::XS_ANY_NS_OTHER;


    /**
     * AbstractAttributedURIType constructor.
     *
     * @param string $value The localized string.
     */
    final public function __construct(string $value)
    {
        $this->setContent($value);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \SimpleSAML\WSSecurity\Exception\ProtocolViolationException on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        parent::validateContent($content);

        Assert::false(
            !empty($content) && !filter_var($content, FILTER_VALIDATE_URL),
            $this->getQualifiedName() . ' is not a valid URL.',
            ProtocolViolationException::class,
        );
    }
}

<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200507;

use DOMNodeList;
use DOMXPath;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\TypedTextContentTrait;
use SimpleSAML\XMLSchema\Type\StringValue;

/**
 * An XPath element
 *
 * @package simplesamlphp/ws-security
 */
final class XPath extends AbstractSpElement
{
    use TypedTextContentTrait;


    /** @var string */
    public const TEXTCONTENT_TYPE = StringValue::class;


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \SimpleSAML\XMLSchema\Exception\SchemaViolationException on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        $dom = new DOMXPath(DOMDocumentFactory::create());
        $result = $dom->evaluate($content);
        Assert::isInstanceOf($result, DOMNodeList::class);
    }
}

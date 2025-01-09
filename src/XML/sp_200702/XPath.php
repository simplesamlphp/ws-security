<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\sp_200702;

use DOMNodeList;
use DOMXPath;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\XML\DOMDocumentFactory;
use SimpleSAML\XML\StringElementTrait;

/**
 * An XPath element
 *
 * @package simplesamlphp/ws-security
 */
final class XPath extends AbstractSpElement
{
    use StringElementTrait;


    /**
     * Initialize an XPath.
     *
     * @param string $content
     */
    public function __construct(
        string $content,
    ) {
        $this->setContent($content);
    }


    /**
     * Validate the content of the element.
     *
     * @param string $content  The value to go in the XML textContent
     * @throws \SimpleSAML\XML\Exception\SchemaViolationException on failure
     * @return void
     */
    protected function validateContent(string $content): void
    {
        $dom = new DOMXPath(DOMDocumentFactory::create());
        $result = $dom->evaluate($content);
        Assert::isInstanceOf($result, DOMNodeList::class);
    }
}

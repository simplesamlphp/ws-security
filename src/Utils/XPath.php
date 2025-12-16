<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\Utils;

use DOMNode;
use DOMXPath;
use SimpleSAML\WSSecurity\Constants as C;

/**
 * Compilation of utilities for XPath.
 *
 * @package simplesamlphp/wssecurity
 */
class XPath extends \SimpleSAML\XMLSecurity\Utils\XPath
{
    /*
     * Get a DOMXPath object that can be used to search for WS Security elements.
     *
     * @param \DOMNode $node The document to associate to the DOMXPath object.
     * @param bool $autoregister Whether to auto-register all namespaces used in the document
     *
     * @return \DOMXPath A DOMXPath object ready to use in the given document, with several
     *   ws-related namespaces already registered.
     */
    public static function getXPath(DOMNode $node, bool $autoregister = false): DOMXPath
    {
        $xp = parent::getXPath($node, $autoregister);

        $xp->registerNamespace('auth', C::NS_AUTH);
        $xp->registerNamespace('fed', C::NS_FED);
        $xp->registerNamespace('t', C::NS_TRUST_200502);
        $xp->registerNamespace('trust', C::NS_TRUST_200512);
        $xp->registerNamespace('sp11', C::NS_SEC_POLICY_11);
        $xp->registerNamespace('sp12', C::NS_SEC_POLICY_12);

        return $xp;
    }
}

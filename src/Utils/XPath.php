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
     *
     * @return \DOMXPath A DOMXPath object ready to use in the given document, with several
     *   ws-related namespaces already registered.
     */
    public static function getXPath(DOMNode $node): DOMXPath
    {
        $xp = parent::getXPath($node);

        $xp->registerNamespace('wsa', C::NS_ADDR_200508);
        $xp->registerNamespace('wsa', C::NS_ADDR_200408);
        $xp->registerNamespace('auth', C::NS_AUTH);
        $xp->registerNamespace('fed', C::NS_FED);
        $xp->registerNamespace('trust', C::NS_TRUST);
        $xp->registerNamespace('policy', C::NS_POLICY);
        $xp->registerNamespace('sp11', C::NS_SEC_POLICY_11);
        $xp->registerNamespace('sp12', C::NS_SEC_POLICY_12);
        $xp->registerNamespace('wsdl', C::NS_WS_DESCRIPTION_LANGUAGE);
        $xp->registerNamespace('wsse', C::NS_SEC_EXT);
        $xp->registerNamespace('wsu', C::NS_SEC_UTIL);

        return $xp;
    }
}

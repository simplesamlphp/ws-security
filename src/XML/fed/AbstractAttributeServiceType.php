<?php

declare(strict_types=1);

namespace SimpleSAML\WSSecurity\XML\fed;

use DOMElement;
use SimpleSAML\SAML2\Type\SAMLAnyURIValue;
use SimpleSAML\SAML2\Type\SAMLAnyURIListValue;
use SimpleSAML\SAML2\Type\SAMLDateTimeValue;
use SimpleSAML\SAML2\Type\SAMLStringValue;
use SimpleSAML\SAML2\XML\md\Extensions;
use SimpleSAML\SAML2\XML\md\Organization;
use SimpleSAML\WSSecurity\Assert\Assert;
use SimpleSAML\WSSecurity\Constants as C;
use SimpleSAML\XMLSchema\Exception\MissingElementException;
use SimpleSAML\XMLSchema\Exception\SchemaViolationException;
use SimpleSAML\XMLSchema\Type\DurationValue;
use SimpleSAML\XMLSchema\Type\IDValue;
use SimpleSAML\XMLSchema\Type\QNameValue;

/**
 * A AttributeServiceType
 *
 * @package simplesamlphp/ws-security
 */
abstract class AbstractAttributeServiceType extends AbstractWebServiceDescriptorType
{
    /** @var string */
    public const XSI_TYPE_PREFIX = 'fed';

    /** @var string */
    public const XSI_TYPE_NAME = 'AttributeServiceType';

    /** @var string */
    public const XSI_TYPE_NAMESPACE = C::NS_FED;


    /**
     * AttributeServiceType constructor.
     *
     * @param \SimpleSAML\XMLSchema\Type\QNameValue $type The xsi-type of the element
     * @param \SimpleSAML\SAML2\Type\SAMLAnyURIListValue $protocolSupportEnumeration A set of URI specifying the protocols supported.
     * @param \SimpleSAML\XMLSchema\Type\IDValue|null $ID The ID for this document. Defaults to null.
     * @param \SimpleSAML\SAML2\Type\SAMLDateTimeValue|null $validUntil Unix time of validity for this document. Defaults to null.
     * @param \SimpleSAML\XMLSchema\Type\DurationValue|null $cacheDuration Maximum time this document can be cached. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\Extensions|null $extensions An array of extensions. Defaults to an empty array.
     * @param \SimpleSAML\SAML2\Type\SAMLAnyURIValue|null $errorURL An URI where to redirect users for support. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\KeyDescriptor[] $keyDescriptor An array of KeyDescriptor elements.
     *   Defaults to an empty array.
     * @param \SimpleSAML\SAML2\XML\md\Organization|null $organization
     *   The organization running this entity. Defaults to null.
     * @param \SimpleSAML\SAML2\XML\md\ContactPerson[] $contact An array of contacts for this entity.
     *   Defaults to an empty array.
     * @param list<\SimpleSAML\XML\Attribute> $namespacedAttributes
     * @param \SimpleSAML\WSSecurity\XML\fed\LogicalServiceNamesOffered|null $logicalServiceNamesOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\TokenTypesOffered|null $tokenTypesOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimDialectsOffered|null $claimDialectsOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimTypesOffered|null $claimTypesOffered
     * @param \SimpleSAML\WSSecurity\XML\fed\ClaimTypesRequested|null $claimTypesRequested
     * @param \SimpleSAML\WSSecurity\XML\fed\AutomaticPseudonyms|null $automaticPseudonyms
     * @param \SimpleSAML\WSSecurity\XML\fed\TargetScopes|null $targetScopes
     * @param \SimpleSAML\SAML2\Type\SAMLStringValue|null $serviceDisplayName
     * @param \SimpleSAML\SAML2\Type\SAMLStringValue|null $serviceDescription
     * @param \SimpleSAML\WSSecurity\XML\fed\AttributeServiceEndpoint[] $attributeServiceEndpoint
     * @param \SimpleSAML\WSSecurity\XML\fed\SingleSignOutNotificationEndpoint[] $singleSignOutNotificationEndpoint
     */
    final public function __construct(
        QNameValue $type,
        SAMLAnyURIListValue $protocolSupportEnumeration,
        ?IDValue $ID = null,
        ?SAMLDateTimeValue $validUntil = null,
        ?DurationValue $cacheDuration = null,
        ?Extensions $extensions = null,
        ?SAMLAnyURIValue $errorURL = null,
        array $keyDescriptor = [],
        ?Organization $organization = null,
        array $contact = [],
        array $namespacedAttributes = [],
        ?LogicalServiceNamesOffered $logicalServiceNamesOffered = null,
        ?TokenTypesOffered $tokenTypesOffered = null,
        ?ClaimDialectsOffered $claimDialectsOffered = null,
        ?ClaimTypesOffered $claimTypesOffered = null,
        ?ClaimTypesRequested $claimTypesRequested = null,
        ?AutomaticPseudonyms $automaticPseudonyms = null,
        ?TargetScopes $targetScopes = null,
        ?SAMLStringValue $serviceDisplayName = null,
        ?SAMLStringValue $serviceDescription = null,
        protected array $attributeServiceEndpoint = [],
        protected array $singleSignOutNotificationEndpoint = [],
    ) {
        Assert::minCount($attributeServiceEndpoint, 1, MissingElementException::class);
        Assert::allIsInstanceOf(
            $attributeServiceEndpoint,
            AttributeServiceEndpoint::class,
            SchemaViolationException::class,
        );
        Assert::allIsInstanceOf(
            $singleSignOutNotificationEndpoint,
            SingleSignOutNotificationEndpoint::class,
            SchemaViolationException::class,
        );

        parent::__construct(
            $type,
            $protocolSupportEnumeration,
            $ID,
            $validUntil,
            $cacheDuration,
            $extensions,
            $errorURL,
            $keyDescriptor,
            $organization,
            $contact,
            $namespacedAttributes,
            $logicalServiceNamesOffered,
            $tokenTypesOffered,
            $claimDialectsOffered,
            $claimTypesOffered,
            $claimTypesRequested,
            $automaticPseudonyms,
            $targetScopes,
            $serviceDisplayName,
            $serviceDescription,
        );
    }


    /**
     * Collect the value of the attributeServicEndpoint-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\AttributeServiceEndpoint[]
     */
    public function getAttributeServiceEndpoint(): array
    {
        return $this->attributeServiceEndpoint;
    }


    /**
     * Collect the value of the singleSignOutNotificationtionEndpoint-property
     *
     * @return \SimpleSAML\WSSecurity\XML\fed\SingleSignOutNotificationEndpoint[]
     */
    public function getSingleSignOutNotificationEndpoint(): array
    {
        return $this->singleSignOutNotificationEndpoint;
    }


    /**
     * Convert this element to XML.
     *
     * @param \DOMElement|null $parent The element we should append this element to.
     * @return \DOMElement
     */
    public function toUnsignedXML(?DOMElement $parent = null): DOMElement
    {
        $e = parent::toXML($parent);

        foreach ($this->getAttributeServiceEndpoint() as $ase) {
            $ase->toXML($e);
        }

        foreach ($this->getSingleSignOutNotificationEndpoint() as $ssone) {
            $ssone->toXML($e);
        }

        return $e;
    }
}

<?php

declare(strict_types=1);

/*
 * This file is part of the PrestashopWebservice package.
 *
 * (c) Loïc Sapone <loic@sapone.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace IQ2i\PrestashopWebservice\Util;

class PropertyFormatGuesser
{
    public static function guessType(string $format): ?string
    {
        if (!isset(self::MAP[$format])) {
            return null;
        }

        return self::MAP[$format];
    }

    private const MAP = [
        'isIp2Long'                   => 'string',
        'isAnything'                  => null,
        'isEmail'                     => 'string',
        'isModuleUrl'                 => 'string',
        'isMd5'                       => 'string',
        'isSha1'                      => 'string',
        'isFloat'                     => 'float',
        'isUnsignedFloat'             => 'float',
        'isOptFloat'                  => 'float',
        'isCarrierName'               => 'string',
        'isImageSize'                 => 'int',
        'isCustomerName'              => 'string',
        'isName'                      => 'string',
        'isHookName'                  => 'string',
        'isMailName'                  => 'string',
        'isMailSubject'               => 'string',
        'isModuleName'                => 'string',
        'isTplName'                   => 'string',
        'isImageTypeName'             => 'string',
        'isPrice'                     => 'float',
        'isNegativePrice'             => 'float',
        'isLanguageIsoCode'           => 'string',
        'isLanguageCode'              => 'string',
        'isLocale'                    => 'string',
        'isStateIsoCode'              => 'string',
        'isNumericIsoCode'            => 'string',
        'isDiscountName'              => 'string',
        'isCatalogName'               => 'string',
        'isMessage'                   => 'string',
        'isCountryName'               => 'string',
        'isLinkRewrite'               => 'string',
        'isRoutePattern'              => 'string',
        'isAddress'                   => 'string',
        'isCityName'                  => 'string',
        'isValidSearch'               => 'string',
        'isGenericName'               => 'string',
        'isCleanHtml'                 => 'string',
        'isReference'                 => 'string',
        'isPasswd'                    => 'string',
        'isPlaintextPassword'         => 'string',
        'isHashedPassword'            => 'string',
        'isPasswdAdmin'               => 'string',
        'isConfigName'                => 'string',
        'isPhpDateFormat'             => 'string',
        'isDateFormat'                => '\DateTime',
        'isDate'                      => '\DateTime',
        'isDateOrNull'                => '\DateTime',
        'isBirthDate'                 => '\DateTime',
        'isBool'                      => 'bool',
        'isPhoneNumber'               => 'string',
        'isEan13'                     => 'string',
        'isIsbn'                      => 'string',
        'isUpc'                       => 'string',
        'isPostCode'                  => 'string',
        'isZipCodeFormat'             => 'string',
        'isOrderWay'                  => 'string',
        'isOrderBy'                   => 'string',
        'isTableOrIdentifier'         => 'string',
        'isTagsList'                  => 'string',
        'isProductVisibility'         => 'string',
        'isInt'                       => 'int',
        'isUnsignedInt'               => 'int',
        'isPercentage'                => 'float',
        'isUnsignedId'                => 'int',
        'isNullOrUnsignedId'          => 'int',
        'isLoadedObject'              => null,
        'isColor'                     => 'string',
        'isUrl'                       => 'string',
        'isTrackingNumber'            => 'string',
        'isUrlOrEmpty'                => 'string',
        'isAbsoluteUrl'               => 'string',
        'isMySQLEngine'               => 'string',
        'isUnixName'                  => 'string',
        'isTablePrefix'               => 'string',
        'isFileName'                  => 'string',
        'isDirName'                   => 'string',
        'isTabName'                   => 'string',
        'isWeightUnit'                => 'string',
        'isDistanceUnit'              => 'string',
        'isSubDomainName'             => 'string',
        'isVoucherDescription'        => 'string',
        'isSortDirection'             => 'string',
        'isLabel'                     => 'string',
        'isPriceDisplayMethod'        => 'int',
        'isDniLite'                   => 'string',
        'isCookie'                    => null,
        'isString'                    => 'string',
        'isReductionType'             => 'string',
        'isBoolId'                    => null,
        'isLocalizationPackSelection' => 'string',
        'isSerializedArray'           => 'string',
        'isJson'                      => 'string',
        'isCoordinate'                => 'float',
        'isLangIsoCode'               => 'string',
        'isLanguageFileName'          => 'string',
        'isArrayWithIds'              => null,
        'isStockManagement'           => 'string',
        'isSiret'                     => 'string',
        'isApe'                       => 'string',
        'isControllerName'            => 'string',
        'isPrestaShopVersion'         => 'string',
        'isOrderInvoiceNumber'        => 'string',
        'isThemeName'                 => 'string',
        'isValidImapUrl'              => 'string',
    ];
}

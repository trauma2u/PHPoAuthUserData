<?php

/*
 * This file is part of the Oryzone PHPoAuthUserData package <https://github.com/Oryzone/PHPoAuthUserData>.
 *
 * (c) Oryzone, developed by Luciano Mammino <lmammino@oryzone.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace OAuth\UserData\Extractor;

use OAuth\UserData\Utils\ArrayUtils;
use OAuth\UserData\Utils\StringUtils;

/**
 * Class Facebook
 * @package OAuth\UserData\Extractor
 */
class Facebook extends LazyExtractor
{
    const REQUEST_PROFILE = '/me?fields=id,name,email,picture.width(240).height(240),gender';

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            self::getDefaultLoadersMap(),
            self::getDefaultNormalizersMap(),
            self::getSupportedFields()
        );
    }

    protected static function getSupportedFields()
    {
        return array(
            self::FIELD_UNIQUE_ID,
            self::FIELD_FULL_NAME,
            self::FIELD_EMAIL,
            self::FIELD_IMAGE_URL,
            self::FIELD_VERIFIED_EMAIL,
            self::FIELD_EXTRA
        );
    }

    protected function profileLoader()
    {
        return json_decode($this->service->request(self::REQUEST_PROFILE), true);
    }

    protected function uniqueIdNormalizer($data)
    {
        return $data['id'];
    }

    protected function fullNameNormalizer($data)
    {
        return isset($data['name']) ? $data['name'] : null;
    }

    protected function emailNormalizer($data)
    {
        return isset($data['email']) ? $data['email'] : null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['picture']['data']['url']) ? $data['picture']['data']['url'] : null;
    }

    public function verifiedEmailNormalizer()
    {
        return true;
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data, array(
            'id',
            'name',
            'email',
            'picture',
        ));
    }
}

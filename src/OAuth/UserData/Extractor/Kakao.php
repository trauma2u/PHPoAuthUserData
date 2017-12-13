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

/**
 * Class Kakao
 * @package OAuth\UserData\Extractor
 */
class Kakao extends LazyExtractor
{
    const REQUEST_PROFILE = 'https://kapi.kakao.com/v1/user/me';

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
        return isset($data['id']) ? $data['id'] : null;
    }

    protected function emailNormalizer($data)
    {
        return isset($data['kaccount_email']) ? $data['kaccount_email'] : null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['properties']['profile_image']) ? $data['properties']['profile_image'] : null;
    }

    protected function verifiedEmailNormalizer($data)
    {
        return isset($data['kaccount_email_verified']) ? !!$data['kaccount_email_verified'] : false;
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data['properties'], array(
            'profile_image',
        ));
    }
}

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
 * Class Naver
 * @package OAuth\UserData\Extractor
 */
class Naver extends LazyExtractor
{
    const REQUEST_PROFILE = 'https://openapi.naver.com/v1/nid/me';

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
            self::FIELD_USERNAME,
            self::FIELD_FULL_NAME,
            self::FIELD_EMAIL,
            self::FIELD_IMAGE_URL,
            self::FIELD_EXTRA
        );
    }

    protected function profileLoader()
    {
        return json_decode($this->service->request(self::REQUEST_PROFILE), true);
    }

    protected function uniqueIdNormalizer($data)
    {
        return isset($data['response']['id']) ? $data['response']['id'] : null;
    }

    protected function usernameNormalizer($data)
    {
        if (!isset($data['response']['email'])) return null;
        $exploded = explode('@', $data['response']['email']);
        return $exploded[0];
    }

    protected function emailNormalizer($data)
    {
        return isset($data['response']['email']) ? $data['response']['email'] : null;
    }

    protected function fullNameNormalizer($data)
    {
        return isset($data['response']['name']) ? $data['response']['name'] : null;
    }

    protected function imageUrlNormalizer($data)
    {
        return isset($data['response']['profile_image']) ? $data['response']['profile_image'] : null;
    }

    protected function extraNormalizer($data)
    {
        return ArrayUtils::removeKeys($data['response'], array(
            'id',
            'email',
            'name',
            'profile_image',
        ));
    }
}

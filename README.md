PHPoAuthLib
===========
The Forked Project of [Oryzone/PHPoAuthUserData](https://github.com/Oryzone/PHPoAuthUserData) for Korean Providers

Installation
------------
```json
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/trauma2u/PHPoAuthUserData"
        }
    ],
    "require": {
        "oryzone/oauth-user-data": "dev-master"
    }
}
```

Added Korean Providers
---------------------
- Kakao

Provider: Naver
---------------------
```php
/** @var \OAuth\Common\Service\ServiceInterface $naverService */
$extractorFactory = new \OAuth\UserData\ExtractorFactory();
$extractor = $extractorFactory->get($naverService);
$extractor->getUniqueId(); // 19740816
$extractor->getUsername(); // trauma2u
$extractor->getFullName(); // 정양파
$extractor->getEmail(); // trauma2u@naver.com
$extractor->getImageUrl(); // https://phinf.pstatic.net/contact/5/2015/11/25/trauma2u_1448456272639.jpg
$extractor->getExtras(); // nickname, enc_id, age, gender, birthday, etc.
```

<?php declare(strict_types = 1);

namespace Fr05t1k\SlimExample\Provider\Facebook;

use Facebook\Facebook;
use Interop\Container\ContainerInterface;

class FacebookProviderFactory
{
    /**
     * @param ContainerInterface $c
     * @return FacebookProvider
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Facebook\Exceptions\FacebookSDKException
     */
    public function create(ContainerInterface $c)
    {
        $facebookClient = new Facebook([
            'app_id' => $c->get('settings.providers.facebook.appId'),
            'app_secret' => $c->get('settings.providers.facebook.secret'),
        ]);
        return new FacebookProvider($facebookClient);
    }
}

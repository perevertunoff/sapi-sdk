<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Perevertunoff\MyToolsPhp\Functions\ArrayFunctions;
use Perevertunoff\MyToolsPhp\Specifics\Profile as BaseProfile;

class Profile extends BaseProfile
{
    private $requestStack;

    public function __construct(ParameterBagInterface $parameterBagInterface, RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;

        parent::__construct($parameterBagInterface->get('kernel.project_dir') . '/config/profiles');
    }

    protected function returnDetectedProfile(?array $profiles = null)
    {
        $profile_name = $this->requestStack->getCurrentRequest()->get('profile_name');
        $access_key = $this->requestStack->getCurrentRequest()->get('access_key');

        if ($profiles && $profile_name && $access_key) {
            if (isset($profiles[$profile_name]['access_key']) && $profiles[$profile_name]['access_key'] && $profiles[$profile_name]['access_key'] === $access_key) {
                return [$profile_name => $profiles[$profile_name]];
            }
        }

        return false;
    }
}

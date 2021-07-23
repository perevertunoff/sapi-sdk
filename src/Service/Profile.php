<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Perevertunoff\MyToolsPhp\Specifics\Profile as BaseProfile;

class Profile extends BaseProfile
{
    public function __construct(ParameterBagInterface $parameterBagInterface)
    {
        parent::__construct($parameterBagInterface->get('kernel.project_dir') . '/config/profiles');
    }
}

<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AccessKey
{
    const KEY_NAME = 'access_key';

    private $is_allowed;

    public function __construct(RequestStack $requestStack, ParameterBagInterface $parameterBagInterface)
    {
        $key_env = $parameterBagInterface->get(self::KEY_NAME);
        $key_input = $requestStack->getCurrentRequest()->get(self::KEY_NAME);

        if ($key_env && $key_input && $key_env == $key_input) {
            $this->is_allowed = true;
        } else {
            $this->is_allowed = false;
        }
    }

    public function isAllowed()
    {
        if ($this->is_allowed) return true;
        return false;
    }

    public function isNotAllowed()
    {
        if (!$this->isAllowed()) return true;
        return false;
    }
}

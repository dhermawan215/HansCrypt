<?php

namespace HansCrypt\Integrations\Symfony;

use HansCrypt\Integrations\Symfony\DependencyInjection\HansCryptExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class HansCryptBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new HansCryptExtension();
    }
}

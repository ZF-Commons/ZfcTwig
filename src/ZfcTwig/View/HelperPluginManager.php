<?php

namespace ZfcTwig\View;

use Zend\View\HelperPluginManager as ParentHelperPluginManager;

class HelperPluginManager extends ParentHelperPluginManager
{
    /**
     * {{@inheritDoc}
     */
    protected function retrieveFromPeeringManager($name)
    {
        foreach ($this->peeringServiceManagers as $peeringServiceManager) {
            if ($peeringServiceManager->has($name)) {
                $helper = $peeringServiceManager->create($name);
                $this->injectRenderer($helper);
                $this->injectTranslator($helper);
                return $helper;
            }
        }
        return null;
    }
}
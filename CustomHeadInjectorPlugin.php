<?php

/**
 * @file plugins/generic/customHeadInjector/CustomHeadInjectorPlugin.php
 *
 * Copyright (c) 2026 Oscar R. Gómez <info@menteclara.org>
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @class CustomHeadInjectorPlugin
 *
 * @ingroup plugins_generic_customHeadInjector
 *
 * @brief Custom Head Injector plugin class for MOJP 4.0 compatible with OJS 3.5.0.5 or higher
 */

namespace APP\plugins\generic\customHeadInjector;

use APP\core\Application;
use APP\template\TemplateManager;
use PKP\core\JSONMessage;
use PKP\linkAction\LinkAction;
use PKP\linkAction\request\AjaxModal;
use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;
use PKP\core\PKPPageRouter;

class CustomHeadInjectorPlugin extends GenericPlugin
{
    /**
     * @copydoc Plugin::register()
     *
     * @param null|mixed $mainContextId
     */
    public function register($category, $path, $mainContextId = null)
    {
        $success = parent::register($category, $path, $mainContextId);
        if (Application::isUnderMaintenance()) {
            return true;
        }
        if ($success && $this->getEnabled($mainContextId)) {
            Hook::add('TemplateManager::display', $this->injectCustomHead(...));
        }
        return $success;
    }

    /**
     * @copydoc Plugin::getDisplayName()
     */
    public function getDisplayName()
    {
        return __('plugins.generic.customHeadInjector.displayName');
    }

    /**
     * @copydoc Plugin::getDescription()
     */
    public function getDescription()
    {
        return __('plugins.generic.customHeadInjector.description');
    }

    /**
     * @copydoc Plugin::getActions()
     */
    public function getActions($request, $verb)
    {
        $router = $request->getRouter();
        return array_merge(
            $this->getEnabled() ? [
                new LinkAction(
                    'settings',
                    new AjaxModal(
                        $router->url($request, null, null, 'manage', null, ['verb' => 'settings', 'plugin' => $this->getName(), 'category' => 'generic']),
                        $this->getDisplayName()
                    ),
                    __('manager.plugins.settings'),
                    null
                ),
            ] : [],
            parent::getActions($request, $verb)
        );
    }

    /**
     * @copydoc Plugin::manage()
     */
    public function manage($args, $request)
    {
        switch ($request->getUserVar('verb')) {
            case 'settings':
                $context = $request->getContext();
                $templateMgr = TemplateManager::getManager($request);
                $templateMgr->registerPlugin('function', 'plugin_url', $this->smartyPluginUrl(...));

                $form = new CustomHeadInjectorSettingsForm($this, $context->getId());

                if ($request->getUserVar('save')) {
                    $form->readInputData();
                    if ($form->validate()) {
                        $form->execute();
                        return new JSONMessage(true);
                    }
                } else {
                    $form->initData();
                }
                return new JSONMessage(true, $form->fetch($request));
        }
        return parent::manage($args, $request);
    }

    /**
     * Asignar el código guardado a la variable de Smarty con logs de depuración
     *
     * @param string $hookName
     * @param array $params
     */
    public function injectCustomHead($hookName, $params)
    {
        

        $request = Application::get()->getRequest();
        $context = $request->getContext();
        if (!$context) {
           
            return false;
        }
        $router = $request->getRouter();
        if (!$router instanceof PKPPageRouter) {
           
            return false;
        }

        $customHeadCode = $this->getSetting($context->getId(), 'customHeadCode');
        if (empty($customHeadCode)) {
           
            return false;
        }

        

        $templateMgr = TemplateManager::getManager($request);
        
        // Asignamos directamente a la variable de Smarty para que headerHead.tpl la pinte
        $templateMgr->assign('customHeadInjectorCode', $customHeadCode);

       

        return false;
    }
}

if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\generic\customHeadInjector\CustomHeadInjectorPlugin', '\CustomHeadInjectorPlugin');
}
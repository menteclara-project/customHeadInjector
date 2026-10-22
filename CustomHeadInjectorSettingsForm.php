<?php

/**
 * @file plugins/generic/customHeadInjector/CustomHeadInjectorSettingsForm.php
 *
 * Copyright (c) 2026 Oscar R. Gómez <info@menteclara.org>
 * Distributed under the GNU GPL v3. For full terms see the file LICENSE.
 *
 * @class CustomHeadInjectorSettingsForm
 *
 * @ingroup plugins_generic_customHeadInjector
 *
 * @brief Form for journal managers to modify Custom Head Injector plugin settings

 */

namespace APP\plugins\generic\customHeadInjector;

use APP\template\TemplateManager;
use PKP\form\Form;

class CustomHeadInjectorSettingsForm extends Form
{
    /** @var int */
    public $_journalId;

    /** @var object */
    public $_plugin;

    /**
     * Constructor
     *
     * @param CustomHeadInjectorPlugin $plugin
     * @param int $journalId
     */
    public function __construct($plugin, $journalId)
    {
        $this->_journalId = $journalId;
        $this->_plugin = $plugin;

        parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));

        // El campo es opcional ya que no todas las revistas usarán inyecciones avanzadas
        // Quitamos la validación estricta de ID de Google y dejamos el campo libre
        $this->addCheck(new \PKP\form\validation\FormValidatorPost($this));
        $this->addCheck(new \PKP\form\validation\FormValidatorCSRF($this));
    }

    /**
     * Initialize form data.
     */
    public function initData()
    {
        $this->_data = [
            'customHeadCode' => $this->_plugin->getSetting($this->_journalId, 'customHeadCode'),
        ];
    }

    /**
     * Assign form data to user-submitted data.
     */
    public function readInputData()
    {
        $this->readUserVars(['customHeadCode']);
    }

    /**
     * @copydoc Form::fetch()
     *
     * @param null|mixed $template
     */
    public function fetch($request, $template = null, $display = false)
    {
        $templateMgr = TemplateManager::getManager($request);
        $templateMgr->assign('pluginName', $this->_plugin->getName());
        return parent::fetch($request, $template, $display);
    }

    /**
     * @copydoc Form::execute()
     */
    public function execute(...$functionArgs)
    {
        // Guardamos el bloque completo de código HTML/Schema tal cual lo ingresó el usuario
        $this->_plugin->updateSetting(
            $this->_journalId, 
            'customHeadCode', 
            $this->getData('customHeadCode'), 
            'string'
        );
        
        parent::execute(...$functionArgs);
    }
}

if (!PKP_STRICT_MODE) {
    class_alias('\APP\plugins\generic\customHeadInjector\CustomHeadInjectorSettingsForm', '\CustomHeadInjectorSettingsForm');
}
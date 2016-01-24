<?php
namespace Futjikato\PluginTsView\Controller;

use TYPO3\Flow\Mvc\Controller\ActionController;

/**
 * Controller for plugins with typoscript renderer
 */
abstract class PluginController extends ActionController
{
    /**
     * {@inheritdoc}
     *
     * @var string
     * @api
     */
    protected $defaultViewObjectName = 'Futjikato\PluginTsView\View\TypoScriptView';

    /**
     * Initialize view with default typoscript path for the plugin view
     *
     * @param \TYPO3\Flow\Mvc\View\ViewInterface $view The view to be initialized
     * @return void
     * @api
     */
    protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
        $request = $this->request;
        $packageKey = str_replace('.', '', $request->getControllerPackageKey());
        $controllerName = $request->getControllerName();
        $actionName = $request->getControllerActionName();
        $view->setTypoScriptPath(sprintf('plugins/%s/%s/%s', $packageKey, $controllerName, $actionName));

        $node = $request->getInternalArgument('__node');
        $view->assign('value', $node);
    }
}

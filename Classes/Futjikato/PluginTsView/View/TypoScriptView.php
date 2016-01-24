<?php
namespace Futjikato\PluginTsView\View;

use TYPO3\Flow\I18n\Locale;
use TYPO3\Neos\View\TypoScriptView as NeosTypoScriptView;
use TYPO3\TypoScript\Exception\RuntimeException;

/**
 * TypoScript view with view variables assigned
 */
class TypoScriptView extends NeosTypoScriptView
{
    /**
     * Renders the view
     *
     * @return string The rendered view
     * @throws \Exception if no node is given
     * @api
     */
    public function render()
    {
        $currentNode = $this->getCurrentNode();
        $currentSiteNode = $currentNode->getContext()->getCurrentSiteNode();
        $typoScriptRuntime = $this->getTypoScriptRuntime($currentSiteNode);

        $dimensions = $currentNode->getContext()->getDimensions();
        if (array_key_exists('language', $dimensions) && $dimensions['language'] !== array()) {
            $currentLocale = new Locale($dimensions['language'][0]);
            $this->i18nService->getConfiguration()->setCurrentLocale($currentLocale);
            $this->i18nService->getConfiguration()->setFallbackRule(array('strict' => false, 'order' => array_reverse($dimensions['language'])));
        }

        $baseContext = [
            'node' => $currentNode,
            'documentNode' => $this->getClosestDocumentNode($currentNode) ?: $currentNode,
            'site' => $currentSiteNode,
            'editPreviewMode' => isset($this->variables['editPreviewMode']) ? $this->variables['editPreviewMode'] : null
        ];
        $typoScriptRuntime->pushContextArray(array_merge($this->variables, $baseContext));
        try {
            $output = $typoScriptRuntime->render($this->typoScriptPath);
            $output = $this->mergeHttpResponseFromOutput($output, $typoScriptRuntime);
        } catch (RuntimeException $exception) {
            throw $exception->getPrevious();
        }
        $typoScriptRuntime->popContext();

        return $output;
    }
}
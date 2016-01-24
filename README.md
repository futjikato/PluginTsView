# TypoScript Plugin View

Very minimal package to provide an abstract controller for plugins to render with TS viewer.

Concept from https://discuss.neos.io/t/whats-the-best-way-to-render-nodes-inside-a-plugin-using-typoscript/42/2

## Usage

For the plugin controller use the provided abstract controller

```
use Futjikato\PluginTsView\Controller\PluginController;

class ContentPluginController extends PluginController
{
```

For rendering a typoscript path at path plugins.<PackageKey>.<ControllerName>.<ActionName> is used.
In the package key the dot is removed so for the above example the path is: `plugins.FutjikatoDevSite.ContentPlugin.index`
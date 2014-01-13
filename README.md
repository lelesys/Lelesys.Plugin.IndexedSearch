Lelesys IndexedSearch Plugin
======================

This plugin adds IndexedSearch to your websites.

##### Important note: Initial package development was done when TYPO3 Neos was at alpha3/4. We are working hard continuously to get this to work perfectly and to beautify source code using best practices/concepts of Flow/Neos. Stay tuned!

Quick start
-----------

* include the plugin's Stylesheet to your own one's where you add other stylesheets of the site.

``
<link href="{f:uri.resource(path: 'resource://Lelesys.Plugin.IndexedSearch/Public/Stylesheets/IndexedSearch.css')}" rel="stylesheet" media="screen">
``

* include the plugin's Javascript to your own one's where you add other javascript of the site.

``<script src="{f:uri.resource(path: 'resource://Lelesys.Plugin.IndexedSearch/Public/JavaScript/IndexedSearch.js')}"></script>
``

* you can add search box in two ways:
 *  add the plugin content element "Indexed Search Box" to the position of your choice, to add search box.
 * render the plugin using typoscript (located in, for example, Packages/Sites/Your.Site/Resources/Private/TypoScript/Root.ts2) with:
  ` object = Lelesys.Plugin.IndexedSearch:IndexedSearch`
* create hide in menu page to show Indexed search result and give Name (URL) as "searchresult"
* add the plugin content element "Indexed Search Result" to this page
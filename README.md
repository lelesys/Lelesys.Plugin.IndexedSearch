Lelesys IndexedSearch Plugin
======================

This plugin adds IndexedSearch to your websites.

Warning: This plugin is experimental.

Quick start
-----------

* include the plugin's TypoScript definitions to your own one's (located in, for example, `Packages/Sites/Your.Site/Resources/Private/TypoScripts/Library/ContentElements.ts2`) with:

``
include: resource://Lelesys.Plugin.IndexedSearch/Private/TypoScripts/Library/NodeTypes.ts2
``

* include the plugin's Stylesheet to your own one's where you add other stylesheets of the site.

``
<link href="{f:uri.resource(path: 'resource://Lelesys.Plugin.IndexedSearch/Public/Stylesheets/IndexedSearch.css')}" rel="stylesheet" media="screen">
``

* include the plugin's Javascript to your own one's where you add other javascript of the site.

``<script src="{f:uri.resource(path: 'resource://Lelesys.Plugin.IndexedSearch/Public/JavaScript/IndexedSearch.js')}"></script>
``

* you can add search box in two ways:
 *  add the plugin content element "Indexed Search Box" to the position of your choice, to add search box.
 * render the plugin using typoscript (located in, for example, Packages/Sites/Your.Site/Resources/Private/TypoScripts/Library/Root.ts2) with:
  ` object = Lelesys.Plugin.IndexedSearch:IndexedSearch`
* create hide in menu page to show Indexed search result and give Name (URL) as "searchresult"
* add the plugin content element "Indexed Search Result" to this page
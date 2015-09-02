<?php
namespace Lelesys\Plugin\IndexedSearch\Controller;

/*                                                                         *
 * This script belongs to the package "Lelesys.Plugin.IndexedSearch".      *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;

class IndexedSearchController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @Flow\Inject
	 * @var \Lelesys\Plugin\IndexedSearch\Domain\Service\IndexedSearchService
	 */
	protected $indexedSearchService;

	/**
	 * Settings
	 *
	 * @var array
	 */
	protected $settings;

	/**
	 * @param array $settings
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings;
	}

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param \TYPO3\Flow\Mvc\View\ViewInterface $view The view to be initialized
	 * @return void
	 * @api
	 */
	protected function initializeView(\TYPO3\Flow\Mvc\View\ViewInterface $view) {
			// set the template paths from the Settings
			// so that it can be changed per project
			// do this only if it is a TemplateView to avoid FATAL errors
		if ($view instanceof \TYPO3\Fluid\View\TemplateView) {
			$view->setTemplateRootPath($this->settings['templateRootPath']);
		}
	}

	/**
	 *
	 * @return void
	 */
	public function indexAction() {
		$searchNode = $this->request->getInternalArgument('__searchResultsNode');
		if($searchNode != NULL) {
			$this->view->assign('searchNode', $searchNode);
		}
	}

	/**
	 * Search for all properties in node for given term
	 *
	 * @param string $searchParameter Search parameter
	 * @return void
	 */
	public function searchResultAction($searchParameter = NULL) {
		$searchTerm = $searchParameter;
		$searchArguments = $this->request->getHttpRequest()->getArgument('--lelesys_plugin_indexedsearch-indexedsearch');
		if ($searchArguments === NULL) {
			$searchArguments = $this->request->getHttpRequest()->getArgument('--typo3_neos_nodetypes-page');
			$searchTerm = $searchArguments['searchParameter'];
		}
		$currentNode = $this->request->getInternalArgument('__node');
		if ($searchTerm !== NULL && $searchTerm !== '') {
			$searchResults = $this->indexedSearchService->search($searchTerm, $currentNode);
			$this->view->assignMultiple(array ('searchResults'=> $searchResults, 'searchParameter' => $searchTerm));
		}
	}
}

?>
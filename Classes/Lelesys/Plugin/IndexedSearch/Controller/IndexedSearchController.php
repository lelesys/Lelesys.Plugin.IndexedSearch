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
	 *
	 * @return void
	 */
	public function indexAction() {
	}

	/**
	 * Search for all properties in node for given term
	 *
	 * @param string $searchParameter Search parameter
	 * @return void
	 */
	public function searchResultAction($searchParameter = NULL) {
		$currentNode = $this->request->getInternalArgument('__node');
		if ($searchParameter !== NULL) {
			$searchResults = $this->indexedSearchService->search($searchParameter, $currentNode);
			$this->view->assignMultiple(array ('searchResults'=> $searchResults, 'searchParameter' => $searchParameter));
		}
	}

}

?>
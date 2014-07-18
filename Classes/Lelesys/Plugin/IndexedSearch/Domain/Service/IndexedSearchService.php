<?php

namespace Lelesys\Plugin\IndexedSearch\Domain\Service;

/* *
 * This script belongs to the package "Lelesys.Plugin.IndexedSearch".      *
 *                                                                         *
 * It is free software; you can redistribute it and/or modify it under     *
 * the terms of the GNU Lesser General Public License, either version 3    *
 * of the License, or (at your option) any later version.                  *
 *                                                                         */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\Eel\FlowQuery\FlowQuery;

class IndexedSearchService {

	/**
	 * @Flow\Inject
	 * @var \TYPO3\Neos\Domain\Service\NodeSearchService
	 */
	protected $nodeSearchService;

	/**
	 * @Flow\Inject
	 * @var \TYPO3\TYPO3CR\Domain\Service\NodeTypeManager
	 */
	protected $nodeTypeManager;

	/**
	 * Search for all properties in node for given term
	 *
	 * @param string $searchParameter
	 * @param \TYPO3\TYPO3CR\Domain\Model\Node $currentNode Current node
	 * @return array
	 */
	public function search($searchParameter, \TYPO3\TYPO3CR\Domain\Model\Node $currentNode) {
		$nodes = $this->nodeSearchService->findByProperties($searchParameter, $this->getSearchabelNodeTypes(), $currentNode->getContext());
		$results = array();
		foreach ($nodes as $node) {
			$properties = $node->getProperties();
			foreach ($properties as $propetyName) {
                if (!is_object($propetyName)) {
                    $searchNode = strip_tags($propetyName);
                }
			}
			if ($node !== NULL && (string) $node->getNodeType() !== 'TYPO3.Neos:Document') {
				$flowQuery = new FlowQuery(array($node));
				$pageNode = $flowQuery->closest('[instanceof TYPO3.Neos:Document]')->get(0);
				if ($pageNode instanceof \TYPO3\TYPO3CR\Domain\Model\NodeInterface) {
					$pageTitle = $pageNode->getProperty('title');
					if (isset($searchNode) && isset($pageTitle)) {
						$results[] = array('searchNode' => $searchNode, 'pageNode' => $pageNode, 'pageTitle' => $pageTitle);
					}
				}
			}
		}

		return $results;
	}

	/**
	 * Get the searchable nodeTypes
	 *
	 * @return array
	 */
	public function getSearchabelNodeTypes() {
		$nodeTypes = array();
		$fullConfiguration = $this->nodeTypeManager->getNodeTypes(FALSE);
		foreach ($fullConfiguration as $key => $value) {
			$properties = $value->getProperties();
			if (!empty($properties)) {
				foreach ($properties as $property) {
					if (isset($property['searchable'])) {
						if ($property['searchable'] === TRUE) {
							$nodeTypes[] = $key;
						}
					}
				}
			}
		}
		return $nodeTypes;
	}

}

?>
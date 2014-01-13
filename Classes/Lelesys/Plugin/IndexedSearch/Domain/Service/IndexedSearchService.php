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
		$currentLocale = (string) $currentNode->getContext()->getLocale();
		$nodes = $this->nodeSearchService->findByProperties($searchParameter, $this->getSearchabelNodeTypes(), $currentNode->getContext());
		$results = array();
		foreach ($nodes as $node) {
			$properties = $node->getProperties();
			foreach ($properties as $propetyName) {
				if (is_array($propetyName)) {
					if (strpos(strip_tags($propetyName[$currentLocale]), $searchParameter) !== false) {
						$searchNode = strip_tags($propetyName[$currentLocale]);
					}
				} else {
					$searchNode = strip_tags($propetyName);
				}
			}
			while ($node !== NULL && (string) $node->getNodeType() !== 'TYPO3.Neos:Page') {
				$node = $node->getParent();
				$pageNode = $currentNode->getNode($node->getPath());
			}
			$pageProperties = $pageNode->getProperties();
			if (is_array($pageProperties['title'])) {
				$pageTitle = $pageProperties['title'][$currentLocale];
			} else {
				$pageTitle = $pageProperties['title'];
			}
			if (isset($searchNode) && isset($pageTitle)) {
				$results[] = array('searchNode' => $searchNode, 'pageNode' => $pageNode, 'pageTitle' => $pageTitle);
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
			if (isset($value['properties'])) {
				foreach ($value['properties'] as $propertyName => $propertyValue) {
					if (isset($propertyValue['searchable']) && isset($propertyValue['type'])) {
						if ($propertyValue['searchable'] === TRUE && $propertyValue['type'] === 'string') {
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
<?php
namespace Lelesys\Plugin\IndexedSearch\Domain\Service;

/*                                                                         *
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
	 * Search for all properties in node for given term
	 *
	 * @param string $searchParameter
	 * @param \TYPO3\TYPO3CR\Domain\Model\Node $currentNode Current node
	 * @return array
	 */
	public function search($searchParameter, \TYPO3\TYPO3CR\Domain\Model\Node $currentNode) {
		$searchNodeTypes = array ('TYPO3.Neos.NodeTypes:Text', 'TYPO3.Neos.NodeTypes:Html', 'TYPO3.Neos.NodeTypes:Headline');
		$nodes = $this->nodeSearchService->findByProperties($searchParameter, $searchNodeTypes);
		$results = array();
		foreach ($nodes as $node) {
			$resultNode = $node;
			while ($node !== NULL && (string) $node->getNodeType() !== 'TYPO3.Neos:Page') {
				$node = $node->getParent();
				$pageNode = $currentNode->getNode($node->getPath());
			}
			$results[] = array('searchNode' => $resultNode, 'pageNode' => $pageNode);
		}
		return $results;
	}

}

?>
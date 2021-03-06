<?php
namespace OliverKlee\Oelib\Domain\Repository\Traits;

use TYPO3\CMS\Extbase\Persistence\Generic\QuerySettingsInterface;

/**
 * This trait for repositories makes the repository ignore the storage page setting when fetching models.
 *
 * @deprecated Will be removed in oelib 3.0.0. Use StoragePageAgnostic (without the "Trait" suffix) instead.
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de
 */
trait StoragePageAgnosticTrait
{
    /**
     * @return void
     */
    public function initializeObject()
    {
        /** @var QuerySettingsInterface $querySettings */
        $querySettings = $this->objectManager->get(QuerySettingsInterface::class);
        $querySettings->setRespectStoragePage(false);
        $this->setDefaultQuerySettings($querySettings);
    }
}

<?php

use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * This class represents a registry for mappers. The mappers must be located in
 * the directory Mapper/ in each extension. Extension can use mappers from
 * other extensions as well.
 *
 * @author Oliver Klee <typo3-coding@oliverklee.de>
 */
class Tx_Oelib_MapperRegistry
{
    /**
     * @var \Tx_Oelib_MapperRegistry the Singleton instance
     */
    private static $instance = null;

    /**
     * @var \Tx_Oelib_DataMapper[] already created mappers (by class name)
     */
    private $mappers = [];

    /**
     * @var bool whether database access should be denied for mappers
     */
    private $denyDatabaseAccess = false;

    /**
     * @var bool whether this MapperRegistry is used in testing mode
     */
    private $testingMode = false;

    /**
     * @var \Tx_Oelib_TestingFramework the testingFramework to use in testing mode
     */
    private $testingFramework = null;

    /**
     * The constructor. Use getInstance() instead.
     */
    private function __construct()
    {
    }

    /**
     * Returns an instance of this class.
     *
     * @return \Tx_Oelib_MapperRegistry the current Singleton instance
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new \Tx_Oelib_MapperRegistry();
        }

        return self::$instance;
    }

    /**
     * Purges the current instance so that getInstance will create a new
     * instance.
     *
     * @return void
     */
    public static function purgeInstance()
    {
        self::$instance = null;
    }

    /**
     * Retrieves a dataMapper by class name.
     *
     * @throws \Tx_Oelib_Exception_NotFound if there is no such mapper
     *
     * @param string $className the name of an existing mapper class, must not be empty
     *
     * @return \Tx_Oelib_DataMapper the mapper with the class $className
     *
     * @see getByClassName
     */
    public static function get($className)
    {
        return self::getInstance()->getByClassName($className);
    }

    /**
     * Retrieves a dataMapper by class name.
     *
     * @param string $className the name of an existing mapper class, must not be empty
     *
     * @return \Tx_Oelib_DataMapper the requested mapper instance
     *
     * @throws \InvalidArgumentException
     */
    private function getByClassName($className)
    {
        if ($className === '') {
            throw new \InvalidArgumentException('$className must not be empty.', 1331488868);
        }
        $unifiedClassName = self::unifyClassName($className);

        if (!isset($this->mappers[$unifiedClassName])) {
            if (!class_exists($className, true)) {
                throw new \InvalidArgumentException(
                    'No mapper class "' . $className . '" could be found.'
                );
            }

            /** @var \Tx_Oelib_DataMapper $mapper */
            $mapper = GeneralUtility::makeInstance($unifiedClassName);
            $this->mappers[$unifiedClassName] = $mapper;
        } else {
            /** @var \Tx_Oelib_DataMapper $mapper */
            $mapper = $this->mappers[$unifiedClassName];
        }

        if ($this->testingMode) {
            $mapper->setTestingFramework($this->testingFramework);
        }
        if ($this->denyDatabaseAccess) {
            $mapper->disableDatabaseAccess();
        }

        return $mapper;
    }

    /**
     * Unifies a class name to a common format.
     *
     * @param string $className the class name to unify, must not be empty
     *
     * @return string the unified class name
     */
    protected static function unifyClassName($className)
    {
        return strtolower($className);
    }

    /**
     * Disables database access for all mappers received with get().
     *
     * @return void
     */
    public static function denyDatabaseAccess()
    {
        self::getInstance()->denyDatabaseAccess = true;
    }

    /**
     * Activates the testing mode. This automatically will activate the testing mode for all future mappers.
     *
     * @param \Tx_Oelib_TestingFramework $testingFramework
     *
     * @return void
     */
    public function activateTestingMode(\Tx_Oelib_TestingFramework $testingFramework)
    {
        $this->testingMode = true;
        $this->testingFramework = $testingFramework;
    }

    /**
     * Sets a mapper that can be returned via get.
     *
     * This function is a static public convenience wrapper for setByClassName.
     *
     * This function is to be used for testing purposes only.
     *
     * @param string $className the class name of the mapper to set
     * @param \Tx_Oelib_DataMapper $mapper
     *        the mapper to set, must be an instance of $className
     *
     * @see setByClassName
     *
     * @return void
     */
    public static function set($className, \Tx_Oelib_DataMapper $mapper)
    {
        self::getInstance()->setByClassName(self::unifyClassName($className), $mapper);
    }

    /**
     * Sets a mapper that can be returned via get.
     *
     * This function is to be used for testing purposes only.
     *
     * @param string $className the class name of the mapper to set
     * @param \Tx_Oelib_DataMapper $mapper
     *        the mapper to set, must be an instance of $className
     *
     * @return void
     */
    private function setByClassName($className, \Tx_Oelib_DataMapper $mapper)
    {
        if (!($mapper instanceof $className)) {
            throw new \InvalidArgumentException(
                'The provided mapper is not an instance of ' . $className . '.',
                1331488915
            );
        }
        if (isset($this->mappers[$className])) {
            throw new \BadMethodCallException(
                'There already is a ' . $className
                . ' mapper registered. Overwriting existing wrappers is not allowed.',
                1331488928
            );
        }

        $this->mappers[$className] = $mapper;
    }
}

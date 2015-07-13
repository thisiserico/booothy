<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ProdServiceContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class ProdServiceContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->parameters = $this->getDefaultParameters();

        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();
        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'photo.application.service.get_complete_collection' => 'getPhoto_Application_Service_GetCompleteCollectionService',
            'photo.domain.service.download_url_generator' => 'getPhoto_Domain_Service_DownloadUrlGeneratorService',
            'photo.infrastructure.hydrator.mongo.photo_collection' => 'getPhoto_Infrastructure_Hydrator_Mongo_PhotoCollectionService',
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped frozen container.');
    }

    /**
     * Gets the 'photo.application.service.get_complete_collection' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Core\Application\Service\Marshaller\UseCase A Booothy\Core\Application\Service\Marshaller\UseCase instance.
     */
    protected function getPhoto_Application_Service_GetCompleteCollectionService()
    {
        return $this->services['photo.application.service.get_complete_collection'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\Photo\Application\Service\GetCompleteCollection\UseCase(new \Booothy\Photo\Infrastructure\Repository\Mongo\NewerFirstLoader(new \MongoCollection(new \MongoDB(new \MongoClient(''), 'booothy'), 'photo'), $this->get('photo.infrastructure.hydrator.mongo.photo_collection'))), new \Booothy\Photo\Application\Marshaller\Collection($this->get('photo.domain.service.download_url_generator')));
    }

    /**
     * Gets the 'photo.domain.service.download_url_generator' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Photo\Domain\Service\DownloadUrlGenerator A Booothy\Photo\Domain\Service\DownloadUrlGenerator instance.
     */
    protected function getPhoto_Domain_Service_DownloadUrlGeneratorService()
    {
        return $this->services['photo.domain.service.download_url_generator'] = new \Booothy\Photo\Domain\Service\DownloadUrlGenerator('');
    }

    /**
     * Gets the 'photo.infrastructure.hydrator.mongo.photo_collection' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoCollection A Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoCollection instance.
     */
    protected function getPhoto_Infrastructure_Hydrator_Mongo_PhotoCollectionService()
    {
        return $this->services['photo.infrastructure.hydrator.mongo.photo_collection'] = new \Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }

        return $this->parameterBag;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'mongo.db' => 'booothy',
            'mongo.server' => '',
            'booothy_api_url' => '',
            'booothy_download_url' => '',
        );
    }
}

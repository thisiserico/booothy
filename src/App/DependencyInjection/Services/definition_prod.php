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
            'app.event.emitter' => 'getApp_Event_EmitterService',
            'app.mongo.collection.photo' => 'getApp_Mongo_Collection_PhotoService',
            'photo.application.listener.generate_uploads' => 'getPhoto_Application_Listener_GenerateUploadsService',
            'photo.application.marshaller.resource' => 'getPhoto_Application_Marshaller_ResourceService',
            'photo.application.service.get_complete_collection' => 'getPhoto_Application_Service_GetCompleteCollectionService',
            'photo.application.service.get_resource' => 'getPhoto_Application_Service_GetResourceService',
            'photo.application.service.post_resource' => 'getPhoto_Application_Service_PostResourceService',
            'photo.domain.service.download_url_generator' => 'getPhoto_Domain_Service_DownloadUrlGeneratorService',
            'photo.infrastructure.hydrator.mongo.photo_collection' => 'getPhoto_Infrastructure_Hydrator_Mongo_PhotoCollectionService',
            'photo.infrastructure.hydrator.mongo.photo_resource' => 'getPhoto_Infrastructure_Hydrator_Mongo_PhotoResourceService',
            'photo.infrastructure.repository.mongo.photo_saver' => 'getPhoto_Infrastructure_Repository_Mongo_PhotoSaverService',
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
     * Gets the 'app.event.emitter' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \League\Event\Emitter A League\Event\Emitter instance.
     */
    protected function getApp_Event_EmitterService()
    {
        return $this->services['app.event.emitter'] = new \League\Event\Emitter();
    }

    /**
     * Gets the 'photo.application.listener.generate_uploads' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Photo\Application\Listener\GenerateUploads A Booothy\Photo\Application\Listener\GenerateUploads instance.
     */
    protected function getPhoto_Application_Listener_GenerateUploadsService()
    {
        return $this->services['photo.application.listener.generate_uploads'] = new \Booothy\Photo\Application\Listener\GenerateUploads(new \Symfony\Component\Filesystem\Filesystem(), $this->get('photo.infrastructure.repository.mongo.photo_saver'));
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
        return $this->services['photo.application.service.get_complete_collection'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\Photo\Application\Service\GetCompleteCollection\UseCase(new \Booothy\Photo\Infrastructure\Repository\Mongo\NewerFirstLoader($this->get('app.mongo.collection.photo'), $this->get('photo.infrastructure.hydrator.mongo.photo_collection'))), new \Booothy\Photo\Application\Marshaller\Collection($this->get('photo.application.marshaller.resource')));
    }

    /**
     * Gets the 'photo.application.service.get_resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Core\Application\Service\Marshaller\UseCase A Booothy\Core\Application\Service\Marshaller\UseCase instance.
     */
    protected function getPhoto_Application_Service_GetResourceService()
    {
        return $this->services['photo.application.service.get_resource'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\Photo\Application\Service\GetResource\UseCase(new \Booothy\Photo\Infrastructure\Repository\Mongo\ResourceLoader($this->get('app.mongo.collection.photo'), $this->get('photo.infrastructure.hydrator.mongo.photo_resource'))), $this->get('photo.application.marshaller.resource'));
    }

    /**
     * Gets the 'photo.application.service.post_resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Core\Application\Service\Marshaller\UseCase A Booothy\Core\Application\Service\Marshaller\UseCase instance.
     */
    protected function getPhoto_Application_Service_PostResourceService()
    {
        return $this->services['photo.application.service.post_resource'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\Photo\Application\Service\PostResource\UseCase($this->get('photo.infrastructure.repository.mongo.photo_saver'), $this->get('app.event.emitter')), $this->get('photo.application.marshaller.resource'));
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
        return $this->services['photo.domain.service.download_url_generator'] = new \Booothy\Photo\Domain\Service\DownloadUrlGenerator('http://booothy.ericlopez.me.dev/index_dev.php/u/{filename}');
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
        return $this->services['photo.infrastructure.hydrator.mongo.photo_collection'] = new \Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoCollection($this->get('photo.infrastructure.hydrator.mongo.photo_resource'));
    }

    /**
     * Gets the 'photo.infrastructure.hydrator.mongo.photo_resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoResource A Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoResource instance.
     */
    protected function getPhoto_Infrastructure_Hydrator_Mongo_PhotoResourceService()
    {
        return $this->services['photo.infrastructure.hydrator.mongo.photo_resource'] = new \Booothy\Photo\Infrastructure\Hydrator\Mongo\PhotoResource();
    }

    /**
     * Gets the 'app.mongo.collection.photo' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * This service is private.
     * If you want to be able to request this service from the container directly,
     * make it public, otherwise you might end up with broken code.
     *
     * @return \MongoCollection A MongoCollection instance.
     */
    protected function getApp_Mongo_Collection_PhotoService()
    {
        return $this->services['app.mongo.collection.photo'] = new \MongoCollection(new \MongoDB(new \MongoClient('mongodb://127.0.0.1:27017'), 'booothy'), 'photo');
    }

    /**
     * Gets the 'photo.application.marshaller.resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * This service is private.
     * If you want to be able to request this service from the container directly,
     * make it public, otherwise you might end up with broken code.
     *
     * @return \Booothy\Photo\Application\Marshaller\Resource A Booothy\Photo\Application\Marshaller\Resource instance.
     */
    protected function getPhoto_Application_Marshaller_ResourceService()
    {
        return $this->services['photo.application.marshaller.resource'] = new \Booothy\Photo\Application\Marshaller\Resource($this->get('photo.domain.service.download_url_generator'));
    }

    /**
     * Gets the 'photo.infrastructure.repository.mongo.photo_saver' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * This service is private.
     * If you want to be able to request this service from the container directly,
     * make it public, otherwise you might end up with broken code.
     *
     * @return \Booothy\Photo\Infrastructure\Repository\Mongo\PhotoSaver A Booothy\Photo\Infrastructure\Repository\Mongo\PhotoSaver instance.
     */
    protected function getPhoto_Infrastructure_Repository_Mongo_PhotoSaverService()
    {
        return $this->services['photo.infrastructure.repository.mongo.photo_saver'] = new \Booothy\Photo\Infrastructure\Repository\Mongo\PhotoSaver($this->get('app.mongo.collection.photo'), new \Booothy\Photo\Infrastructure\Marshalling\Mongo\Marshaller());
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
            'mongo.server' => 'mongodb://127.0.0.1:27017',
            'booothy_api_url' => 'http://booothy.ericlopez.me.dev/index_dev.php/api/',
            'booothy_download_url' => 'http://booothy.ericlopez.me.dev/index_dev.php/u/{filename}',
        );
    }
}

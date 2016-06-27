<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * ServiceContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class ServiceContainer extends Container
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
            'app.google.client' => 'getApp_Google_ClientService',
            'app.image_manager' => 'getApp_ImageManagerService',
            'app.mongo' => 'getApp_MongoService',
            'photo.application.listener.compute_image_details' => 'getPhoto_Application_Listener_ComputeImageDetailsService',
            'photo.application.listener.generate_uploads' => 'getPhoto_Application_Listener_GenerateUploadsService',
            'photo.application.marshaller.resource' => 'getPhoto_Application_Marshaller_ResourceService',
            'photo.application.service.get_complete_collection' => 'getPhoto_Application_Service_GetCompleteCollectionService',
            'photo.application.service.get_resource' => 'getPhoto_Application_Service_GetResourceService',
            'photo.application.service.post_resource' => 'getPhoto_Application_Service_PostResourceService',
            'photo.domain.service.download_url_generator' => 'getPhoto_Domain_Service_DownloadUrlGeneratorService',
            'photo.infrastructure.hydrator.mongo.photo_collection' => 'getPhoto_Infrastructure_Hydrator_Mongo_PhotoCollectionService',
            'photo.infrastructure.hydrator.mongo.photo_resource' => 'getPhoto_Infrastructure_Hydrator_Mongo_PhotoResourceService',
            'photo.infrastructure.repository.mongo.photo_saver' => 'getPhoto_Infrastructure_Repository_Mongo_PhotoSaverService',
            'user.application.marshaller.resource' => 'getUser_Application_Marshaller_ResourceService',
            'user.application.service.authenticate' => 'getUser_Application_Service_AuthenticateService',
            'user.application.service.get_collection' => 'getUser_Application_Service_GetCollectionService',
            'user.application.service.get_resource' => 'getUser_Application_Service_GetResourceService',
            'user.application.service.post_resource' => 'getUser_Application_Service_PostResourceService',
            'user.domain.repository.resource_saver' => 'getUser_Domain_Repository_ResourceSaverService',
            'user.domain.service.external_service.adapter.google' => 'getUser_Domain_Service_ExternalService_Adapter_GoogleService',
            'user.domain.service.external_service.adapter.null_object' => 'getUser_Domain_Service_ExternalService_Adapter_NullObjectService',
            'user.infrastructure.hydrator.mongo.user_collection' => 'getUser_Infrastructure_Hydrator_Mongo_UserCollectionService',
            'user.infrastructure.hydrator.mongo.user_resource' => 'getUser_Infrastructure_Hydrator_Mongo_UserResourceService',
            'user.infrastructure.repository.mongo.resource_loader' => 'getUser_Infrastructure_Repository_Mongo_ResourceLoaderService',
        );
        $this->aliases = array(
            'user.domain.service.external_service.adapter' => 'user.domain.service.external_service.adapter.google',
        );
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
     * Gets the 'app.google.client' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Google_Client A Google_Client instance.
     */
    protected function getApp_Google_ClientService()
    {
        return $this->services['app.google.client'] = new \Google_Client();
    }

    /**
     * Gets the 'app.image_manager' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Intervention\Image\ImageManager A Intervention\Image\ImageManager instance.
     */
    protected function getApp_ImageManagerService()
    {
        return $this->services['app.image_manager'] = new \Intervention\Image\ImageManager();
    }

    /**
     * Gets the 'photo.application.listener.compute_image_details' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Photo\Application\Listener\ComputeImageDetails A Booothy\Photo\Application\Listener\ComputeImageDetails instance.
     */
    protected function getPhoto_Application_Listener_ComputeImageDetailsService()
    {
        return $this->services['photo.application.listener.compute_image_details'] = new \Booothy\Photo\Application\Listener\ComputeImageDetails($this->get('app.image_manager'), $this->get('photo.infrastructure.repository.mongo.photo_saver'));
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
        return $this->services['photo.application.listener.generate_uploads'] = new \Booothy\Photo\Application\Listener\GenerateUploads(new \Symfony\Component\Filesystem\Filesystem(), $this->get('app.image_manager'), $this->get('photo.infrastructure.repository.mongo.photo_saver'), '/var/booothy/uploads/', '/var/booothy/uploads/thumbs/');
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
        return $this->services['photo.application.service.get_complete_collection'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\Photo\Application\Service\GetCompleteCollection\UseCase(new \Booothy\Photo\Infrastructure\Repository\Mongo\NewerFirstLoader($this->get('app.mongo'), $this->get('photo.infrastructure.hydrator.mongo.photo_collection'))), new \Booothy\Photo\Application\Marshaller\Collection($this->get('photo.application.marshaller.resource')));
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
        return $this->services['photo.application.service.get_resource'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\Photo\Application\Service\GetResource\UseCase(new \Booothy\Photo\Infrastructure\Repository\Mongo\ResourceLoader($this->get('app.mongo'), $this->get('photo.infrastructure.hydrator.mongo.photo_resource'))), $this->get('photo.application.marshaller.resource'));
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
        return $this->services['photo.domain.service.download_url_generator'] = new \Booothy\Photo\Domain\Service\DownloadUrlGenerator('//booothy.dev', 'u/{filename}', 'u/thumb/{filename}');
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
     * Gets the 'user.application.service.authenticate' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Application\Service\Authenticate\UseCase A Booothy\User\Application\Service\Authenticate\UseCase instance.
     */
    protected function getUser_Application_Service_AuthenticateService()
    {
        return $this->services['user.application.service.authenticate'] = new \Booothy\User\Application\Service\Authenticate\UseCase($this->get('user.domain.service.external_service.adapter.google'), $this->get('user.infrastructure.repository.mongo.resource_loader'));
    }

    /**
     * Gets the 'user.application.service.get_collection' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Core\Application\Service\Marshaller\UseCase A Booothy\Core\Application\Service\Marshaller\UseCase instance.
     */
    protected function getUser_Application_Service_GetCollectionService()
    {
        return $this->services['user.application.service.get_collection'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\User\Application\Service\GetCollection\UseCase(new \Booothy\User\Infrastructure\Repository\Mongo\CompleteCollectionLoader($this->get('app.mongo'), $this->get('user.infrastructure.hydrator.mongo.user_collection'))), new \Booothy\User\Application\Marshaller\Collection($this->get('user.application.marshaller.resource')));
    }

    /**
     * Gets the 'user.application.service.get_resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\Core\Application\Service\Marshaller\UseCase A Booothy\Core\Application\Service\Marshaller\UseCase instance.
     */
    protected function getUser_Application_Service_GetResourceService()
    {
        return $this->services['user.application.service.get_resource'] = new \Booothy\Core\Application\Service\Marshaller\UseCase(new \Booothy\User\Application\Service\GetResource\UseCase($this->get('user.infrastructure.repository.mongo.resource_loader')), $this->get('user.application.marshaller.resource'));
    }

    /**
     * Gets the 'user.application.service.post_resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Application\Service\PostResource\UseCase A Booothy\User\Application\Service\PostResource\UseCase instance.
     */
    protected function getUser_Application_Service_PostResourceService()
    {
        return $this->services['user.application.service.post_resource'] = new \Booothy\User\Application\Service\PostResource\UseCase($this->get('user.domain.repository.resource_saver'));
    }

    /**
     * Gets the 'user.domain.repository.resource_saver' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Infrastructure\Repository\Mongo\ResourceSaver A Booothy\User\Infrastructure\Repository\Mongo\ResourceSaver instance.
     */
    protected function getUser_Domain_Repository_ResourceSaverService()
    {
        return $this->services['user.domain.repository.resource_saver'] = new \Booothy\User\Infrastructure\Repository\Mongo\ResourceSaver($this->get('app.mongo'), new \Booothy\User\Infrastructure\Marshalling\Mongo\Marshaller());
    }

    /**
     * Gets the 'user.domain.service.external_service.adapter.google' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Domain\Service\ExternalService\Adapter\Google A Booothy\User\Domain\Service\ExternalService\Adapter\Google instance.
     */
    protected function getUser_Domain_Service_ExternalService_Adapter_GoogleService()
    {
        return $this->services['user.domain.service.external_service.adapter.google'] = new \Booothy\User\Domain\Service\ExternalService\Adapter\Google('', '', $this->get('app.google.client'));
    }

    /**
     * Gets the 'user.domain.service.external_service.adapter.null_object' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Domain\Service\ExternalService\Adapter\NullObject A Booothy\User\Domain\Service\ExternalService\Adapter\NullObject instance.
     */
    protected function getUser_Domain_Service_ExternalService_Adapter_NullObjectService()
    {
        return $this->services['user.domain.service.external_service.adapter.null_object'] = new \Booothy\User\Domain\Service\ExternalService\Adapter\NullObject(new \Booothy\User\Infrastructure\Repository\Memory\GetFirstResourceLoader(new \Booothy\Core\Infrastructure\Repository\Memory\Handler()));
    }

    /**
     * Gets the 'user.infrastructure.hydrator.mongo.user_collection' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Infrastructure\Hydrator\Mongo\UserCollection A Booothy\User\Infrastructure\Hydrator\Mongo\UserCollection instance.
     */
    protected function getUser_Infrastructure_Hydrator_Mongo_UserCollectionService()
    {
        return $this->services['user.infrastructure.hydrator.mongo.user_collection'] = new \Booothy\User\Infrastructure\Hydrator\Mongo\UserCollection($this->get('user.infrastructure.hydrator.mongo.user_resource'));
    }

    /**
     * Gets the 'user.infrastructure.hydrator.mongo.user_resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \Booothy\User\Infrastructure\Hydrator\Mongo\UserResource A Booothy\User\Infrastructure\Hydrator\Mongo\UserResource instance.
     */
    protected function getUser_Infrastructure_Hydrator_Mongo_UserResourceService()
    {
        return $this->services['user.infrastructure.hydrator.mongo.user_resource'] = new \Booothy\User\Infrastructure\Hydrator\Mongo\UserResource();
    }

    /**
     * Gets the 'app.mongo' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * This service is private.
     * If you want to be able to request this service from the container directly,
     * make it public, otherwise you might end up with broken code.
     *
     * @return \MongoDB\Driver\Manager A MongoDB\Driver\Manager instance.
     */
    protected function getApp_MongoService()
    {
        return $this->services['app.mongo'] = new \MongoDB\Driver\Manager('mongodb://username:password@booothy-mongo-db:27017/booothy');
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
        return $this->services['photo.infrastructure.repository.mongo.photo_saver'] = new \Booothy\Photo\Infrastructure\Repository\Mongo\PhotoSaver($this->get('app.mongo'), new \Booothy\Photo\Infrastructure\Marshalling\Mongo\Marshaller());
    }

    /**
     * Gets the 'user.application.marshaller.resource' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * This service is private.
     * If you want to be able to request this service from the container directly,
     * make it public, otherwise you might end up with broken code.
     *
     * @return \Booothy\User\Application\Marshaller\Resource A Booothy\User\Application\Marshaller\Resource instance.
     */
    protected function getUser_Application_Marshaller_ResourceService()
    {
        return $this->services['user.application.marshaller.resource'] = new \Booothy\User\Application\Marshaller\Resource();
    }

    /**
     * Gets the 'user.infrastructure.repository.mongo.resource_loader' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * This service is private.
     * If you want to be able to request this service from the container directly,
     * make it public, otherwise you might end up with broken code.
     *
     * @return \Booothy\User\Infrastructure\Repository\Mongo\ResourceLoader A Booothy\User\Infrastructure\Repository\Mongo\ResourceLoader instance.
     */
    protected function getUser_Infrastructure_Repository_Mongo_ResourceLoaderService()
    {
        return $this->services['user.infrastructure.repository.mongo.resource_loader'] = new \Booothy\User\Infrastructure\Repository\Mongo\ResourceLoader($this->get('app.mongo'), $this->get('user.infrastructure.hydrator.mongo.user_resource'));
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
            'google.client_id' => '',
            'google.client_secret' => '',
            'folder.cache' => '/var/booothy/cache/',
            'folder.logs' => '/var/booothy/logs/',
            'folder.uploads' => '/var/booothy/uploads/',
            'folder.uploads.thumbs' => '/var/booothy/uploads/thumbs/',
            'folder.tmp' => '/tmp/',
            'mongo.db' => 'booothy',
            'mongo.server' => 'mongodb://username:password@booothy-mongo-db:27017/booothy',
            'booothy_url' => '//booothy.dev',
            'booothy_download_uri' => 'u/{filename}',
            'booothy_thumb_download_uri' => 'u/thumb/{filename}',
        );
    }
}

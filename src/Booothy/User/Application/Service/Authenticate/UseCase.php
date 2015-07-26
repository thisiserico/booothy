<?php

namespace Booothy\User\Application\Service\Authenticate;

use Booothy\Core\Application\Request as CoreRequest;
use Booothy\Core\Application\Service;
use Booothy\User\Application\Service\Authenticate\Exception\DisallowedUser;
use Booothy\User\Domain\Model\ValueObject\Email;
use Booothy\User\Domain\Service\ExternalService\Adapter;
use Booothy\User\Domain\Service\ExternalService\Exception\InvalidUser;
use Booothy\User\Domain\Repository\Exception\NonExistingResource;
use Booothy\User\Domain\Repository\ResourceLoader;

final class UseCase implements Service
{
    private $external_service_adapter;
    private $user_loader;

    public function __construct(Adapter $an_adapter, ResourceLoader $a_loader)
    {
        $this->external_service_adapter = $an_adapter;
        $this->user_loader              = $a_loader;
    }

    public function __invoke(CoreRequest $request)
    {
        try {
            $raw_email = $this->external_service_adapter->getUserEmail($request->id_token);
            return $this->user_loader->__invoke(new Email($raw_email));
        } catch (NonExistingResource $e) {
            throw new DisallowedUser;
        } catch (InvalidUser $e) {
            throw new DisallowedUser;
        }
    }
}
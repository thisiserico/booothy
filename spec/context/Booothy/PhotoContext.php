<?php

namespace BooothySpec\Booothy;

use DateTimeImmutable;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Model\ValueObject\ImageDetails;
use Booothy\Photo\Domain\Model\ValueObject\Quote;
use Booothy\Photo\Domain\Model\ValueObject\Upload;
use Booothy\User\Domain\Model\ValueObject\Email;
use BooothySpec\BooothyContext;

class PhotoContext implements Context
{
    protected static $app;

    /** @Given /^the list of the existing photos:$/ */
    public function listWithTheExistingPhotos(TableNode $existing_photos)
    {
        foreach ($existing_photos as $existing_photo) {
            BooothyContext::$app['container']
                ->get('photo.domain.repository.saver')
                ->__invoke(new Photo(
                    new Id($existing_photo['id']),
                    new Quote($existing_photo['quote']),
                    Upload::atBooothy(
                        $existing_photo['upload_filename'],
                        $existing_photo['upload_mime_type']
                    ),
                    new ImageDetails(
                        $existing_photo['image_hex_color'],
                        $existing_photo['image_width'],
                        $existing_photo['image_height']
                    ),
                    new DateTimeImmutable($existing_photo['creation_date']),
                    new Email($existing_photo['user_id'])
                ));
        }
    }
}
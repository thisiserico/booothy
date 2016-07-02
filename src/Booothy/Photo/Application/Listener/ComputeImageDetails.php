<?php

namespace Booothy\Photo\Application\Listener;

use Intervention\Image\ImageManager;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Booothy\Photo\Domain\Model\Photo;
use Booothy\Photo\Domain\Model\ValueObject\Upload;
use Booothy\Photo\Domain\Repository\Saver;

final class ComputeImageDetails extends AbstractListener
{
    private $image_manager;
    private $saver_repository;

    public function __construct(
        ImageManager $an_image_manager,
        Saver $a_saver_repository
    ) {
        $this->image_manager = $an_image_manager;
        $this->saver_repository = $a_saver_repository;
    }

    public function handle(EventInterface $event)
    {
        $photo = $event->photo;
        $temporary_location = $event->temporary_location;
        $extracted_hex_color = $this->extractHexColor($photo, $temporary_location);
        $extracted_sizes = $this->extractSizes($temporary_location);

        $photo->isDetailedAs(
            $extracted_hex_color,
            $extracted_sizes['width'],
            $extracted_sizes['height']
        );

        $this->saver_repository->__invoke($photo);

        return $photo;
    }

    private function extractHexColor(Photo $photo, $temporary_location)
    {
        $palette = Palette::fromFilename($temporary_location);
        $extractor = new ColorExtractor($palette);
        $colors = $extractor->extract();

        return $colors[0];
    }

    private function extractSizes($temporary_location)
    {
        $image = $this->image_manager->make($temporary_location);

        return [
            'width' => $image->width(),
            'height' => $image->height(),
        ];
    }
}
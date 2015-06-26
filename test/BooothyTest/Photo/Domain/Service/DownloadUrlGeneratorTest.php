<?php

namespace BooothyTest\Photo\Domain\Service;

use PHPUnit_Framework_TestCase;
use Booothy\Photo\Domain\Model\ValueObject\Upload;
use Booothy\Photo\Domain\Service\DownloadUrlGenerator;

final class DownloadUrlGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        $this->booothy_download_pattern = null;
        $this->upload           = null;
    }

    /** @test */
    public function shouldGetTheBooothyDownloadUrl()
    {
        $this->givenABooothyDownloadPattern();
        $this->andAnUploadValueObject();
        $this->assertEquals(
            'booothy.tld/u/filename.png',
            $this->generateDownloadUrl()
        );
    }

    private function givenABooothyDownloadPattern()
    {
        $this->booothy_download_pattern = 'booothy.tld/u/{filename}';
    }

    private function andAnUploadValueObject()
    {
        $this->upload = Upload::AtBooothy('filename.png', 'image/png');
    }

    private function generateDownloadUrl()
    {
        $service = new DownloadUrlGenerator($this->booothy_download_pattern);
        return $service($this->upload);
    }
}
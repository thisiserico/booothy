<?php

namespace Booothy\Photo\Domain\Model;

use DateTimeImmutable;
use Booothy\Photo\Domain\Model\ValueObject\Id;
use Booothy\Photo\Domain\Model\ValueObject\Quote;
use Booothy\Photo\Domain\Model\ValueObject\Upload;

final class Photo
{
    const DATE_TIME_FORMAT = 'Y-m-d H:i:s';

    private $id;
    private $quote;
    private $upload;
    private $creation_date;

    public function __construct(
        Id $an_id,
        Quote $a_quote,
        Upload $an_upload,
        DateTimeImmutable $a_creation_date
    ) {
        $this->id            = $an_id;
        $this->quote         = $a_quote;
        $this->upload        = $an_upload;
        $this->creation_date = $a_creation_date;
    }

    public function id()
    {
        return $this->id;
    }

    public function quote()
    {
        return $this->quote;
    }

    public function createdAt()
    {
        return $this->creation_date->format(self::DATE_TIME_FORMAT);
    }
}
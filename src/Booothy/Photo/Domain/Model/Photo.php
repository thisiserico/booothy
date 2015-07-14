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

    public static function generateNew(
        $a_quote,
        $an_upload_mime_type
    ) {
        $id            = Id::next();
        $quote         = new Quote($a_quote);
        $creation_date = new DateTimeImmutable;
        $upload        = self::generateUpload(
            $a_quote,
            $creation_date,
            $an_upload_mime_type
        );

        return new self($id, $quote, $upload, $creation_date);
    }

    private static function generateUpload(
        $a_quote,
        $a_creation_date,
        $an_upload_mime_type
    ) {
        $filename = self::generateFilename(
            $a_quote,
            $a_creation_date,
            $an_upload_mime_type
        );

        return Upload::Processing($filename, $an_upload_mime_type);
    }

    private static function generateFilename($quote, $date, $mime_type)
    {
        $formatted_date         = $date->format('Y-m-d \a\t H:i:s');
        $sanitized_spaced_quote = preg_replace('/[^a-zA-Z0-9 ]+/', '', $quote);
        $sanitized_quote        = str_replace(' ', '-', $sanitized_spaced_quote);
        $extensions             = [
            'image/gif'  => '.gif',
            'image/jpeg' => '.jpg',
            'image/png'  => '.png',
        ];

        return $formatted_date . ' ' . $sanitized_quote . $extensions[$mime_type];
    }

    public function id()
    {
        return $this->id;
    }

    public function quote()
    {
        return $this->quote;
    }

    public function upload()
    {
        return $this->upload;
    }

    public function createdAt()
    {
        return $this->creation_date->format(self::DATE_TIME_FORMAT);
    }
}
<?php


namespace App\DTO\Widget;


class ItemListDTO
{
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $targetLink;
    /**
     * @var string
     */
    private $thumbnailImage;
    /**
     * @var string|null
     */
    private $thumbnailVideo;

    /**
     * @var string|null
     */
    private $subText;

    /**
     * ItemListDTO constructor.
     * @param string $text
     * @param string $targetLink
     * @param string $thumbnailImage
     * @param string|null $thumbnailVideo
     * @param string|null $subText
     */
    public function __construct(
        string $text,
        string $targetLink,
        string $thumbnailImage,
        ?string $thumbnailVideo = null,
        ?string $subText = null
    ) {
        $this->text = $text;
        $this->targetLink = $targetLink;
        $this->thumbnailImage = $thumbnailImage;
        $this->thumbnailVideo = $thumbnailVideo;
        $this->subText = $subText;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getTargetLink(): string
    {
        return $this->targetLink;
    }

    /**
     * @return string
     */
    public function getThumbnailImage(): string
    {
        return $this->thumbnailImage;
    }

    /**
     * @return string|null
     */
    public function getThumbnailVideo(): ?string
    {
        return $this->thumbnailVideo;
    }

    public function getSubText(): ?string
    {
        return $this->subText;
    }
}
<?php

namespace App\Twig;

use Symfony\Component\Asset\Packages;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AssetLocator extends AbstractExtension
{

    /** @var Packages */
    private $packages;

    /** @var string */
    private $environmentName;

    /**
     * @param Packages              $packages
     * @param ContainerBagInterface $parameters
     */
    public function __construct(Packages $packages, ContainerBagInterface $parameters)
    {
        $this->packages = $packages;
        $this->environmentName = $parameters->get('kernel.environment');

    }

    /**
     * @return array
     */
    public function getFunctions(): array
    {
        return [
          new TwigFunction('asset_locator', [$this, 'getAssetUrl'])
        ];
    }

    /**
     * @param string      $path
     * @param string|null $packageName
     * @return string
     */
    public function getAssetUrl(string $path, string $packageName = null): string
    {
        $explodedPath = explode('.', $path);
        $fileExtension = array_pop($explodedPath);
        $fileName = implode('.', $explodedPath);

        if ($this->assetExists(implode('.', [$fileName, $this->environmentName, $fileExtension]))) {
            return dump($this->packages->getUrl(
              sprintf('%s.%s.%s', $fileName, $this->environmentName, $fileExtension), $packageName)
            );
        }

        return dump($this->packages->getUrl(
          sprintf('%s.%s.%s', $fileName, 'default', $fileExtension), $packageName)
        );
    }

    /**
     * @param string $assetName
     * @return bool
     */
    private function assetExists(string $assetName): bool
    {
        return $assetName === $this->packages->getUrl($assetName);
    }

}
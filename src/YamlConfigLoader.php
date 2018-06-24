<?php
declare(strict_types=1);

namespace Smichaelsen\Typo3ConfigHandling;

use Helhum\ConfigLoader\ConfigurationLoader;
use Helhum\ConfigLoader\ConfigurationReaderFactory;
use Helhum\ConfigLoader\InvalidConfigurationFileException;

class YamlConfigLoader
{

    public function load(string $configDirectory)
    {
        try {
            $GLOBALS['TYPO3_CONF_VARS'] = array_replace_recursive(
                $GLOBALS['TYPO3_CONF_VARS'],
                $this->getYamlLoader($configDirectory)->load()
            );
        } catch (InvalidConfigurationFileException $e) {
        }
    }

    protected function getYamlLoader(string $configDirectory): ConfigurationLoader
    {
        $configReaderFactory = new ConfigurationReaderFactory($configDirectory);
        $configLoader = new ConfigurationLoader(
            [
                $configReaderFactory->createReader($configDirectory . '/settings.yaml'),
            ]
        );
        return $configLoader;
    }

}
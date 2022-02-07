<?php
declare(strict_types=1);

namespace c2system;

use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Application as MvcApplication;
use Phalcon\Loader;

class Application
{
    const APPLICATION_PROVIDER = 'bootstrap';
    
    /**
     * @var MvcApplication
     */
    protected $app;
    
    /**
     * @var DiInterface
     */
    protected $di;
    
    /**
     * Project root path
     *
     * @var string
     */
    protected $rootPath;
    
    /**
     * @param string $rootPath
     *
     * @throws Exception
     */
    public function __construct(string $rootPath)
    {
        $this->di = new FactoryDefault();
        $this->app = $this->createApplication();
        $this->rootPath = $rootPath;
        
        $this->loaders();

        $this->di->setShared(self::APPLICATION_PROVIDER, $this);
        
        $this->initializeProviders();
    }
    
    
    /**
     * Run C2system Application
     *
     * @return string
     * @throws Exception
     */
    public function run(): string
    {
        /** @var ResponseInterface $response */
        $response = $this->app->handle($_SERVER['REQUEST_URI']);
        
        return (string)$response->getContent();
    }
    /**
     * register Loader and load namespaces
     */
    protected function loaders()
    {
        $loader = new Loader();
        
        $loader->registerNamespaces([
            'Providers' => APP_PATH . '/Providers/',
            'Plugins'   => APP_PATH . '/Plugins/',
            'c2system'  => APP_PATH,
            'Models'   => APP_PATH . '/Models/',
            'Controllers'   => APP_PATH . '/Controllers/',
        ]);
        
        $loader->register();
    }
    
    /**
     * Get Project root path
     *
     * @return string
     */
    public function getRootPath(): string
    {
        return $this->rootPath;
    }
    
    /**
     * @return MvcApplication
     */
    protected function createApplication(): MvcApplication
    {
        return new MvcApplication($this->di);
    }
    
    /**
     * @throws Exception
     */
    protected function initializeProviders(): void
    {
        $filename = $this->rootPath . '/config/providers.php';
        if (!file_exists($filename) || !is_readable($filename)) {
            throw new Exception('File providers.php does not exist or is not readable.');
        }
        
        $providers = include_once $filename;
        foreach ($providers as $providerClass) {
            /** @var ServiceProviderInterface $provider */
            $provider = new $providerClass;
            $provider->register($this->di);
        }
    }
}


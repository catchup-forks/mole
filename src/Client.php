<?php namespace Braseidon\Mole;

use Braseidon\Mole\Traits\UsesConfig;

use Exception;
use InvalidArgumentException;

class Client
{
    use UsesConfig;

    /**
     * The Crawler instance
     *
     * @var Crawler
     */
    protected $crawler;

    /**
     * Instantiate the Object
     */
    public function __construct(Crawler $crawler, array $config = [])
    {
        $this->setCrawler($crawler);
        $this->mergeOptions($config);
    }

    /**
    * Set the Crawler
    *
    * @param Crawler $crawler
    */
    public function setCrawler(Crawler $crawler)
    {
        $this->crawler = $crawler;
    }

    /**
     * Get the Crawler instance
     *
     * @return Crawler
     */
    public function getCrawler()
    {
        return $this->crawler;
    }

    /**
     * @param array $config Set the target
     */
    public function setTarget($target)
    {
        if (! parse_url($target)) {
            throw new InvalidArgumentException('Option `target` must be a valid URL.');
        }

        $this->setOption('target', $target);
        $this->getCrawler()->setTarget($target);
    }

    /**
     * @return array $config Get the target
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param integer Set the threads
     */
    public function setThreads($threads)
    {
        if (! is_numeric($threads)) {
            throw new InvalidArgumentException('Option `threads` must be set to a numeric value.');
        }

        $this->setOption('threads', $threads);
    }

    /**
     * @return integer Get the request Callback.
     */
    public function getThreads()
    {
        $threads = 2;

        if (! $this->hasOption('threads')) {
            return $this->setOption('threads', $threads);
        }

        return $this->getOption('threads');
    }

    /**
     * @param integer Set the request limit
     */
    public function setRequestLimit($requestLimit)
    {
        if (! is_numeric($requestLimit)) {
            throw new InvalidArgumentException('Option `request_limit` must be set to a numeric value.');
        }

        $this->setOption('request_limit', $requestLimit);
    }

    /**
     * Get the request limit or set default.
     *
     * @return integer
     */
    public function getRequestLimit()
    {
        $requestLimit = 20;

        if ($this->hasOption('request_limit')) {
            return $this->getOption('request_limit');
        }

        return $requestLimit;
    }

    /**
     * @return array Set the ignoredFileTypes array
     */
    public function setIgnoredFileTypes(array $ignored)
    {
        $this->setOption('ignored_file_types', $ignored);
    }

    /**
     * @return array Return the file extensions to ignore when crawling
     */
    public function getIgnoredFiletypes()
    {
        $ignoredFiletypes = ['.css', '.doc', '.gif', '.jpeg', '.jpg', '.js', '.pdf', '.png'];

        if ($this->hasOption('ignored_file_types')) {
            return $this->getOption('ignored_file_types');
        }

        return $ignoredFiletypes;
    }

    /**
     * @param string Set the proxy_path
     */
    public function setProxyPath($proxyPath)
    {
        if (! file_exists($proxyPath)) {
            throw new InvalidArgumentException('The file at the `proxy_path` specified does not exist.');
        }

        $this->setOption('proxy_path', $proxyPath);
    }

    /**
     * @return string Get the request Callback.
     */
    public function getProxyPath()
    {
        $proxyPath = 2;

        if (! $this->hasOption('proxy_path')) {
            return $this->getOption('proxy_path');
        }

        return $proxyPath;
    }

    /**
     * Crawl the target
     *
     * @param  string $target
     * @return mixed
     */
    public function crawl($target = null)
    {
        if ($target !== null) {
            $this->setTarget($target);
        }

        $this->getCrawler()->mergeOptions($this->getAllOptions());

        return $this->getCrawler()->crawl($target);
    }

    /**
    * Turn on debug mode
    *
    * @return Crawler
    */
    public function debug()
    {
        return $this->getCrawler()->debugOn();
    }
}

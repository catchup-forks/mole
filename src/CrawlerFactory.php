<?php namespace Braseidon\Mole;

use Braseidon\Mole\Index\Index;
use Braseidon\Mole\Curl\Proxy;
use Braseidon\Mole\Parser\ParserFactory;
use Braseidon\Mole\Traits\UsesConfig;

class CrawlerFactory
{
    use UsesConfig;

    /**
     * Create CrawlerFactory object.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->mergeOptions($config);
    }

    /*
    |--------------------------------------------------------------------------
    | Getters - Objects
    |--------------------------------------------------------------------------
    |
    |
    */

    /**
     * Create Crawler object.
     *
     * @return Crawler
     */
    public function getCrawler()
    {
        $crawler = new Crawler(
            $this->getAllOptions()
        );

        $crawler->setIndex($this->getIndex());
        $crawler->setParser($this->getParser());
        $crawler->setProxy($this->getProxy());

        return $crawler;
    }

    /**
     * @return Index The Index object
     */
    public function getIndex()
    {
        return new Index();
    }

    /**
     * @return Parser The Parser object
     */
    public function getParser()
    {
        return ParserFactory::create($this->getAllOptions());
    }



    /**
     * @return Proxy The Proxy object
     */
    public function getProxy()
    {
        return new Proxy($this->getOption('proxy_path'));
    }

    /**
     * @return Cache The Cache object
     */
    public function getCache()
    {
        return new Cache();
    }

    /*
    |--------------------------------------------------------------------------
    | Getters - Options
    |--------------------------------------------------------------------------
    |
    |
    */



    /**
     * Create Crawler object.
     *
     * @param array $config
     *
     * @return Crawler
     */
    public static function create(array $config = [])
    {
        return (new self($config))->getCrawler();
    }
}

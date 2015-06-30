<?php


namespace Application\Command;


class RefreshCommand
{
    /** @var  string */
    protected $url;

    /**
     * RefreshCommand constructor.
     * @param string $url
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

}
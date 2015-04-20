<?php
/**
 * HttpClient.php
 * User: sami
 * Date: 20-Apr-15
 * Time: 2:49 PM
 */

namespace utils;


class HttpClient {
    /**
     * The cURL resource handle.
     *
     * @var     resource
     */
    protected $ch;

    /**
     * Object constructor
     */
    public function __construct()
    {
        $this->ch = curl_init();
    }

    /**
     * Sends the HTTP POST request to specified URL with given parameters.
     *
     * @param   string $url the URL to request
     * @param   array $parameters the POST parameters to include to request
     * @throws ECurlFail
     * @throws EServiceUnavailable
     * @return  string              the server response
     */
    public function post($url, array $parameters)
    {
        if (false === curl_setopt_array($this->ch, array(
                CURLOPT_POST            => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_URL             => $url,
                CURLOPT_POSTFIELDS      => $parameters
            ))) {
            throw new ECurlFail('Error at setting cURL options, reason: '.curl_error($this->ch), curl_errno($this->ch));
        }

        if (false === $result = curl_exec($this->ch)) {
            throw new ECurlFail('Error at execute cURL request, reason: '.curl_error($this->ch), curl_errno($this->ch));
        }

        if (200 != curl_getinfo($this->ch, CURLINFO_HTTP_CODE)) {
            throw new EServiceUnavailable('The API servise is unavailable');
        }

        return $result;
    }

    public function get($url, array $parameters)
    {
        if (false === curl_setopt_array($this->ch, array(
                CURLOPT_POST            => false,
                CURLOPT_HTTPGET         => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_URL             => $this->buildUrl($url, $parameters),
            ))) {
            throw new ECurlFail('Error at setting cURL options, reason: '.curl_error($this->ch), curl_errno($this->ch));
        }

        if (false === $result = curl_exec($this->ch)) {
            throw new ECurlFail('Error at execute cURL request, reason: '.curl_error($this->ch), curl_errno($this->ch));
        }

        if (200 != curl_getinfo($this->ch, CURLINFO_HTTP_CODE)) {
            throw new EServiceUnavailable('The API service is unavailable');
        }

        return $result;
    }

    /**
     * Object destructor.
     */
    public function __destruct()
    {
        if (is_resource($this->ch)) {
            curl_close($this->ch);
        }
    }

    protected function buildUrl($baseurl, array $parameters)
    {
        return $baseurl. '?' . http_build_query($parameters);
    }
}

class HttpException extends \Exception {};

class ECurlFail extends HttpException {};

class EServiceUnavailable extends HttpException {};

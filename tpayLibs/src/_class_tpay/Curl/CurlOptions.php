<?php

/*
 * Created by tpay.com.
 * Date: 20.04.2017
 * Time: 15:40
 */

namespace tpayLibs\src\_class_tpay\Curl;


class CurlOptions
{
    private $verifyHost = 0;
    private $timeout = 30;
    private $connectTimeout = 15;
    private $verifyPeer = false;
    private $verbose = true;
    private $post = true;
    private $returnTransfer = true;
    private $failOnError = true;
    private $followLocation = false;

    /**
     * Set timeout time
     * @param int $timeout
     * @return object
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * Set connect timeout time
     * @param int $timeout
     * @return object
     */
    public function setConnectTimeout($timeout)
    {
        $this->connectTimeout = $timeout;
        return $this;
    }

    /**
     * Set host verification
     * @param int $verifyHost
     * @return object
     */
    public function setVerifyHost($verifyHost)
    {
        $this->verifyHost = (int)$verifyHost;
        return $this;
    }

    /**
     * Disable peer verification
     *
     * @return object
     */
    public function disableVerifyPeer()
    {
        $this->verifyPeer = false;
        return $this;
    }

    /**
     * Disable Verbose
     * @return object
     */
    public function disableVerbose()
    {
        $this->verbose = false;
        return $this;
    }

    /**
     * Disable POST
     * @return object
     */
    public function disablePost()
    {
        $this->post = false;
        return $this;
    }

    /**
     * Disable Return Transfer
     * @return object
     */
    public function disableReturnTransfer()
    {
        $this->returnTransfer = false;
        return $this;
    }

    /**
     * Disable Failing on Error
     * @return object
     */
    public function disableFailOnError()
    {
        $this->failOnError = false;
        return $this;
    }

    /**
     * Disable Following Location
     * @return object
     */
    public function disableFollowLocation()
    {
        $this->followLocation = false;
        return $this;
    }

    /**
     * enable peer verification
     *
     * @return object
     */
    public function enableVerifyPeer()
    {
        $this->verifyPeer = true;
        return $this;
    }

    /**
     * enable Verbose
     * @return object
     */
    public function enableVerbose()
    {
        $this->verbose = true;
        return $this;
    }

    /**
     * enable POST
     * @return object
     */
    public function enablePost()
    {
        $this->post = true;
        return $this;
    }

    /**
     * enable Return Transfer
     * @return object
     */
    public function enableReturnTransfer()
    {
        $this->returnTransfer = true;
        return $this;
    }

    /**
     * enable Failing on Error
     * @return object
     */
    public function enableFailOnError()
    {
        $this->failOnError = true;
        return $this;
    }

    /**
     * enable Following Location
     * @return object
     */
    public function enableFollowLocation()
    {
        $this->followLocation = true;
        return $this;
    }

    public function getOptionsArray()
    {
        return array(
            CURLOPT_CONNECTTIMEOUT => $this->connectTimeout,
            CURLOPT_FOLLOWLOCATION => $this->followLocation,
            CURLOPT_SSL_VERIFYHOST => $this->verifyHost,
            CURLOPT_SSL_VERIFYPEER => $this->verifyPeer,
            CURLOPT_TIMEOUT        => $this->timeout,
            CURLOPT_VERBOSE        => $this->verbose,
            CURLOPT_POST           => $this->post,
            CURLOPT_RETURNTRANSFER => $this->returnTransfer,
            CURLOPT_FAILONERROR    => $this->failOnError
        );
    }

}

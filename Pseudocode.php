<?php

interface SmsService
{
    public function send(string $phone) : bool;

    public function isAcceptedCountry(string $country) : bool;

    public function getPrice(string $phone) : float;
}

trait SmsCoutryAcceptable
{
    public function isAcceptedCountry(string $country) : bool
    {
        //... some code ...
    }
}

trait SmsPricable
{
    public function getPrice(string $phone) : float
    {
        //... some code ...
    }
}

class SmsService1Api
{
    //... some code ...
}

class SmsService1Adapter extends SmsService1Api implements SmsService
{
    use SmsCoutryAcceptable, SmsPricable;

    public function send(string $phone) : bool
    {
        //... some code ...
    }
}

class SmsService2Api
{
    //... some code ...
}

class SmsService2Adapter extends SmsService2Api implements SmsService
{
    use SmsCoutryAcceptable, SmsPricable;

    public function send(string $phone) : bool
    {
        //... some code ...
    }
}

class SmsService3Api
{
    //... some code ...
}

class SmsService3Adapter extends SmsService3Api implements SmsService
{
    use SmsCoutryAcceptable, SmsPricable;

    public function send(string $phone) : bool
    {
        //... some code ...
    }
}

class SmsService4Api
{
    //... some code ...
}

class SmsService4Adapter extends SmsService4Api implements SmsService
{
    use SmsCoutryAcceptable, SmsPricable;

    public function send(string $phone) : bool
    {
        //... some code ...
    }
}

class SmsServiceManager
{
    private $smsServices;

    public function __construct()
    {
        $this->smsServices = [];
        $this->smsServices[] = new SmsService1Adapter();
        $this->smsServices[] = new SmsService2Adapter();
        $this->smsServices[] = new SmsService3Adapter();
        $this->smsServices[] = new SmsService4Adapter();
    }

    protected function getCountry(string $phone) : string
    {
        //... some code ...
    }

    public function send(string $phone) : bool
    {
        $result = false;

        $country = $this->getCountry($phone);

        // Убираем обслуживающую страну
        $smsServices = [];
        foreach ($this->smsServices as $smsService) {
            if ($smsService->isAcceptedCountry($country)) {
                $price = $smsService->getPrice();
                $smsServices[$price] = $smsService;
            }
        }

        // Сортируем сервисы по цене
        ksort($smsServices);

        // Отправляем
        foreach ($smsServices as $smsService) {
            if ($smsService->send($phone)) {
                $result = true;
                break;
            }
        }

        return $result;
    }
}
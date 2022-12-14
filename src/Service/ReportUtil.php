<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\Device;
use App\Entity\Worker;
use App\Repository\DeviceRepository;
use App\Repository\SpecificationRepository;
use App\Repository\WorkerRepository;
use Doctrine\Common\Collections\Criteria;

class ReportUtil
{
    private DeviceRepository $deviceRepository;
    private SpecificationRepository $specificationRepository;
    private WorkerRepository $workerRepository;


    public function __construct(DeviceRepository $deviceRepository, SpecificationRepository $specificationRepository, WorkerRepository $workerRepository)
    {
        $this->deviceRepository = $deviceRepository;
        $this->specificationRepository = $specificationRepository;
        $this->workerRepository = $workerRepository;
    }

    public function reportManufacturer(): array
    {
        return $this->deviceRepository->findManufacturer();
    }

    public function reportManufacturer_worker($group): array
    {
        $workers = $this->workerRepository->findBy(['ad_group'=>$group]);
        return $this->deviceRepository->findManufacturerForGroup($workers);
//        return $this->deviceRepository->findBy(['user'=>$workers]);
    }

    public function reportType(): array
    {
        return $this->deviceRepository->findType();
    }

    public function reportType_worker($group): array
    {
        $workers = $this->workerRepository->findBy(['ad_group'=>$group]);
        return $this->deviceRepository->findTypeForGroup($workers);
    }

    public function reportWindows(): array
    {
        return $this->deviceRepository->findWindows();
    }

    public function reportWindows_worker($group): array
    {
        $workers = $this->workerRepository->findBy(['ad_group'=>$group]);
        return $this->deviceRepository->findWindowsForGroup($workers);
    }
    public function reportModelSummary(): array
    {
        return $this->deviceRepository->findModelSummary();
    }

    public function reportModelSummary_worker($group): array
    {
        $workers = $this->workerRepository->findBy(['ad_group'=>$group]);
        return $this->deviceRepository->findModelSummaryForGroup($workers);
    }

    /**
     * @return Device[]
     */
    public function reportWarrantyExp(): array
    {
        $devices = $this->deviceRepository->findAll();
        return $devices;
    }

    public function reportWarrantyExp_worker($group): array
    {
        $workers = $this->workerRepository->findBy(['ad_group'=>$group]);
        return $this->deviceRepository->findBy(['user'=>$workers]);
    }

//    public function reportWorker_device(): array
//    {
//        $criteria = new Criteria();
//        $criteria->where(Criteria::expr()->);
//        $workers = $this->workerRepository->findAll();
//        return $workers;
//    }
//
//    public function reportWorker_device_group($group): array
//    {
//        $workers = $this->workerRepository->findBy(['ad_group'=>$group]);
//        return $this->deviceRepository->findBy(['user'=>$workers]);
//    }

    public  function reportDeviceWithoutUser(): array{
        return $this->deviceRepository->findBy(['user'=>null]);
    }

    public function reportHardDiskType(): array
    {
        $devices = $this->deviceRepository->findAll();
        return $devices;
    }
//    public function getWeatherForCountryAndCity(string $countryCode, string $cityName){
//        $cityrep = $this->cityRepository->findBy([
//            'country' => $countryCode,
//            'name' => $cityName,
//        ]);
//        $measurements = $this->measurementRepository->findByLocation($cityrep[0]);
//        return $measurements;
//    }
//
//    public function getWeatherForLocation(City $city)
//    {
//        $measurements = $this->measurementRepository->findByLocation($city);
//
//        return $measurements;
//    }
}
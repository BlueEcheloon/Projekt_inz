<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Service\ReportUtil;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/report')]
#[IsGranted("ROLE_USER")]
class ReportController extends AbstractController
{
    #[Route('/', name: 'app_report_index')]
    public function index(): Response
    {
        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
    #[Route('/manufacturer', name: 'app_report_manufacturer')]
    public function manufacturer(ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $manufacturers=$reportUtil->reportManufacturer_worker($admin_group);
        }else{
            $manufacturers = $reportUtil->reportManufacturer();
        }
        return $this->render("report/manufacturer.html.twig",[
            'manufacturers'=>$manufacturers
        ]);
    }
    #[Route('/type', name: 'app_report_type')]
    public function type(ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $type=$reportUtil->reportType_worker($admin_group);
        }else{
            $type = $reportUtil->reportType();
        }
        return $this->render("report/type.html.twig",[
            'type'=>$type
        ]);
    }
    #[Route('/windows', name: 'app_report_windows')]
    public function windows(ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $windows = $reportUtil->reportWindows_worker($admin_group);
        }else{
            $windows = $reportUtil->reportWindows();
        }
        return $this->render("report/windows.html.twig",[
            'windows'=>$windows
        ]);
    }
    #[Route('/model_summary', name: 'app_report_model_summary')]
    public function model_summary(ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $model = $reportUtil->reportModelSummary_worker($admin_group);
        }else{
            $model = $reportUtil->reportModelSummary();
        }
        return $this->render("report/model_summary.html.twig",[
            'models'=>$model
        ]);
    }

    #[Route('/warranty_exp', name: 'app_report_warranty_exp')]
    public function warranty_exp(ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $devices = $reportUtil->reportWarrantyExp_worker($admin_group);
        }else{
            $devices = $reportUtil->reportWarrantyExp();
        }
        return $this->render("report/warranty_exp.html.twig",[
            'devices'=>$devices
        ]);
    }

    #[Route('/user_device', name: 'app_report_user_device')]
    public function user_device(ReportUtil $reportUtil): Response
    {
        $user = $this->getUser();
        if($this->isGranted('ROLE_MANAGER')){
            $admin_group=$user->getAdminGroup();
            $workers = $reportUtil->reportWorker_device_group($admin_group);
        }else{
            $workers = $reportUtil->reportWorker_device();
        }
        return $this->render("report/warranty_exp.html.twig",[
            'workers'=>$workers
        ]);
    }

    #[IsGranted("ROLE_REPORT")]
    #[Route('/device_user', name: 'app_report_device_user')]
    public function device_user(ReportUtil $reportUtil): Response
    {
        $devices = $reportUtil->reportDeviceWithoutUser();
        return $this->render("report/device_user.html.twig",[
            'devices'=>$devices
        ]);
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route('/harddisk', name: 'app_report_harddisk')]
    public function hard_disk_types(ReportUtil $reportUtil): Response
    {
        $devices = $reportUtil->reportHardDiskType();
        return $this->render("report/harddisk.html.twig",[
            'devices'=>$devices
        ]);
    }
}

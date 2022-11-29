<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // User Model
        $this->usersModel = new \App\Models\UsersModel();
        $this->rangkingSimulasi = new \App\Models\RangkingSimulasi();
        $this->eventReangkingSimulasi = new \App\Models\EventRangkingSimulasi();
        $this->bankQuizModel = new \App\Models\BankQuizModel();
        $this->bankSoalModel = new \App\Models\BankSoalModel();
        $this->typeSoalModel = new \App\Models\TypeSoalModel();

        // Kampus
        $this->universitasModel = new \App\Models\UniversitasModel();

        // Shop
        $this->UtbkShopModel = new \App\Models\UtbkShopModel();

        // TRANSAKSI
        $this->utbkShopModel = new \App\Models\UtbkShopModel();
        $this->akunPremiumModel = new \App\Models\AkunPremiumModel();
        $this->akunEventModel = new \App\Models\AkunEventModel();
        $this->transaksiUserModel = new \App\Models\TransaksiUserModel();

        // E.g.: $this->session = \Config\Services::session();
    }
}

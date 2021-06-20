<?php
namespace EssenceList\Controllers;

use EssenceList\Database\EssenceDataGateway;
use EssenceList\Helpers\Pager;

class HomeController extends BaseController
{
    private $pager;
    private $essenceDataGateway;

    public function __construct(string $requestMethod,
                                Pager $pager,
                                EssenceDataGateway $essenceDataGateway)
    {
        $this->requestMethod = $requestMethod;
        $this->pager = $pager;
        $this->essenceDataGateway = $essenceDataGateway;
    }

    private function processGetRequest()
    {
        $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;
        $perPage = 10;
        $offset = $this->pager->calculatePositioning($page, $perPage);
        $essences = $this->essenceDataGateway->getEssences($offset,$perPage);
        $columnCount = $this->essenceDataGateway->countTableRows();
        $totalPages = $this->pager->calculateTotalPages($columnCount, $perPage);

        $params["totalPages"] = $totalPages;
        $params["essences"] = $essences;

        $this->render(__DIR__."/../../views/home.view.php",$params);
    }

    private function render($file, $params = [])
    {
        extract($params,EXTR_SKIP);
        return require_once "{$file}";
    }

    public function run()
    {
      if ($this->requestMethod === "GET") {
          $this->processGetRequest();
      }
    }
}

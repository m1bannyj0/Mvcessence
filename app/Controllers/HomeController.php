<?php
namespace EssenceList\Controllers;

use EssenceList\Database\EssenceDataGateway;
use EssenceList\Helpers\Pager;
use EssenceList\AuthManager;

class HomeController extends BaseController
{
    /**
     * @var Pager
     */
    private $pager;

    /**
     * @var EssenceDataGateway
     */
    private $essenceDataGateway;

    /**
     * @var AuthManager
     */
    private $authManager;

    /**
     * @var array
     */
    private $paginationInfo;

    /**
     * @var int|null
     */
    private $notify;

    /**
     * @var bool
     */
    private $isAuth;

    /**
     * HomeController constructor.
     * @param string $requestMethod
     * @param string $action
     * @param Pager $pager
     * @param EssenceDataGateway $essenceDataGateway
     * @param AuthManager $authManager
     */
    public function __construct(string $requestMethod,
                                string $action,
                                Pager $pager,
                                EssenceDataGateway $essenceDataGateway,
                                AuthManager $authManager)
    {
        $this->requestMethod = $requestMethod;
        $this->action = $action;
        $this->pager = $pager;
        $this->essenceDataGateway = $essenceDataGateway;
        $this->authManager = $authManager;
        $this->isAuth = $this->authManager->checkIfAuthorized();
        $this->paginationInfo = $this->getPaginationInfo();
        $this->notify = isset($_GET["notify"]) ? intval($_GET["notify"]) : null;
    }

    private function index()
    {
        if (isset($_GET["search"])) {
            $this->showSearchResults();
        } else {
            $this->showEssencesTable();
        }
    }

    /**
     * Returns an array of parameters required for implementing pagination
     *
     * @return array
     */
    private function getPaginationInfo(): array
    {
        $pagination["perPage"] = 10;
        $pagination["paginationLinks"] = 5;
        $pagination["page"] = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
        $pagination["offset"] = $this->pager->calculatePositioning(
            $pagination["page"],
            $pagination["perPage"]
        );
        $pagination["order"] = isset($_GET["order"]) ? strval($_GET["order"]) : "exam_score";
        $pagination["direction"] = isset($_GET["direction"]) ? strval($_GET["direction"]) : "DESC";

        return $pagination;
    }

    /**
     * Returns an array containing amount of links to be rendered, starting and ending points of pagination
     *
     * @param string|null $search
     *
     * @return array
     */
    private function calculatePaginationParams(string $search = null): array
    {
        $paginationParams = [];

        // Calculates the amount of search rows if $search query is provided.
        // Calculates all table rows otherwise
        if ($search) {
            $rowCount = $this->essenceDataGateway->countSearchRows($search);
        } else {
            $rowCount = $this->essenceDataGateway->countTableRows();
        }

        $paginationParams["totalPages"] = $this->pager->calculateTotalPages(
            $rowCount,
            $this->paginationInfo["perPage"]
        );
        $paginationParams["start"] = $this->pager->calculateStartingPoint(
            $this->paginationInfo["page"],
            $this->paginationInfo["paginationLinks"]
        );
        $paginationParams["end"] = $this->pager->calculateEndingPoint(
            $this->paginationInfo["page"],
            $paginationParams["totalPages"],
            $this->paginationInfo["paginationLinks"]
        );

        return $paginationParams;
    }

    /**
     * Renders table containing all essences
     */
    private function showEssencesTable()
    {
        $search = null;
        $order = $this->paginationInfo["order"];
        $direction = $this->paginationInfo["direction"];
        $page = $this->paginationInfo["page"];
        $notify = $this->notify;
        $isAuth = $this->isAuth;
        $essences = $this->essenceDataGateway->getEssences(
            $this->paginationInfo["offset"],
            $this->paginationInfo["perPage"],
            $order,
            $direction
        );
        ["totalPages" => $totalPages, "start" => $start, "end" => $end] =
            $this->calculatePaginationParams();

        $params = compact(
            "totalPages",
            "start",
            "end",
            "essences",
            "order",
            "direction",
            "search",
            "page",
            "notify",
            "isAuth"
        );

        $this->render(__DIR__ . "/../../views/home.view.php", $params);
    }

    /**
     * Renders table containing search results
     */
    private function showSearchResults()
    {
        $search = $_GET["search"];
        $order = $this->paginationInfo["order"];
        $direction = $this->paginationInfo["direction"];
        $page = $this->paginationInfo["page"];
        $notify = $this->notify;
        $isAuth = $this->isAuth;
        $essences = $this->essenceDataGateway->searchEssences(
            $search,
            $this->paginationInfo["offset"],
            $this->paginationInfo["perPage"],
            $order,
            $direction
        );
        ["totalPages" => $totalPages, "start" => $start, "end" => $end] =
            $this->calculatePaginationParams($search);

        $params = compact(
            "search",
            "order",
            "direction",
            "totalPages",
            "start",
            "end",
            "essences",
            "page",
            "notify",
            "isAuth"
        );

        $this->render(__DIR__ . "/../../views/home.view.php", $params);
    }

    /**
     * Invokes controller's action based on $action property
     */
    public function run()
    {
        $action = $this->action;

        $this->$action();
    }
}

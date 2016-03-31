<?php


namespace EventBundle\Controller;


use EventBundle\Reporting\EventReportManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ReportController extends Controller
{
    /**
     * @Route("/events/report/recentlyUploaded.csv")
     */
    public function updatedEventAction()
    {
        $eventReportManager = $this->container->get('event_report_manager');

        $content = $eventReportManager->getRecentlyUpdatedReport();

        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/csv');

        return $response;
    }
}
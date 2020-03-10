<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Page;
use Sonata\AdminBundle\Controller\CoreController;

class PageController extends CoreController
{
    public function get($slug): JsonResponse
    {
        $Page = $this->getDoctrine()
                ->getRepository(Page::class)
                ->findOneBy(['slug' => $slug]);
        $data = [];
        if ($Page instanceof Page) {
            $data = $Page->toArray();
        }
        $response = new JsonResponse();
        $response->setData([
            'data' => $data
        ]);
        return $response;
    }
}
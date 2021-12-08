<?php
namespace App\Controller;
use App\Entity\Colis;
use App\Form\ColisType;
use App\Repository\ColisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use Dompdf\Options;
use App\Entity\Recherche;
use App\Form\RechercheType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
/**
 * @Route("/colis")
 */
class ColisController extends AbstractController
{
    /**
     * @Route("/", name="colis_index",)
     */
        public function home(Request $request, ColisRepository $colisRepository )
    {
        $recherche = new Recherche();
        $form = $this->createForm(RechercheType::class,$recherche);
        $form->handleRequest($request);

        $colis= $colisRepository->findAll();;

        if($form->isSubmitted() && $form->isValid()) {

            $departure = $recherche->getDeparture();
            if ($departure!="")

                $colis= $this->getDoctrine()->getRepository(Colis::class)->findBy(['departure' => $departure] );
            else

                $user= $this->getDoctrine()->getRepository(Colis::class)->findAll();
        }
        return $this->render('colis/index.html.twig',[ 'form' =>$form->createView(),
            'coli' => $colis ]);
    }



      //  return $this->render('colis/index.html.twig', [
       //     'coli' => $colisRepository->findAll(),
       // ]);



     /**
     * @Route("/listep", name="colis_list", methods={"GET"})
     */
    public function listep(ColisRepository $colisRepository,Request $request): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $coli = $colisRepository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('colis/listep.html.twig', [
            'coli' => $coli,

        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A2', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }
    /**
     * @Route("/new", name="colis_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        
        $colis = new Colis();
        $form = $this->createForm(ColisType::class, $colis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $colis->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            try {
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $entityManager = $this->getDoctrine()->getManager();
            $colis->setImage($fileName);
            $entityManager->persist($colis);
            $entityManager->flush();
            $this->addFlash('success', 'votre Colis sera prise en compte et nous vous livrer dans les meilleurs délais');
            return $this->redirectToRoute('colis_index');
        }

        return $this->render('colis/new.html.twig', [
            'colis' => $colis,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="colis_show", methods={"GET"})
     */
    public function show(Colis $colis,Request $request): Response
    {


        return $this->render('colis/show.html.twig', [
            'colis' => $colis,
        ]);

    }
    /**
     * @Route("/{id}/edit", name="colis_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Colis $colis): Response
    {
        
        $form = $this->createForm(ColisType::class, $colis);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('colis_index');
        }

        return $this->render('colis/edit.html.twig', [
            'colis' => $colis,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="colis_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Colis $colis): Response
    {


        if ($this->isCsrfTokenValid('delete'.$colis->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($colis);
            $entityManager->flush();
            $this->addFlash('success', 'Votre  colis a été supprimé');
        }

            return $this->redirectToRoute('colis_index');

        }
    /**
     * @Route("{id}/stat", name="stat_index")
     */
    public function indexAction(){
        $repository = $this->getDoctrine()->getRepository(colis::class);
        $colis = $repository->findAll();
        $em = $this->getDoctrine()->getManager();

        $dept=0;
        $deps=0;
        $depn=0;
        $depk=0;


        foreach ($colis as $colis)
       {
           if (  $colis->getDeparture()=="tunis")  :

                $dept=$dept+1 ;

           elseif ($colis->getDeparture()=="soussa"):

               $deps=$deps+1;
           elseif ($colis->getDeparture()=="nabel"):

               $depn=$depn+1;
           elseif ($colis->getDeparture()=="kassrin"):

               $depk=$depk+1;


           endif;

        }


        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['type', 'nombre'],
                ['Tunis',     $dept],
                ['Soussa',      $deps],
                ['Nabel',   $depn],
                ['Kassrin',   $depk]
            ]
        );
        $pieChart->getOptions()->setTitle('Top Transportation');
        $pieChart->getOptions()->setHeight(600);
        $pieChart->getOptions()->setWidth(950);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(35);

        return $this->render('chart/index.html.twig', array('piechart' => $pieChart));
    }



}

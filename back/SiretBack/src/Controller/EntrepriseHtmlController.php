<?php

namespace App\Controller;

use App\Entity\Entreprise;
use App\Form\EntrepriseType;
use App\Repository\EntrepriseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;


// controller pour renvoie de page HTML

#[Route('/entrepriseHtml')]
class EntrepriseHtmlController extends AbstractController
{

   /**
     * 
     * @OA\Get(
     *     path="/entreprise",
     *     summary="Retrieve the list of all enterprises",
     *     description="Returns a html list of all enterprises in the system",
     *     @OA\Response(
     *         response=200,
     *         description="A html list of enterprises",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref=@Model(type=Entreprise::class))
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No enterprises found"
     *     )
     * )
     */
    #[Route('/', name: 'app_entreprise_index', methods: ['GET'])]
    public function indexHtml(EntrepriseRepository $entrepriseRepository): Response
    {
        return $this->render('entreprise/index.html.twig', [
            'entreprises' => $entrepriseRepository->findAll(),
        ]);
        
    }


 /**
     * @OA\Get(
     *     path="/entreprise/{id}/edit",
     *     summary="Display a form to create an enterprise",
     *     description="Returns a form for editing an existing enterprise identified by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the enterprise to edit",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Form for editing the enterprise",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="form",
     *                 type="string",
     *                 description="Form fields for editing the enterprise"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     * @OA\Post(
     *     path="/entreprise/{id}/edit",
     *     summary="Create an enterprise",
     *     description="Create an existing enterprise identified by its ID with the data provided",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the enterprise to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Form data to update the enterprise",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="email", type="string")
     *                 // Add other properties as per your form fields
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=303,
     *         description="Redirects to the list of enterprises after successful Create"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, form data is invalid"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     */ 
    #[Route('/new', name: 'app_entreprise_new', methods: ['GET', 'POST'])]
    public function newHtml(Request $request, EntityManagerInterface $entityManager): Response
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise); #creation formulaire
        $form->handleRequest($request); # Si Post remplir formulaire

        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($entreprise);
            $entityManager->flush(); # execute requete SQL pour ajout dans la DB

            return $this->redirectToRoute('app_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entreprise/new.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]); #redirection formulaire si not good
    }


    /**
     * @OA\Get(
     *     path="/entreprise/{id}",
     *     summary="Retrieve details of a specific enterprise",
     *     description="Returns the details of a specific enterprise by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the enterprise",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Details of the enterprise",
     *         @OA\JsonContent(ref=@Model(type=Entreprise::class))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     */
    #[Route('/{id}', name: 'app_entreprise_show', methods: ['GET'])]
    public function showHtml(Entreprise $entreprise): Response
    {
        return $this->render('entreprise/show.html.twig', [
            'entreprise' => $entreprise,
        ]);
    }



     /**
     * @OA\Get(
     *     path="/entreprise/{id}/edit",
     *     summary="Display a form to edit an enterprise",
     *     description="Returns a form for editing an existing enterprise identified by its ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the enterprise to edit",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Form for editing the enterprise",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="form",
     *                 type="string",
     *                 description="Form fields for editing the enterprise"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     * @OA\Post(
     *     path="/entreprise/{id}/edit",
     *     summary="Update an enterprise",
     *     description="Updates an existing enterprise identified by its ID with the data provided",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="The ID of the enterprise to update",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="Form data to update the enterprise",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="name", type="string"),
     *                 @OA\Property(property="address", type="string"),
     *                 @OA\Property(property="email", type="string")
     *                 // Add other properties as per your form fields
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=303,
     *         description="Redirects to the list of enterprises after successful update"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Bad request, form data is invalid"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     */
    #[Route('/{id}/edit', name: 'app_entreprise_edit', methods: ['GET', 'POST'])]
    public function editHtml(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_entreprise_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('entreprise/edit.html.twig', [
            'entreprise' => $entreprise,
            'form' => $form,
        ]);
    }




    
    /**
     * @OA\Delete(
     *     path="/entreprise/{id}",
     *     summary="Delete an enterprise",
     *     description="Deletes a specific enterprise by ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="The ID of the enterprise to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         description="CSRF token required to delete the enterprise",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="_token",
     *                     type="string",
     *                     description="CSRF token"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=303,
     *         description="Redirect to the list of enterprises after successful deletion"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     */
    #[Route('/{id}', name: 'app_entreprise_delete', methods: ['POST'])]
    public function deleteHtml(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($entreprise);
        $entityManager->flush();

        return $this->redirectToRoute('app_entreprise_index', [], Response::HTTP_SEE_OTHER);
    }
}

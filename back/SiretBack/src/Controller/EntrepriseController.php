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
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @OA\Tag(name="JSON")
 */
#[Route('/entreprise')]
class EntrepriseController extends AbstractController
{

   /**
     * Cette méthode permet de récupérer l'ensemble des entreprises. 
     * 
     * @OA\Response(
     *     response=200,
     *     description="Retourne la liste des livres",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Book   ::class, groups={"getBooks"}))
     *     )
     * ) 
     * 
     * @param EntrepriseRepository $entrepriseRepository
     * @return JsonResponse
     * 
     */
    #[Route('/', methods: ['GET'])]
    public function all(EntrepriseRepository $entrepriseRepository): JsonResponse
    {
        $entreprises = $entrepriseRepository->findAll();

        $data = [];
        foreach ($entreprises as $entreprise) {
            $data[] = [
                'id' => $entreprise->getId(),
                'SIRET' => $entreprise->getSIRET(),
                'Nom' => $entreprise->getNom(),
                'Adresse' =>  $entreprise->getAdresse(),
                'SIREN' =>  $entreprise->getSIREN(),
                'Tva' =>  $entreprise->getTVA(),
            ];
        }
    
        return new JsonResponse($data);    
    }


    /**
     * 
     * Méthode d'ajout d'entreprise
     * 
     * @OA\Post(
     *     path="/entreprise/{id}/edit",
     *     summary="Create an enterprise",
     *     description="Create an existing enterprise identified by its ID with the data provided",
  
     *     @OA\RequestBody(
     *         description="Form data to update the enterprise",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(property="Nom", type="string"),
     *                 @OA\Property(property="Address", type="string"),
     *                 @OA\Property(property="SIRET", type="string"),
     *                 @OA\Property(property="SIREN", type="string")
     *                 @OA\Property(property="Tva", type="string"),
     *                 // Add other properties as per your form fields
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Enterprise not found"
     *     )
     * )
     * 
     */ 
    #[Route('/new',  methods: ['POST'])]
    public function newOne(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $entreprise = new Entreprise();
        $form = $this->createForm(EntrepriseType::class, $entreprise); #creation formulaire
        $form->handleRequest($request); # Si Post remplir formulaire

        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($entreprise);
            $entityManager->flush(); # execute requete SQL pour ajout dans la DB

            return $this->json([
                'message' => 'entreprise Edit',
                'Status' => Response::HTTP_OK,
            ]);
        }
        else{
            return $this->json([
                'message' => 'Erreur entreprise non Ajouter',
                'Status' => Response::HTTP_BAD_REQUEST,
            ]);
        }
    }

    /**
     * Méthode pour obtenir une entreprise ciblé
     * 
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
     * 
     */
    #[Route('/{id}', methods: ['GET'])]
    public function showOne(Entreprise $entreprise): Response
    {
        $data[] = [
            'id' => $entreprise->getId(),
            'SIRET' => $entreprise->getSIRET(),
            'Nom' => $entreprise->getNom(),
            'Adresse' =>  $entreprise->getAdresse(),
            'SIREN' =>  $entreprise->getSIREN(),
            'Tva' =>  $entreprise->getTVA(),
        ];
        return new JsonResponse($data);
    }

     /**
     * 
     * Méthode pour modifier une entreprise ciblé
     * 
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
     * 
     */
    #[Route('/{id}/edit', methods: ['POST'])]
    public function editOne(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EntrepriseType::class, $entreprise);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();


            return $this->json([
                'message' => 'entreprise Edit',
                'Status' => Response::HTTP_OK,
            ]);
        }

        else{
            return $this->json([
                'message' => 'entreprise not Edit',
                'Status' => Response::HTTP_BAD_REQUEST,
            ]);
        }
    }

    
    /**
     * 
     *  Méthode pour delete une entreprise ciblé
     * 
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
     * 
     */
    #[Route('/{id}', methods: ['POST'])]
    public function deleteOne(Request $request, Entreprise $entreprise, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($entreprise);
        $entityManager->flush();
        return $this->json([
            'message' => 'entreprise delete',
            'Status' => Response::HTTP_OK,
        ]);   
       
    }
}

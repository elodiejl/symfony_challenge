<?php

namespace App\Controller;

use App\Entity\Art;
use App\Repository\ArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Stripe;


#[Route('/buyer/cart')]
class CartController extends AbstractController
{


    #[Route('/', name: 'buyer_cart_index')]
    public function index(SessionInterface $session, ArtRepository $artRepository): Response
    {
        $cart = $session->get("cart", []);
        $dataCart= [];
        $total = 0;

        foreach ($cart as $id => $quantity){
            $art = $artRepository->find($id);
            $dataCart[] = [
                "oeuvre" => $art,
                "quantity" => $quantity
            ];
            $total += $art->getPrice() * $quantity;
        };

        return $this->render('buyer/cart/index.html.twig', compact("dataCart", "total"));
    }

    #[Route('/add/{id}', name: 'buyer_cart_add')]
    public function add(Art $art, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $cart = $session->get("cart", []);
        $id = $art->getId();
        if(!empty($cart[$id])){
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        };

        $session->set("cart", $cart);

        return $this->redirectToRoute("buyer_cart_index");

    }

    #[Route('/delete/{id}', name: 'cart_delete')]
    public function delete(Art $art, SessionInterface $session): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        $cart = $session->get("cart", []);
        $id = $art->getId();
        if(!empty($cart[$id])){
            unset($cart[$id]);
        };

        $session->set("cart", $cart);

        return $this->redirectToRoute("buyer_cart_index");

    }

    // payment's functions

    #[Route('/stripe', name: 'app_stripe')]
    public function stripe(): Response
    {
        return $this->render('stripe/index.html.twig', [
            'stripe_key' => $_ENV["STRIPE_KEY"],
        ]);
    }

    #[Route('/stripe/create-payment', name: 'app_stripe_payment', methods: ['POST'])]
    public function createPayment(Request $request, SessionInterface $session, ArtRepository $artRepository)
    {
        $cart = $session->get("cart", []);
        $dataCart= [];
        $total = 0;

        foreach ($cart as $id => $quantity){
            $art = $artRepository->find($id);
            $dataCart[] = [
                "oeuvre" => $art,
                "quantity" => $quantity
            ];
            $total += $art->getPrice() * $quantity;
        };

        Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        Stripe\Charge::create ([
            "amount" => $total,
            "currency" => "eur",
            "source" => $request->request->get('stripeToken'),
            "description" => "Binaryboxtuts Payment Test"
        ]);
        $this->addFlash(
            'success',
            "` Paiement validé : {$total} € au total`"
        );
        return $this->redirectToRoute('app_stripe', [], Response::HTTP_SEE_OTHER);
    }
}

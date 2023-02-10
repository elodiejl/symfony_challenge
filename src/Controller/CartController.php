<?php

namespace App\Controller;

use App\Entity\Art;
use App\Repository\ArtRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

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
}

<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use LDAP\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Contacto;
use App\Entity\Provincia;
use App\Entity\User;
use App\Form\ContactoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactoController extends AbstractController
{

    private $contactos = [
        1 => ["nombre" => "Juan Pérez", "telefono" => "524142432", "email" => "juanp@ieselcaminas.org"],
        2 => ["nombre" => "Ana López", "telefono" => "58958448", "email" => "anita@ieselcaminas.org"],
        5 => ["nombre" => "Mario Montero", "telefono" => "5326824", "email" => "mario.mont@ieselcaminas.org"],
        7 => ["nombre" => "Laura Martínez", "telefono" => "42898966", "email" => "lm2000@ieselcaminas.org"],
        9 => ["nombre" => "Nora Jover", "telefono" => "54565859", "email" => "norajover@ieselcaminas.org"]
    ];

    #[Route('/contacto/insertar', name: "insertar_contacto")]
    public function insertar(ManagerRegistry $doctrine)
    {
        $entityManager = $doctrine->getManager();
        foreach ($this->contactos as $c) {
            $contacto = new Contacto();
            $contacto->setNombre($c["nombre"]);
            $contacto->setTelefono($c["telefono"]);
            $contacto->setEmail($c["email"]);
            $entityManager->persist($contacto);
        }

        try {
            $entityManager->flush();
            return new Response("Contactos insertados");
        } catch (\Exception $e) {
            return new Response("Error insertando objetos");
            $e->getMessage();
        }
    }

    #[Route("/contacto/nuevo", name: "nuevo_contacto")]
    public function nuevo(ManagerRegistry $doctrine, Request $request)
    {
        $contacto = new Contacto();

        $formulario = $this->createForm(ContactoType::class, $contacto);

        $formulario->handleRequest($request);

        if ($formulario->isSubmitted() && $formulario->isValid()) {
            $contacto = $formulario->getData();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($contacto);
            $entityManager->flush();
            return $this->redirectToRoute('ficha_contacto.html.twig', ["codigo" => $contacto->getId(), "contacto" => $contacto]);
        }

        return $this->render('nuevo.html.twig', array('formulario' => $formulario->createView()));
    }

    #[Route("/contacto/editar/{codigo}", name: "editar_contacto")]
    public function editar(ManagerRegistry $doctrine, Request $request, $codigo)
    {

        $repositorio = $doctrine->getRepository(Contacto::class);
        $contacto = $repositorio->find($codigo);

        if ($contacto) {
            $formulario = $this->createForm(ContactoType::class, $contacto);

            $formulario->handleRequest($request);

            if ($formulario->isSubmitted() && $formulario->isValid()) {
                $contacto = $formulario->getData();
                $entityManager = $doctrine->getManager();
                $entityManager->persist($contacto);
                $entityManager->flush();
                return $this->redirectToRoute('app_index');
            }

            return $this->render('editar.html.twig', array('formulario' => $formulario->createView()));
        } else {
            return $this->render('ficha_contacto.html.twig', ['contacto' => null]);
        }
    }

    #[Route('/contacto/delete/{id}', name: "eliminar_contacto")]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Contacto::class);
        $contacto = $repositorio->find($id);
        if ($contacto) {
            try {
                $entityManager->remove($contacto);
                $entityManager->flush();
                return new Response("Contacto eliminado");
            } catch (\Exception $e) {
                return new Response("Error eliminando el objeto");
            }
        } else {
            return $this->render('ficha_contacto.html.twig', ['contacto' => null]);
        }
    }

    #[Route("/contacto/insertarSinProvincia", name: "insertar_sin_provincia_contacto")]
    public function insertarSinProvincia(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Provincia::class);

        $provincia = $repositorio->findOneBy(["nombre" => "Alicante"]);

        $contacto = new Contacto();

        $contacto->setNombre("Inserción de prueba sin provincia");
        $contacto->setTelefono("900220022");
        $contacto->setEmail("insercion.de.prueba.sin.provincia@contacto.es");
        $contacto->setProvincia($provincia);

        $entityManager->persist($contacto);

        $entityManager->flush();
        return $this->render('ficha_contacto.html.twig', ['contacto' => $contacto]);
    }

    #[Route('/contacto/{codigo}', name: 'app_contacto')]
    public function ficha(ManagerRegistry $doctrine, $codigo, SessionInterface $session, Request $request): Response
    {
        $user = $this->getUser();

        if ($user) {
            $repositorio = $doctrine->getRepository(Contacto::class);
            $contacto = $repositorio->find($codigo);

            return $this->render('ficha_contacto.html.twig', ['contacto' => $contacto]);
        } else {
            //Esto se hace para que cuando no se haya logueado, se proceda a crear una sesion, para que a la hora de hacer el login, nos redirija aquí.
            $url = parse_url($request->getUri());
            $session->set('url', $url['path']);
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/', name: 'app_index')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repositorio = $doctrine->getRepository(Contacto::class);
        $contactos = $repositorio->findAll();
        return $this->render('lista_contactos.html.twig', [
            'controller_name' => 'ContactoController', 'contactos' => $contactos,
        ]);
    }

    #[Route('/contacto/buscar/{texto}', name: 'buscar_contacto')]
    public function buscar(ManagerRegistry $doctrine, $texto): Response
    {
        $repositorio = $doctrine->getRepository(Contacto::class);
        $contactos = $repositorio->findByName($texto);
        return $this->render('lista_contactos.html.twig', ['contactos' => $contactos]);
    }

    #[Route('/contacto/update/{id}/{nombre}', name: "modificar_contacto")]
    public function update(ManagerRegistry $doctrine, $id, $nombre): Response
    {
        $entityManager = $doctrine->getManager();
        $repositorio = $doctrine->getRepository(Contacto::class);
        $contacto = $repositorio->find($id);
        if ($contacto) {
            $contacto->setNombre($nombre);
            try {
                $entityManager->flush();
                return $this->render('ficha_contacto.html.twig', ['contacto' => $contacto]);
            } catch (\Exception $e) {
                return new Response("Error insertando objetos");
            }
        } else {
            return $this->render('ficha_contacto.html.twig', ['contacto' => null]);
        }
    }

    #[Route("/contacto/insertarConProvincia", name: "insertar_con_provincia_contacto")]
    public function insertarConProvincia(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $provincia = new Provincia();
        $provincia->setNombre("Alicante");
        $contacto = new Contacto();

        $contacto->setNombre("Inserción de prueba con provincia");
        $contacto->setTelefono("900220022");
        $contacto->setEmail("insercion.de.prueba.provincia@contacto.es");
        $contacto->setProvincia($provincia);

        $entityManager->persist($provincia);
        $entityManager->persist($contacto);

        $entityManager->flush();
        return $this->render('ficha_contacto.html.twig', ["contacto" => $contacto]);
    }
}

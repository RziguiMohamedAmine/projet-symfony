<?php



namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPasswordValidator;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


class  UtilisateurApiController extends AbstractController
{
    /**
     * @Route ("/signupp",name="app_register_mobile", methods={"GET","POST"})
     */
    public function signupAction(Request $request,UserPasswordEncoderInterface $passwordEncoder ){

        $email =$request->query->get("email");
        $roles =$request->query->get("roles");
        $password =$request->query->get("password");
        $nom =$request->query->get("nom");
        $prenom =$request->query->get("prenom");
        $tel =$request->query->get("tel");

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return new Response("email invalid.");
        }
        $user = new User();
        $user->setPrenom($prenom);
        $user->setNom($nom);
        $user->setEmail($email);
        $user->setPassword($passwordEncoder->encodePassword($user,$password));
        $user->setIsVerified(true);
        $user->setTel($tel);
        $user->setRoles(array($roles));

        try{
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("Account is created",200);
        }catch (\Exception $ex){
            return  new Response("execption".$ex->getMessage());
        }

    }
    /**
     * @Route ("/signinn",name="app_login_mobile")
     */
    public function signinAction(Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $email =$request->query->get("email");
        $password = $request->query->get("password");

        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->findOneBy(['email'=>$email]);

        if($user){
            dump($password);

            if($passwordEncoder->isPasswordValid($user, $password)){
               $serializer = new Serializer([new ObjectNormalizer()]);
               $formatted = $serializer->normalize($user);
               return new JsonResponse($formatted);
            }
            else {
                return  new Response("password not found");
            }

        }
        else{
            return  new Response("user not found");
        }
    }
    /**
     * @Route ("/editUser",name="app_gestion_profile")
     */

    public function editUser(Request $request,UserPasswordEncoderInterface $passwordEncoder){
        $id = $request->get("id");
        $nom =$request->query->get("nom");
        $prenom =$request->query->get("prenom");
        $email =$request->query->get("email");
        $password =$request->query->get("password");
        $em =$this->getDoctrine()->getManager();
        $user =$em->getRepository(User::class)->find($id);
        $user->setNom($nom);
        $user->setPrenom($prenom);
        $user->setPassword($passwordEncoder->encodePassword(
            $user,$password
        ));
        $user->setEmail($email);
        $user->setIsVerified(true);

        try{
            $em =$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return new JsonResponse("success",200);
        }catch (\Exception $ex){
            return new Response("fail".$ex->getMessage());
        }

    }
}
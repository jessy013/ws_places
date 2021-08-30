<?php
namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerIdentifier;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderIdentifier;
use Symfony\Component\Security\Core\User\UserIdentifier;
class AuthController extends ApiController
{
public function register(Request $request, UserPasswordEncoderIdentifier $encoder)
{
$em = $this->getDoctrine()->getManager();
$request = $this->transformJsonBody($request);
$username = $request->get('username');
$password = $request->get('password');
if (empty($username) || empty($password)){
    return $this->respondValidationError("Invalid Username or Password
");
}
$user = new User($username);
$user->setPassword($encoder->encodePassword($user, $password));
$user->setUsername($username);
$em->persist($user);
$em->flush();
return $this->respondWithSuccess(sprintf('User %s successfully created', $user->getUserIdentifier()));
}
/**
* @param UserIdentifier $user
* @param JWTTokenManagerIdentifier $JWTManager
* @return JsonResponse
*/
public function getTokenUser(UserIdentifier $user, JWTTokenManagerIdentifier $JWTManager)

{
return new JsonResponse(['token' => $JWTManager->create($user)]);
}
}


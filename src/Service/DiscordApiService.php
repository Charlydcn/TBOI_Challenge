<?php 

namespace App\Service;

use App\Model\DiscordUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DiscordApiService
{
    const AUTHORIZATION_URI = 'https://discord.com/api/oauth2/authorize';

    const USERS_ME_ENDPOINT = '/api/users/@me';

    public function __construct(
        private readonly HttpClientInterface $discordApiClient,
        private readonly SerializerInterface $serializer,
        private readonly string $clientId,
        private readonly string $redirectUri
    )
    {

    }

    public function getAuthorizationUrl(array $scope): string
    {
        // Déclaration des paramètres de requête pour l'URL d'autorisation
        $queryParameters = http_build_query([
            'client_id' => $this->clientId,          // ID du client OAuth2 (mon application TBOI Challenge sur Discord Developper)
            'redirect_uri' => $this->redirectUri,    // URL de redirection après l'autorisation
            'response_type' => 'token',              // Type de réponse (un token OAuth2)
            'scope' => implode(' ', $scope),         // Les autorisations demandées (identité, email, etc.)
            'prompt' => 'none'                       // Optionnel, permet de ne pas faire apparaitre l'interface de
                                                     // connexion et d'automatiquement connecter l'utilisation si son
                                                     // ordinateur est déjà connecté à Discord 
        ]);

        // Construction de l'URL complète d'autorisation en concaténant l'URI d'autorisation de Discord avec les paramètres de requête
        return self::AUTHORIZATION_URI . '?' . $queryParameters;
    }

    public function fetchUser(string $accessToken): DiscordUser
    {
        $response = $this->discordApiClient->request(Request::METHOD_GET, self::USERS_ME_ENDPOINT, [
            'auth_bearer' => $accessToken
        ]);

        $data = $response->getContent();

        return $this->serializer->deserialize($data, DiscordUser::class, 'json');
    }
}
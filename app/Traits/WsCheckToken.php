<?php
namespace App\Traits;

use Illuminate\Config\Repository as Config;
use Laravel\Passport\Passport;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\ValidationData;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\CryptTrait;
use InvalidArgumentException;
/**
 * Created by PhpStorm.
 * User: tanliang
 * Date: 2019/9/9
 * Time: 11:41
 */
trait WsCheckToken
{
    use CryptTrait;
    protected $publicKey;
    /**
     * 验证token
     * @param $jwt
     * @return mixed|string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function check($jwt)
    {
        $key = $this->makeCryptKey('public');

        // Attempt to parse and validate the JWT
        $token = (new Parser())->parse($jwt);
        try {
            if ($token->verify(new Sha256(), $key->getKeyPath()) === false) {
                throw new InvalidArgumentException('Access token could not be verified');
            }
            // Ensure access token hasn't expired
            $data = new ValidationData();
            $data->setCurrentTime(time());

            if ($token->validate($data) === false) {
                throw new InvalidArgumentException('Access token is invalid');
            }

            return  $token->getClaim('sub');
        } catch (\Exception $exception) {
            throw new InvalidArgumentException($exception->getMessage());
        }

        throw new InvalidArgumentException('Access token sub is null');
    }

    /**
     * Create a CryptKey instance without permissions check.
     * @param $type
     * @return CryptKey
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function makeCryptKey($type)
    {
        $key = str_replace('\\n', "\n", app()->make(Config::class)->get('passport.'.$type.'_key'));

        if (! $key) {
            $key = 'file://'.Passport::keyPath('oauth-'.$type.'.key');
        }

        return new CryptKey($key, null, false);
    }
}

<?php
// Copy to Bx24Token.php and configure OAuth client id/secret on the target environment.
// Do not commit real Bitrix24 OAuth secrets or token data.
class Bx24TokenExample
{
    public static function getAccessToken()
    {
        throw new RuntimeException('Configure Bx24Token.php on the target environment.');
    }
}

<?php declare(strict_types=1);
/**
 * PrivateBin
 *
 * a zero-knowledge paste bin
 *
 * @link      https://github.com/PrivateBin/PrivateBin
 * @copyright 2012 Sébastien SAUVAGE (sebsauvage.net)
 * @license   https://www.opensource.org/licenses/zlib-license.php The zlib/libpng License
 */

namespace PrivateBin\Proxy;

use PrivateBin\Configuration;

/**
 * YourlsProxy
 *
 * Forwards a URL for shortening to YOURLS (your own URL shortener) and stores
 * the result.
 */
class YourlsProxy extends AbstractProxy
{
    /**
     * Overrides the abstract parent function to get the proxy URL.
     *
     * @param Configuration $conf
     * @return string
     */
    protected function _getProxyUrl(Configuration $conf): string
    {
        return $conf->getKey('apiurl', 'yourls');
    }

    /**
     * Overrides the abstract parent function to get contents from YOURLS API.
     *
     * @access protected
     * @param Configuration $conf
     * @param string $link
     * @return array
     */
    protected function _getProxyPayload(Configuration $conf, string $link, string $keyword): array
    {
        $payload = [
            'signature' => $conf->getKey('signature', 'yourls'),
            'format'    => 'json',
            'action'    => 'shorturl',
            'url'       => $link,
        ];
        if (preg_match('/\A[0-9]{1,5}\z/', $keyword)) {
            $payload['keyword'] = $keyword;
        }
        return [
            'method'  => 'POST',
            'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($payload),
        ];
    }

    /**
     * Extracts the short URL from the YOURLS API response.
     *
     * @access protected
     * @param array $data
     * @return ?string
     */
    protected function _extractShortUrl(array $data): ?string
    {
        if ((int) ($data['statusCode'] ?? 0) === 200) {
            return $data['shorturl'] ?? null;
        }
        return null;
    }

    /**
     * Returns a specific error when YOURLS rejects an already-used keyword.
     *
     * @param array $data
     * @return string
     */
    protected function _getError(array $data): string
    {
        if (stripos((string) ($data['message'] ?? ''), 'already exists') !== false) {
            return 'Short URL number is already in use.';
        }
        return parent::_getError($data);
    }
}
